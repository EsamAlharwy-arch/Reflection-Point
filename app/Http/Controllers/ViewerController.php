<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewerController extends Controller
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

    public function portal(Request $request)
    {
        $host = $request->getHost();
        
        // If it's a domain name (production/Render), use the current public URL
        if ($host !== 'localhost' && $host !== '127.0.0.1' && !filter_var($host, FILTER_VALIDATE_IP)) {
            $vaultPortalUrl = $request->getSchemeAndHttpHost() . $request->getBaseUrl() . "/vault";
        } else {
            // If it's local development, use the local network IP so devices on the same Wi-Fi can connect
            $networkIp = $this->getNetworkIp();
            $port = $request->getPort();
            $baseUrl = $request->getBaseUrl();
            $vaultPortalUrl = "http://{$networkIp}" . ($port && $port != 80 ? ":{$port}" : "") . $baseUrl . "/vault";
        }
        
        return view('viewer.portal', compact('vaultPortalUrl'));
    }

    public function vault(Request $request)
    {
        $files = \App\Models\File::orderBy('filename', 'asc')->get();
        return view('viewer.vault', compact('files'));
    }

    public function view(Request $request, $token)
    {
        $file = \App\Models\File::where('token', $token)->firstOrFail();

        // Log access
        \App\Models\AccessLog::create([
            'file_id' => $file->id,
            'ip_address' => $request->ip(),
            'accessed_at' => now(),
        ]);

        return view('viewer.show', compact('file'));
    }

    public function stream($token)
    {
        $file = \App\Models\File::where('token', $token)->firstOrFail();
        $path = storage_path('app/' . $file->path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => $file->mime_type,
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Content-Disposition' => 'inline; filename="' . $file->filename . '"'
        ]);
    }
}
