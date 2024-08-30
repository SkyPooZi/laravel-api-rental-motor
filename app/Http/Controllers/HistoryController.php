<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Twilio\Rest\Client;

class HistoryController extends Controller
{
    public function index()
    {
        $history = History::with(['user', 'listMotor', 'diskon', 'ulasan'])->get();

        if($history->count() > 0) {
            return response()->json([
                'status' => 200,
                'history' => $history,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data history user tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'nomor_hp' => 'required|string|max:20',
            'akun_sosmed' => 'required|string|max:255',
            'alamat' => 'required|string',
            'penyewa' => 'required|string',
            'motor_id' => 'required',
            'tanggal_mulai' => 'required|date_format:Y-m-d H:i:s',
            'durasi' => 'required|int',
            'tanggal_selesai' => 'required|date_format:Y-m-d H:i:s',
            'keperluan_menyewa' => 'required|string|max:255',
            'penerimaan_motor' => 'required|string',
            'nama_kontak_darurat' => 'required|string',
            'nomor_kontak_darurat' => 'required|string',
            'hubungan_dengan_kontak_darurat' => 'required|string',
            'diskon_id' => 'nullable',
            'metode_pembayaran' => 'required|string',
            'total_pembayaran' => 'required|int',
            'status_history' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $history = History::create([
                'pengguna_id' => $request->pengguna_id,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'akun_sosmed' => $request->akun_sosmed,
                'alamat' => $request->alamat,
                'penyewa' => $request->penyewa,
                'motor_id' => $request->motor_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'durasi' => $request->durasi,
                'tanggal_selesai' => $request->tanggal_selesai,
                'keperluan_menyewa' => $request->keperluan_menyewa,
                'penerimaan_motor' => $request->penerimaan_motor,
                'nama_kontak_darurat' => $request->nama_kontak_darurat,
                'nomor_kontak_darurat' => $request->nomor_kontak_darurat,
                'hubungan_dengan_kontak_darurat' => $request->hubungan_dengan_kontak_darurat,
                'diskon_id' => $request->diskon_id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_pembayaran' => $request->total_pembayaran,
                'status_history' => $request->status_history,
            ]);
    
            if($history) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data history user berhasil ditambahkan',
                    'history' => [
                        "id" => $history->id,
                        "pengguna_id" => $history->pengguna_id,
                        "nama_lengkap" => $history->nama_lengkap,
                        "email" => $history->email,
                        "nomor_hp" => $history->nomor_hp,
                        "akun_sosmed" => $history->akun_sosmed,
                        "alamat" => $history->alamat,
                        "penyewa" => $history->penyewa,
                        "motor_id" => $history->motor_id,
                        "tanggal_mulai" => $history->tanggal_mulai,
                        "durasi" => $history->durasi,
                        "tanggal_selesai" => $history->tanggal_selesai,
                        "keperluan_menyewa" => $history->keperluan_menyewa,
                        "penerimaan_motor" => $history->penerimaan_motor,
                        "nama_kontak_darurat" => $history->nama_kontak_darurat,
                        "nomor_kontak_darurat" => $history->nomor_kontak_darurat,
                        "hubungan_dengan_kontak_darurat" => $history->hubungan_dengan_kontak_darurat,
                        "diskon_id" => $history->diskon_id,
                        "metode_pembayaran" => $history->metode_pembayaran,
                        "total_pembayaran" => $history->total_pembayaran,
                        "status_history" => $history->status_history,
                        "ulasan_id" => $history->ulasan_id,
                        "tanggal_pembatalan" => $history->tanggal_pembatalan,
                        "alasan_pembatalan" => $history->alasan_pembatalan,
                        "updated_at" => $history->updated_at,
                        "created_at" => $history->created_at,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data history user gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $history = History::with(['user', 'listMotor', 'diskon', 'ulasan'])->find($id);

        if($history) {
            return response()->json([
                'status' => 200,
                'history' => $history,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data history user tidak ditemukan',
            ], 404);
        }
    }

    public function updateStatuses()
    {
        $this->notifyPendingPaymentStatus();
        $this->notifyOrderedStatus();
        $this->notifyInUseStatus();

        $this->updatePendingPaymentStatus();
        $this->updateOrderedStatus();
        $this->updateInUseStatus();
    }

    private function notifyPendingPaymentStatus()
    {
        \Log::info('Schedule Notification Menunggu Pembayaran: ' . now());
        $histories = History::where('status_history', 'Menunggu Pembayaran')
            ->where('created_at', '<', Carbon::now()->subHours(22))
            ->get();

        foreach ($histories as $history) {
            $notificationExists = Notification::where('history_id', $history->id)
                ->where('status_history', 'Menunggu Pembayaran')
                ->exists();

            if (!$notificationExists) {
                $pesan = "Halo {$history->nama_lengkap}, Anda memiliki waktu 2 jam lagi untuk menyelesaikan pembayaran untuk pesanan Anda. Jika tidak, pesanan Anda akan otomatis dibatalkan.";
                $this->sendNotification($history, $pesan);
            }
        }
        \Log::info('Schedule Notification Menunggu Pembayaran Stop: ' . now());
    }

    private function notifyOrderedStatus()
    {
        \Log::info('Schedule Notification Dipesan: ' . now());
        $histories = History::where('status_history', 'Dipesan')
            ->where('tanggal_mulai', '<=', Carbon::now()->addHours(2))
            ->get();

        foreach ($histories as $history) {
            $notificationExists = Notification::where('history_id', $history->id)
                ->where('status_history', 'Dipesan')
                ->exists();

            if (!$notificationExists) {
                $pesan = "Halo {$history->nama_lengkap}, motor yang Anda pesan akan segera siap dalam 2 jam. Mohon bersiap untuk mengambil atau menerima motor Anda.";
                $this->sendNotification($history, $pesan);
            }
        }
        \Log::info('Schedule Notification Dipesan Stop: ' . now());
    }

    private function notifyInUseStatus()
    {
        \Log::info('Schedule Notification Sedang Digunakan: ' . now());
        $histories = History::where('status_history', 'Sedang Digunakan')
            ->where('tanggal_selesai', '<=', Carbon::now()->addHours(2))
            ->get();

        foreach ($histories as $history) {
            $notificationExists = Notification::where('history_id', $history->id)
                ->where('status_history', 'Sedang Digunakan')
                ->exists();

            if (!$notificationExists) {
                $pesan = "Halo {$history->nama_lengkap}, motor yang Anda gunakan harus dikembalikan dalam 2 jam. Jika Anda melebihi waktu yang ditentukan, Anda akan dikenakan biaya tambahan sebesar 1 hari sesuai dengan motor yang Anda booking.";
                $this->sendNotification($history, $pesan);
            }
        }
        \Log::info('Schedule Notification Sedang Digunakan Stop: ' . now());
    }

    private function sendNotification($history, $pesan)
    {
        \Log::info('Schedule Notification ' . $history->status_history . ' Running: ' . now());
        $nomor_hp = $history->nomor_hp;

        $formattedMessage = "
*Notifkasi Rental Motor Kudus*

------------------------------------------------------------------------------------------

$pesan

Terima Kasih,
Rental Motor Kudus

------------------------------------------------------------------------------------------

Rental Motor Kudus
Trengguluh, Honggosoco, Kec. Jekulo, Kabupaten Kudus, Jawa Tengah
Indonesia
";

        try {
            $sid    = env('TWILIO_SID');
            $token  = env('TWILIO_AUTH_TOKEN');
            $twilio = new Client($sid, $token);

            $twilio->messages->create(
                "whatsapp:$nomor_hp",
                [
                    "from" => env('TWILIO_WHATSAPP_FROM'),
                    "body" => $formattedMessage
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'WhatsApp notifikasi gagal dikirim.',
                'error' => $e->getMessage(),
            ], 500);
        }

        try {
            $mailData = [
                'pesan' => $pesan,
            ];

            Mail::to($history->email)->send(new NotificationMail($mailData));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Email notifikasi gagal dikirim.',
                'error' => $e->getMessage(),
            ], 500);
        }

        $notification = Notification::create([
            'history_id' => $history->id,
            'status_history' => $history->status_history,
            'pesan' => $pesan,
        ]);

        \Log::info('Notification Create Data: ' . $notification);
        \Log::info('Schedule Notification Stop: ' . now());
    }

    private function updatePendingPaymentStatus()
    {
        \Log::info('Schedule Update Status Menunggu Pembayaran: ' . now());
        $pendingHistories = History::where('status_history', 'Menunggu Pembayaran')
            ->where('created_at', '<', Carbon::now()->subDay())
            ->get();

        foreach ($pendingHistories as $history) {
            $history->status_history = 'Dibatalkan';
            $history->save();
            \Log::info('Notification Update Status Menunggu Pembayara Data: ' . $history);
        }
        \Log::info('Schedule Update Status Menunggu Pembayaran Stop: ' . now());
    }

    private function updateOrderedStatus()
    {
        \Log::info('Schedule Update Status Dipesan: ' . now());
        $orderedHistories = History::where('status_history', 'Dipesan')
            ->where('tanggal_mulai', '<=', Carbon::now())
            ->get();

        foreach ($orderedHistories as $history) {
            $history->status_history = 'Sedang Digunakan';
            $history->save();
            \Log::info('Notification Update Status Dipesan Data: ' . $history);
        }
        \Log::info('Schedule Update Status Dipesan Stop: ' . now());
    }

    private function updateInUseStatus()
    {
        \Log::info('Schedule Update Status Sedang Digunakan: ' . now());
        $inUseHistories = History::where('status_history', 'Sedang Digunakan')
            ->where('tanggal_selesai', '<=', Carbon::now())
            ->get();

        foreach ($inUseHistories as $history) {
            $history->status_history = 'Selesai';
            $history->save();
            \Log::info('Notification Update Status Sedang Digunakan Data: ' . $history);
        }
        \Log::info('Schedule Update Status Sedang Digunakan Stop: ' . now());
    }

    public function getFilteredStatusHistory(Request $request)
    {
        $filter = $request->query('filter', 'Semua');

        if ($filter === 'Semua') {
            $history = History::with(['user', 'listMotor', 'diskon', 'ulasan'])->get();
        } else {
            $history = History::with(['user', 'listMotor', 'diskon', 'ulasan'])
                ->where('status_history', $filter)
                ->get();
        }

        if ($history->count() > 0) {
            return response()->json([
                'status' => 200,
                'history' => $history,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data history user tidak ditemukan',
            ], 404);
        }
    }

    public function getFilteredHistory(Request $request)
    {
        $filter = $request->query('filter', '7_hari');
        $now = Carbon::now();

        switch ($filter) {
            case '4_minggu':
                $startDate = $now->copy()->startOfWeek()->subWeeks(4);
                break;
            case '1_bulan':
                $startDate = $now->copy()->startOfMonth()->subMonth();
                break;
            case '6_bulan':
                $startDate = $now->copy()->startOfMonth()->subMonths(6);
                break;
            case '5_tahun':
                $startDate = $now->copy()->startOfYear()->subYears(5);
                break;
            case '7_hari':
            default:
                $startDate = $now->copy()->startOfWeek()->subDays(7);
                break;
        }

        $histories = History::where('tanggal_mulai', '>=', $startDate)->get();

        $data = $histories->map(function ($history) use ($filter) {
            $tanggalMulai = Carbon::parse($history->tanggal_mulai);
            $infoTambahan = [];

            $infoTambahan['hari_dalam_minggu'] = $tanggalMulai->format('l');
            $infoTambahan['minggu_dalam_bulan'] = $tanggalMulai->weekOfMonth;
            $infoTambahan['bulan'] = $tanggalMulai->format('F');
            $infoTambahan['tahun'] = $tanggalMulai->year;

            return array_merge($history->toArray(), $infoTambahan);
        });

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'string',
            'email' => 'string',
            'nomor_hp' => 'string',
            'akun_sosmed' => 'string',
            'alamat' => 'string',
            'penyewa' => 'string',
            'motor_id' => '',
            'tanggal_mulai' => 'date_format:Y-m-d H:i:s',
            'durasi' => 'int',
            'tanggal_selesai' => 'date_format:Y-m-d H:i:s',
            'keperluan_menyewa' => 'string|max:255',
            'penerimaan_motor' => 'string',
            'nama_kontak_darurat' => 'string',
            'nomor_kontak_darurat' => 'string',
            'hubungan_dengan_kontak_darurat' => 'string',
            'diskon_id' => '',
            'metode_pembayaran' => 'string',
            'total_pembayaran' => 'int',
            'status_history' => 'string',
            'ulasan_id' => 'unique:histories',
            'tanggal_pembatalan' => 'date',
            'alasan_pembatalan' => 'string|max:255',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $history = History::find($id);

            if($history) {
                $history->fill($request->only([
                    'nama_lengkap',
                    'email',
                    'nomor_hp',
                    'akun_sosmed',
                    'alamat',
                    'penyewa',
                    'motor_id',
                    'tanggal_mulai',
                    'durasi',
                    'tanggal_selesai',
                    'keperluan_menyewa',
                    'penerimaan_motor',
                    'nama_kontak_darurat',
                    'nomor_kontak_darurat',
                    'hubungan_dengan_kontak_darurat',
                    'diskon_id',
                    'metode_pembayaran',
                    'total_pembayaran',
                    'status_history',
                    'ulasan_id',
                    'tanggal_pembatalan',
                    'alasan_pembatalan',
                ]));
            
                $history->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data history user berhasil diupdate',
                    'history' => $history,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data history user tidak ditemukan',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $history = History::find($id);

        if($history) {
            $history->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data history user berhasil dihapus',
                'history' => $history,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data history user tidak ditemukan',
            ], 404);
        }
    }
}
