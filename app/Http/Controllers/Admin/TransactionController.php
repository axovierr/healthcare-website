<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment; 
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // PENTING: Tambahkan 'telemedicineSession' di eager load
        $appointments = Appointment::with([
            'patient.user', 
            'doctor.user',
            'telemedicineSession' // <-- RELASI BARU
        ])
        ->orderBy('date', 'desc')
        ->paginate(15); 

        return view('admin.transactions.index', [
            'appointments' => $appointments,
        ]);
    }
}