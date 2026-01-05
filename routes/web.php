<?php

use App\Models\Member;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    // 1. Ambil data Member beserta transaksinya (Eager Loading biar cepat)
    // Pastikan relasi 'transaction_members' ada di model Member
    $members = Member::with('transaction_members')->get();

    // 2. Ambil data Minggu (Week) dan kelompokkan berdasarkan Bulan
    // Format: "January 2025", "February 2025", dst.
    $weeks = Week::orderBy('start_date', 'asc')->get();

    $months = $weeks->groupBy(function ($item) {
        return Carbon::parse($item->start_date)->format('F Y');
    });

    // 3. Kirim data ke view 'welcome'
    return view('welcome', [
        'members' => $members,
        'months' => $months,
    ]);
});

// Custom logout route untuk Filament admin panel
Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('filament.admin.auth.logout');
