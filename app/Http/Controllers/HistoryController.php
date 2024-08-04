<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;

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
            'no_telp' => 'required|string|max:20',
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
                'no_telp' => $request->no_telp,
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
                        "no_telp" => $history->no_telp,
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
        $this->updatePendingPaymentStatus();

        $this->updateOrderedStatus();

        $this->updateInUseStatus();
    }

    private function updatePendingPaymentStatus()
    {
        $pendingHistories = History::where('status_history', 'Menunggu Pembayaran')
            ->where('created_at', '<', Carbon::now()->subDay())
            ->get();

        foreach ($pendingHistories as $history) {
            $history->status_history = 'Dibatalkan';
            $history->save();
        }
    }

    private function updateOrderedStatus()
    {
        $orderedHistories = History::where('status_history', 'Dipesan')
            ->where('tanggal_mulai', '<=', Carbon::now())
            ->get();

        foreach ($orderedHistories as $history) {
            $history->status_history = 'Sedang Digunakan';
            $history->save();
        }
    }

    private function updateInUseStatus()
    {
        $inUseHistories = History::where('status_history', 'Sedang Digunakan')
            ->where('tanggal_selesai', '<=', Carbon::now())
            ->get();

        foreach ($inUseHistories as $history) {
            $history->status_history = 'Selesai';
            $history->save();
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
            'no_telp' => 'string',
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
                    'no_telp',
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
