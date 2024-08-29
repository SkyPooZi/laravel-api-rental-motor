<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class NotificationController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'history_id' => 'required',
            'pesan' => 'required|string',
            'no_telp' => 'required|string',
            'email' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $history_id = $request->history_id;
            $pesan = $request->pesan;
            $no_telp = $request->no_telp;
            $email = $request->email;

            $notification = Notification::create([
                'history_id' => $history_id,
                'pesan' => $pesan,
            ]);

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
                    "whatsapp:$no_telp",
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

                Mail::to($email)->send(new NotificationMail($mailData));
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Email notifikasi gagal dikirim.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            if($notification){
                return response()->json([
                    'status' => 200,
                    'message' => 'WhatsApp notifikasi berhasil dikirim. Data notification user berhasil ditambahkan',
                    'notification' => [
                        "id" => $notification->id,
                        "history_id" => $notification->history_id,
                        "pesan" => $notification->pesan,
                        "updated_at" => $notification->updated_at,
                        "created_at"=> $notification->created_at,
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'WhatsApp notifikasi gagal dikirim. Data notification user gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function index()
    {
        $notification = Notification::with(['user', 'listMotor', 'diskon', 'ulasan'])->get();

        if($notification->count() > 0 ){
            return response()->json([
                'status' => 200,
                'notification' => $notification,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data notification user tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required',
            'label' => 'required|string',
            'pesan' => 'required|string',
            'no_telp' => 'required|string',
            'tanggal_notif' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $notification = Notification::create([
                'pengguna_id' => $request->pengguna_id,
                'label' => $request->label,
                'pesan' => $request->pesan,
                'no_telp' => $request->no_telp,
                'tanggal_notif' => $request->tanggal_notif,
            ]);

            if($notification){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data notification user berhasil ditambahkan',
                    'notification' => [
                        "id" => $notification->id,
                        "pengguna_id" => $notification->pengguna_id,
                        "label" => $notification->label,
                        "pesan" => $notification->pesan,
                        "no_telp" => $notification->no_telp,
                        "tanggal_notif" => $notification->tanggal_notif,
                        "updated_at" => $notification->updated_at,
                        "created_at"=> $notification->created_at,
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Data notification user gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $notification = Notification::with(['user', 'listMotor', 'diskon', 'ulasan'])->find($id);
        
        if($notification){
            return response()->json([
                'status' => 200,
                'notification' => $notification,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data notification user tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string',
            'pesan' => 'required|string',
            'no_telp' => 'required|string',
            'tanggal_notif' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $notification = Notification::find($id);
            if($notification){ 
                $notification->fill($request->only([
                    'label',
                    'pesan',
                    'no_telp',
                    'tanggal_notif',
                ]));
            
                $notification->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data notification user berhasil diubah',
                    'notification' => $notification,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Data notification user gagal diubah',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);
        if($notification){
            $notification->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data notification user berhasil dihapus',
                'notification' => $notification,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data notification user tidak ditemukan',
            ], 404);
        }
    }
}
