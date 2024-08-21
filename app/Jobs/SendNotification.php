<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $history_id;
    protected $pesan;
    protected $no_telp;

    public function __construct($history_id, $pesan, $no_telp)
    {
        $this->history_id = $history_id;
        $this->pesan = $pesan;
        $this->no_telp = $history_id->no_telp;
    }

    public function handle()
    {
        // Run Node.js script to send WhatsApp message
        $scriptPath = storage_path('scripts/notify.js');
        $command = "node {$scriptPath} " . escapeshellarg($this->history_id) . " " . escapeshellarg($this->pesan) . " " . escapeshellarg($this->no_telp);
        $output = shell_exec($command);

        Log::info('WhatsApp Notification Output: ' . $output);
    }
}
