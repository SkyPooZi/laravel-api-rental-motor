<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use App\Models\User;
use App\Models\Notification;
use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DiskonController extends Controller
{
    public function index()
    {
        $diskon = Diskon::all();

        if($diskon->count() > 0 ){
            return response()->json([
                'status' => 200,
                'diskon' => $diskon,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data diskon tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|file|image|max:2048',
            'nama_diskon' => 'required|string|max:191',
            'potongan_harga' => 'required|int|max:20',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'is_hidden' => 'required|boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $gambar = null;
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar')->store('images', 'public');
            }

            $diskon = Diskon::create([
                'gambar' => $gambar,
                'nama_diskon' => $request->nama_diskon,
                'potongan_harga' => $request->potongan_harga,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_hidden' => $request->is_hidden,
            ]);

            $users = User::where('peran', 'user')->get(); // Get all users with role 'user'
        
            foreach ($users as $user) {
                // SendNotificationDiscountJob::dispatch($user, $diskon);
                $pesan = "
🔥 Penawaran Spesial! Diskon {$diskon->potongan_harga}% untuk {$diskon->nama_diskon}! 🔥
Diskon berlaku mulai {$diskon->tanggal_mulai} hingga {$diskon->tanggal_selesai}.
";

                $formattedMessage = "
*Notifkasi Rental Motor Kudus*

------------------------------------------------------------------------------------------

🔥 Penawaran Spesial! Diskon {$diskon->potongan_harga}% untuk {$diskon->nama_diskon}! 🔥
Jangan lewatkan kesempatan ini untuk menikmati perjalanan Anda dengan harga lebih hemat! 🚀
Segera sewa motor pilihan Anda dan rasakan perbedaannya. ✨
Diskon berlaku mulai {$diskon->tanggal_mulai} hingga {$diskon->tanggal_selesai}.
Pesan sekarang sebelum kehabisan! 🚴💨

Terima Kasih,
Rental Motor Kudus

------------------------------------------------------------------------------------------

Rental Motor Kudus
Trengguluh, Honggosoco, Kec. Jekulo, Kabupaten Kudus, Jawa Tengah
Indonesia
";

                // try {
                //     $sid    = env('TWILIO_SID');
                //     $token  = env('TWILIO_AUTH_TOKEN');
                //     $twilio = new Client($sid, $token);

                //     $twilio->messages->create(
                //         "whatsapp:{$user->nomor_hp}", // Using the user's phone number
                //         [
                //             "from" => env('TWILIO_WHATSAPP_FROM'),
                //             "body" => $formattedMessage
                //         ]
                //     );
                // } catch (\Exception $e) {
                //     \Log::error("WhatsApp notifikasi gagal dikirim ke {$user->nomor_hp}: " . $e->getMessage());
                // }

                try {
                    $mailData = [
                        'pesan' => $pesan,
                    ];

                    Mail::to($user->email)->send(new NotificationMail($mailData));
                } catch (\Exception $e) {
                    Log::error("Email notifikasi gagal dikirim ke {$user->email}: " . $e->getMessage());
                }

                $notifikasi = Notification::create([
                    'pengguna_id' => $user->id,
                    'diskon_id' => $diskon->id,
                    'pesan' => $pesan,
                ]);
            }

            if($diskon){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data diskon berhasil ditambahkan dan Email notifikasi berhasil dikirim.',
                    'diskon' => [
                        "id" => $diskon->id,
                        "gambar" => $diskon->gambar,
                        "nama_diskon" => $diskon->nama_diskon,
                        "potongan_harga" => $diskon->potongan_harga,
                        "tanggal_mulai" => $diskon->tanggal_mulai,
                        "tanggal_selesai" => $diskon->tanggal_selesai,
                        "kode_diskon" => $diskon->kode_diskon,
                        "is_hidden" => $diskon->is_hidden,
                        "updated_at" => $diskon->updated_at,
                        "created_at" => $diskon->created_at,
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Data diskon gagal ditambahkan dan WhatsApp notifikasi gagal dikirim.',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $diskon = Diskon::find($id);
        if($diskon){
            return response()->json([
                'status' => 200,
                'diskon' => $diskon,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data diskon tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'file|image|max:2048',
            'nama_diskon' => 'string|max:191',
            'potongan_harga' => 'int|max:20',
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_hidden' => 'boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $diskon = Diskon::find($id);
            if($diskon){
                if ($request->hasFile('gambar')) {
                    if ($diskon->gambar) {
                        Storage::disk('public')->delete($diskon->gambar);
                    }
                    $diskon->gambar = $request->file('gambar')->store('images', 'public');
                }

                $diskon->fill($request->only([
                    'nama_diskon',
                    'potongan_harga',
                    'tanggal_mulai',
                    'tanggal_selesai',
                    'is_hidden',
                ]));
            
                $diskon->save();
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Data diskon berhasil diubah',
                    'diskon' => $diskon,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Data diskon tidak ada atau tidak ditemukan',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $diskon = Diskon::find($id);
        if($diskon){
            $diskon->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data diskon berhasil dihapus',
                'diskon' => $diskon,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data diskon tidak ditemukan',
            ], 404);
        }
    }
}
