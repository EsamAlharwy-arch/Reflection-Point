<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function getNetworkIp()
    {
        return \Illuminate\Support\Facades\Cache::remember('network_ip', 3600, function() {
            $ip = '127.0.0.1';
            try {
                if (function_exists('socket_create')) {
                    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
                    @socket_connect($sock, "8.8.8.8", 53);
                    socket_getsockname($sock, $ip);
                    socket_close($sock);
                } elseif (PHP_OS_FAMILY === 'Windows') {
                    exec('route print 0.0.0.0', $output);
                    foreach ($output as $line) {
                        if (preg_match('/0\.0\.0\.0\s+0\.0\.0\.0\s+[\d\.]+\s+([\d\.]+)/', $line, $matches)) {
                            $ip = $matches[1];
                            break;
                        }
                    }
                } else {
                    $ip = gethostbyname(gethostname());
                }
            } catch (\Exception $e) {
                $ip = gethostbyname(gethostname());
            }
            return $ip;
        });
    }

    public function index(Request $request)
    {
        // Auto-sync files silently on page load to keep dashboard updated
        \Illuminate\Support\Facades\Artisan::call('qrvault:sync');

        $query = \App\Models\File::latest();
        
        if ($request->filled('search')) {
            $query->where('filename', 'like', '%' . $request->search . '%');
        }

        $files = $query->paginate(12)->withQueryString();
        
        $networkIp = $this->getNetworkIp();
        $port = $request->getPort();
        $baseUrl = "http://{$networkIp}" . ($port && $port != 80 ? ":{$port}" : "") . $request->getBaseUrl();

        return view('admin.dashboard', compact('files', 'baseUrl'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file', 
        ]);

        $file = $request->file('file');
        $destinationPath = storage_path('app/private/uploads');
        
        // Ensure directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $file->getClientOriginalName());

        return redirect()->back()->with('success', 'File uploaded successfully! Please click Sync to generate QR.');
    }

    public function sync(Request $request)
    {
        \Illuminate\Support\Facades\Artisan::call('qrvault:sync');
        return redirect()->back()->with('success', 'Sync Completed Successfully! New files are now available.');
    }
}
