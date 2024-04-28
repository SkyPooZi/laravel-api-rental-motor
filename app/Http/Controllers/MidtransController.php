<?php

namespace App\Http\Controllers;

use App\Models\Midtrans;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\User;
use App\Models\History;
use App\Models\ListMotor;
use Illuminate\Support\Facades\Validator;

class MidtransController extends Controller
{
    public function showPaymentPage(Request $request)
    {
        $history = History::find($request->id);
        if (!$history) {
            return response()->json([
                'status' => 404,
                'message' => 'Data history tidak ditemukan',
            ], 404);
        }

        // Memuat objek User terkait dengan History
        $user = $history->user;
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Data user tidak ditemukan',
            ], 404);
        }

        // Memuat objek ListMotor terkait dengan History
        $listMotor = $history->listMotor;
        if (!$listMotor) {
            return response()->json([
                'status' => 404,
                'message' => 'Data motor tidak ditemukan',
            ], 404);
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
        
        $order_id = uniqid() . '-' . rand();
        $subtotal = $listMotor->harga_motor_per_1_hari * 1;
        
        // Membuat parameter untuk transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $history->total_pembayaran,
            ],
            'customer_details' => [
                'name' => $user->nama_pengguna,
                'phone' => $user->nomor_hp,
                'email' => $user->email,
                'address' => $user->alamat,
            ],
            'shipping_details' => [
                'name' => $user->nama_pengguna,
                'phone' => $user->nomor_hp,
                'email' => $user->email,
                'address' => $user->alamat,
            ],
            'product_details' => [
                'product_id' => $history->motor_id,
                'product_name' => $listMotor->nama_motor,
                'quantity' => 1,
                'price' => $listMotor->harga_motor_per_1_hari,
                'subtotal' => $subtotal,
            ],
        ];    

        // Mendapatkan token Snap
        $snapToken = Snap::getSnapToken($params);

        return view('midtrans_view', compact('snapToken'));

        $validator = Validator::make($request->all(), [
            'history_id' => 'required',
            'no_pemesanan' => 'required|integer',
            'tanggal_pemesanan' => 'required|date',
            'tanggal_pembayaran' => 'required|date',
            'metode_pembayaran' => 'required|string',
            'status_pembayaran' => 'required|string',
            'total_pemesanan' => 'required|integer',
        ]);

        $response = Midtrans::notification()->response();

        $metode_pembayaran = $response['payment_type'];

        $tanggal_pembayaran = now()->format('d M Y, H:i');

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $midtrans = Midtrans::create([
                'history_id' => $request->history_id,
                'no_pemesanan' => $order_id,
                'tanggal_pemesanan' => $history->created_at,
                'tanggal_pembayaran' => $tanggal_pembayaran,
                'metode_pembayaran' => $metode_pembayaran,
                'status_pembayaran' => 'Lunas',
                'total_pemesanan' => $subtotal,
            ]);
    
            if($history) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data midtrans berhasil ditambahkan',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data midtrans gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function index()
    {
        $midtrans = Midtrans::all();

        if($midtrans->count() > 0) {
            return response()->json([
                'status' => 200,
                'Midtrans' => $midtrans,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data midtrans tidak ditemukan',
            ], 404);
        }
    }
}
