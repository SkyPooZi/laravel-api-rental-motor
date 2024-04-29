<?php

namespace App\Http\Controllers;

use App\Models\Midtrans;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\History;
use Illuminate\Support\Facades\Validator;

class MidtransController extends Controller
{
    public function showPaymentPage(Request $request)
    {
        // Validate the request data
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

        $order_id = rand();
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

        // Menyimpan data ke dalam tabel history
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $response = [
                'status' => 200,
                'message' => 'Data midtrans berhasil ditambahkan',
                'snapToken' => $snapToken,
                'payment_type' => $history->metode_pembayaran,
                'payment_date' => now(),
            ];

            // Check if the request is expecting JSON response
            if ($request->expectsJson()) {
                return response()->json($response);
            } else {
                $view = view('midtrans_view', compact('snapToken'))->render(); // Render view to string
                echo $view; // Output view

                // Jalankan kode di bawah view di sini
                $notif = new Notification();

                // Memeriksa apakah objek $notif berhasil diinisialisasi
                if ($notif) {
                    $transaction = $notif->transaction_status;
                    $type = $notif->payment_type;
                    $order_id = $notif->order_id;
                    $fraud = $notif->fraud_status;

                    if ($transaction == 'capture') {
                        if ($type == 'credit_card' && $fraud == 'accept') {
                            echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                        }
                    } else if ($transaction == 'pending') {
                        $midtrans = Midtrans::create([
                            'history_id' => $request->history_id,
                            'no_pemesanan' => $order_id,
                            'tanggal_pemesanan' => $history->created_at,
                            'tanggal_pembayaran' => now(),
                            'metode_pembayaran' => $history->metode_pembayaran,
                            'status_pembayaran' => 'Belum Lunas',
                            'total_pemesanan' => $subtotal,
                        ]);
                    } else if ($transaction == 'settlement') {
                        $updateMidtrans = Midtrans::where('no_pemesanan', $order_id)->first();
                        if ($updateMidtrans) {
                            $updateMidtrans->update(['status_pembayaran' => 'Lunas']);
                            echo "Status pembayaran untuk order_id: " . $order_id . " berhasil diubah menjadi Lunas.";
                        } else {
                            echo "Order ID tidak ditemukan.";
                        }
                    } else if ($transaction == 'deny') {
                        echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
                    } else if ($transaction == 'expire') {
                        echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
                    } else if ($transaction == 'cancel') {
                        echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
                    }
                } else {
                    // Tangani jika objek $notif tidak berhasil diinisialisasi
                    echo "Gagal menginisialisasi objek Notifikasi Midtrans.";
                }
            }
        }
    }

    public function index()
    {
        $midtrans = Midtrans::all();

        if ($midtrans->count() > 0) {
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
