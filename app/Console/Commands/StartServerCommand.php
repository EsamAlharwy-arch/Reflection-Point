<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrvault:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the QRVault server and open the admin dashboard with the correct network IP.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ip = '127.0.0.1'; // Fallback
        try {
            if (function_exists('socket_create')) {
                // Trick to get the active network IP (Wi-Fi/LAN) by simulating a UDP connection.
                $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
                @socket_connect($sock, "8.8.8.8", 53);
                socket_getsockname($sock, $ip);
                socket_close($sock);
            } elseif (PHP_OS_FAMILY === 'Windows') {
                // Fallback for Windows if sockets extension is disabled
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

        $url = "http://{$ip}:8000";
        
        $this->info("=========================================");
        $this->info("🚀 Starting QRVault Secure Server...");
        $this->info("🌍 Network IP Detected: {$ip}");
        $this->info("=========================================");
        $this->info("Opening browser to Portal...");

        // Open the browser automatically depending on the OS
        if (PHP_OS_FAMILY === 'Windows') {
            pclose(popen("start \"\" \"{$url}\"", "r"));
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            exec("open \"{$url}\"");
        } elseif (PHP_OS_FAMILY === 'Linux') {
            exec("xdg-open \"{$url}\"");
        }

        // Start the Laravel server
        $this->call('serve', [
            '--host' => '0.0.0.0',
            '--port' => 8000
        ]);
    }
}
