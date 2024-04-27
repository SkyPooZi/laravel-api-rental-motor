<?php

namespace App\Http\Controllers;

use App\Models\Midtrans;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Midtrans\Config;
use Midtrans\Snap;
use User;

class MidtransController extends Controller
{
    public function showPaymentPage(Request $request)
    {

        $user = User::find($request->id);
        $history = History::find($request->id);

        /*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
        composer require midtrans/midtrans-php
                                    
        Alternatively, if you are not using **Composer**, you can download midtrans-php library 
        (https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
        the file manually.   

        require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */

        //SAMPLE REQUEST START HERE

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $userData = $user ? [
            'nama' => $user->nama_pengguna,
            'nomor_hp' => $user->nomor_hp,
            'email' => $user->email,
            'alamat' => $user->alamat,
        ] : [
            'nama' => 'Unknown',
            'nomor_hp' => 'Unknown',
            'email' => 'Unknown',
            'alamat' => 'Unknown',
        ];

        $historyData = $history ?[
            'pengguna_id' => $history->pengguna_id,
            'akun_sosmed' => $history->akun_sosmed,
            'penyewa' => $history->penyewa,
            'motor_id' => $history->motor_id,
            'tanggal_booking' => $history->tanggal_booking,
            'keperluan_menyewa' => $history->keperluan_menyewa,
            'penerimaan_motor' => $history->penerimaan_motor,
            'nama_kontak_darurat' => $history->nama_kontak_darurat,
            'nomor_kontak_darurat' => $history->nomor_kontak_darurat,
            'hubungan_dengan_kontak_darurat' => $history->hubungan_dengan_kontak_darurat,
            'diskon_id' => $history->diskon_id,
            'metode_pembayaran' => $history->metode_pembayaran,
            'total_pembayaran' => $history->total_pembayaran,
        ] : [
            'pengguna_id' => 'Unknown',
            'akun_sosmed' => 'Unknown',
            'penyewa' => 'Unknown',
            'motor_id' => 'Unknown',
            'tanggal_booking' => 'Unknown',
            'keperluan_menyewa' => 'Unknown',
            'penerimaan_motor' => 'Unknown',
            'nama_kontak_darurat' => 'Unknown',
            'nomor_kontak_darurat' => 'Unknown',
            'hubungan_dengan_kontak_darurat' => 'Unknown',
            'diskon_id' => 'Unknown',
            'metode_pembayaran' => 'Unknown',
            'total_pembayaran' => 'Unknown',
        ];
        
        $params = array(
            'transaction_details' => array(
                'order_id' => uniqid() . '-' . rand(), // Combine a unique identifier with a random number
                'gross_amount' => $historyData['total_pembayaran'],
            ),
            'customer_details' => array(
                'pengguna_id' => $historyData['pengguna_id'],
                'email' => $userData['email'],
                'phone' => $userData['nomor_hp'],
            ),
            'product_details' => array(
                'id' => $historyData['motor_id'],
                'price' => $historyData['total_pembayaran'],
                'quantity' => 1,
                'name' => $historyData['keperluan_menyewa'],
            ),
        );    

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('midtrans_view', compact('snapToken'));
    }

    public function index(){
        $midtrans = Midtrans::all();

        if($midtrans->count() > 0){
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

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            // 'no_pemesanan',
            // 'tanggal_pemesanan',
            // 'pengguna_id',
            // 'tanggal_pembayaran',
            // 'metode_pembayaran',
            // 'total_pembayaran_midtrans',
            // 'motor_id',
            // 'diskon_id',
            // 'history_id',
            'no_pemesanan' => 'required|int|max:191',
            'tanggal_pemesanan' => 'required|string',
            'pengguna_id' => 'required',
            'tanggal_pembayaran' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'total_pembayaran_midtrans' => 'required',
            'motor_id' => 'required',
            'diskon_id' => 'required',
            'history_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $midtrans = Midtrans::create([
                'no_pemesanan' => $request->no_pemesanan,
                'tanggal_pemesanan' => $request->tanggal_pemesanan,
                'pengguna_id' => $request->pengguna_id,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_pembayaran_midtrans' => $request->total_pembayaran_midtrans,
                'motor_id' => $request->motor_id,
                'diskon_id' => $request->diskon_id,
                'history_id' => $request->history_id,
            ]);

            if($midtrans){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data midtrans berhasil ditambahkan',
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Data midtrans gagal ditambahkan',
                ], 500);
            }
        }
    }
}