<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor; // Asumsi Anda memiliki model Doctor
use App\Models\Appointment; // Asumsi Anda memiliki model Appointment
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Berdasarkan database Anda:
        // Role Admin = 1, Doctor = 2, Pasien = 3
        
        $rolePasienId = 3; 
        $roleDokterId = 2; 

        // 1. Ambil Data dari Database:
        
        // Card 1: Jumlah Pasien (Role ID = 3)
        $totalPasien = User::where('role_id', $rolePasienId)->count();
        
        // Card 2: Jumlah Dokter (Role ID = 2)
        $totalDokter = User::where('role_id', $roleDokterId)->count(); 
        
        // Card 3: Jumlah Janji Temu (dari tabel appointments)
        // Kita hitung yang statusnya bukan 'cancelled' atau 'pending'
        $totalJanjiTemu = Appointment::whereIn('status', ['scheduled', 'completed'])->count();
        
        // Card 4: Pendapatan (Contoh sederhana, bisa dari tabel transactions atau appointments)
        // Asumsi: Menghitung total fee dari appointment yang telah completed
        // Jika Anda menggunakan kolom fee di Appointment, ini akan lebih akurat
        // $totalPendapatan = Appointment::where('status', 'completed')
        //                              ->sum('doctor_fee'); // Ganti 'doctor_fee' dengan kolom biaya yang benar di tabel Appointment Anda

        // // Format Pendapatan agar mudah dibaca di Blade
        // $pendapatanFormatted = 'Rp' . number_format($totalPendapatan, 0, ',', '.');


        // 2. Kirim Data ke View:
        return view('admin.dashboard', [
            'totalPasien' => $totalPasien,
            'totalDokter' => $totalDokter,
            'totalJanjiTemu' => $totalJanjiTemu,
            // 'pendapatanFormatted' => $pendapatanFormatted,
        ]);
    }
}