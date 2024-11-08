<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

class OTPController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $otp = rand(10000, 99999);
        $tanggal_kadaluarsa = Carbon::now()->addMinutes(10)->format('d-m-Y H:i:s');

        try {
            $mailData = [
                'otp' => $otp,
                'tanggal_kadaluarsa' => $tanggal_kadaluarsa,
            ];
    
            // Send OTP via email
            Mail::to($request->email)->send(new OtpMail($mailData));
    
            return response()->json(['message' => 'OTP has been sent to your email.', 'OTP' => $otp]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
