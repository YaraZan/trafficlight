<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic database backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! Storage::exists('backup')) {
            Storage::makeDirectory('backup');
        }

        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";

        $command = "pg_dump --username=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD')
                . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE')
                . " > " . storage_path() . "/app/backup/" . $filename;

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
    }
}
