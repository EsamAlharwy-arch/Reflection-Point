<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrvault:sync';

    protected $description = 'Sync files from the uploads directory to generate secure tokens and QR codes';

    public function handle()
    {
        $this->info('Starting file sync...');

        $directory = storage_path('app/private/uploads');
        if (!is_dir($directory)) {
            $this->error('Directory does not exist: ' . $directory);
            return;
        }

        $files = glob($directory . '/*');
        
        // Cleanup Phase: Remove missing files from database
        $dbFiles = \App\Models\File::all();
        $deletedCount = 0;
        foreach ($dbFiles as $dbFile) {
            $physicalPath = storage_path('app/' . $dbFile->path);
            if (!file_exists($physicalPath)) {
                $dbFile->delete();
                $deletedCount++;
                $this->info("Removed missing file from DB: {$dbFile->filename}");
            }
        }

        $syncedCount = 0;

        foreach ($files as $file) {
            if (is_file($file)) {
                $filename = basename($file);
                
                // Fast check by filename to prevent hashing every file on every page load
                if (!\App\Models\File::where('filename', $filename)->exists()) {
                    $hash = md5_file($file);
                    
                    \App\Models\File::create([
                        'filename' => $filename,
                        'path' => 'private/uploads/' . $filename,
                        'token' => (string) \Illuminate\Support\Str::uuid(),
                        'mime_type' => mime_content_type($file) ?: 'application/octet-stream',
                        'size' => filesize($file),
                        'file_hash' => $hash,
                    ]);
                    
                    $this->info("Synced: {$filename}");
                    $syncedCount++;
                }
            }
        }

        $this->info("Sync complete. {$syncedCount} new files added, {$deletedCount} missing files removed.");
    }
}
