<?php

namespace App\Jobs;

use App\Models\Diskon;
use App\Models\User;
use App\Mail\NotificationMail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationDiscountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $diskon;

    public function __construct(User $user, Diskon $diskon)
    {
        $this->user = $user;
        $this->diskon = $diskon;
    }

    public function handle()
    {
        $pesan = "
        🔥 Penawaran Spesial! Diskon {$this->diskon->potongan_harga}% untuk {$this->diskon->nama_diskon}! 🔥
        Diskon berlaku mulai {$this->diskon->tanggal_mulai} hingga {$this->diskon->tanggal_selesai}.
        ";

        $formattedMessage = "
        *Notifkasi Rental Motor Kudus*
        ...

        Terima Kasih,
        Rental Motor Kudus
        ";

        try {
            $sid    = env('TWILIO_SID');
            $token  = env('TWILIO_AUTH_TOKEN');
            $twilio = new Client($sid, $token);

            $twilio->messages->create(
                "whatsapp:{$this->user->nomor_hp}",
                [
                    "from" => env('TWILIO_WHATSAPP_FROM'),
                    "body" => $formattedMessage
                ]
            );
        } catch (\Exception $e) {
            Log::error("WhatsApp notifikasi gagal dikirim ke {$this->user->nomor_hp}: " . $e->getMessage());
        }

        try {
            $mailData = [
                'pesan' => $pesan,
            ];

            Mail::to($this->user->email)->send(new NotificationMail($mailData));
        } catch (\Exception $e) {
            Log::error("Email notifikasi gagal dikirim ke {$this->user->email}: " . $e->getMessage());
        }
    }
}
