<?php

namespace App\Http\Controllers;

use App\Jobs\DevJob;
use App\Models\FotoMotor;
use App\Models\Lelang;
use App\Models\Motor;
use App\Models\Nasabah;
use App\Models\TransaksiSaldoUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class DevController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $lelang = Lelang::find(22);
        // dd($lelang->waktu_mulai_lelang);
        // dd($lelang->waktu_mulai_lelang->diffInMinutes(now()));
        dd($lelang->waktu_mulai_lelang->diffInMinutes(now()) >= -10 && $lelang->waktu_mulai_lelang->diffInMinutes(now()) <= 0);



        $startOfToday = now();
        $endOfWeek = now()->addDays(7);
        $lelangMingguDepan = Lelang::whereBetween('waktu_mulai_lelang', [$startOfToday, $endOfWeek])->where('status_lelang', 'akan datang')->get();
        [$lelangHariIni, $lelangTanpaHariIni] = $lelangMingguDepan->partition(function ($lelang) {
            return $lelang->waktu_mulai_lelang->isToday();
        });
        dd($lelangMingguDepan, $lelangHariIni, $lelangTanpaHariIni);
        return 'true';
        DevJob::dispatch();
        // id, judul, waktumulailelang, hargaawal, penawaranakhir, statuspembayaran, motor:nama, pemenang:name
        // $return = Nasabah::whereHas('motor.lelang', function ($query) {
        //     $query->where('status_lelang', '!=', 'selesai');
        // })->with('motor.lelang')->get();


        // return $return;

        // dd(Auth::user()->is_admin);
        // dd(auth()->user());
        // $return = Lelang::find(1)->pemenang;
        // $return = $return->lelang;

        // $user = User::with('transaksiSaldoUser')->find(2);
        // $user->transaksiSaldoUser()->create([
        //     'keterangan' => 'test2',
        //     'arus_transaksi' => 'pemasukan',
        //     'nominal' => 2000,
        //     'bukti_transaksi' => 'test2',
        // ]);
        // $return = $user->transaksiSaldoUser;
        // dd($return);
        return 'welcome<br><br>' . $return;
    }
}
