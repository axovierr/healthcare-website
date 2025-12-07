<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord; // Asumsi Anda memiliki model MedicalRecord
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        // Ambil semua Rekam Medis, dan eager load relasi yang diperlukan:
        // 1. patient.user (untuk mendapatkan nama pasien)
        // 2. doctor.user (untuk mendapatkan nama dokter)
        // 3. prescriptions (untuk mendapatkan detail resep)
        $archives = MedicalRecord::with(['patient.user', 'doctor.user', 'prescriptions'])
                                 ->orderBy('visit_date', 'desc')
                                 ->paginate(15); 

        return view('admin.archive.index', [
            'archives' => $archives,
        ]);
    }
}