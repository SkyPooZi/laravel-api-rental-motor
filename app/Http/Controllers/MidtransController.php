<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Midtrans;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\History;
use Illuminate\Support\Facades\Validator;

class MidtransController extends Controller
{
    public function index()
    {
        $midtrans = Midtrans::with(['history.user', 'history.listMotor', 'history.diskon', 'history.ulasan'])->get();;

        if ($midtrans->count() > 0) {
            return response()->json([
                'status' => 200,
                'midtrans' => $midtrans,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data midtrans tidak ditemukan',
            ], 404);
        }
    }

    public function show($id)
    {
        $midtrans = Midtrans::with(['history.user', 'history.listMotor', 'history.diskon', 'history.ulasan'])->find($id);

        if($midtrans) {
            return response()->json([
                'status' => 200,
                'midtrans' => $midtrans,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data midtrans user tidak ditemukan',
            ], 404);
        }
    }

    public function showPaymentPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'history_id' => 'required',
            'no_pemesanan' => 'integer',
            'tanggal_pemesanan' => 'date',
            'tanggal_pembayaran' => 'date',
            'metode_pembayaran' => 'string',
            'status_pembayaran' => 'string',
            'total_pemesanan' => 'integer',
        ]);

        $history = History::find($request->id);
        if (!$history) {
            return response()->json([
                'status' => 404,
                'message' => 'Data history tidak ditemukan',
            ], 404);
        }

        $listMotor = $history->listMotor;
        if (!$listMotor) {
            return response()->json([
                'status' => 404,
                'message' => 'Data motor tidak ditemukan',
            ], 404);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $order_id = rand();
        $subtotal = $listMotor->harga_motor_per_1_hari * 1;

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $history->total_pembayaran,
            ],
            'customer_details' => [
                'name' => $history->nama_pengguna,
                'phone' => $history->nomor_hp,
                'email' => $history->email,
                'address' => $history->alamat,
            ],
            'shipping_details' => [
                'name' => $history->nama_pengguna,
                'phone' => $history->nomor_hp,
                'email' => $history->email,
                'address' => $history->alamat,
            ],
            'product_details' => [
                'product_id' => $history->motor_id,
                'product_name' => $listMotor->nama_motor,
                'quantity' => 1,
                'price' => $listMotor->harga_motor_per_1_hari,
                'subtotal' => $subtotal,
            ],
        ];

        $midtrans = Midtrans::create([
            'history_id' => $request->id,
            'no_pemesanan' => $order_id,
            'tanggal_pemesanan' => $history->created_at,
            'tanggal_pembayaran' => now(),
            'metode_pembayaran' => $history->metode_pembayaran,
            'status_pembayaran' => 'Belum Lunas',
            'total_pemesanan' => $subtotal,
        ]);

        $snapToken = Snap::getSnapToken($params);

        // return view('midtrans_view', compact('snapToken', 'order_id'));

        return response()->json([
            'status' => 200,
            'snapToken' => $snapToken,
            'order_id' => $order_id,
        ], 200);
    }

    public function updateInvoiceMidtrans(Request $request, int $order_id)
    {
        $validator = Validator::make($request->all(), [
            'status_pembayaran' => 'string|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }
    
        $midtrans = Midtrans::where('no_pemesanan', $order_id)->first();
    
        if ($midtrans) {
            $midtrans->status_pembayaran = $request->status_pembayaran;
            $midtrans->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'Status pembayaran berhasil diperbarui',
                'midtrans' => $midtrans,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data midtrans tidak ditemukan',
            ], 404);
        }
    }
}
