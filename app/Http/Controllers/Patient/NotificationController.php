<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Notification; // Pastikan ini mengarah ke Model custom kamu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the patient's notifications.
     */
    public function index()
    {
        $patientId = Auth::id();

        // 1. Ambil Data Notifikasi dari tabel custom
        // Menggunakan 'patient_id', bukan 'user_id'
        $notifications = Notification::where('patient_id', $patientId)
            ->with('doctor') // Eager load data dokter biar query lebih cepat
            ->latest()       // Urutkan dari yang paling baru
            ->paginate(10);
            
        // 2. Tandai notifikasi yang belum dibaca menjadi sudah dibaca (is_read = true)
        // Kita update secara massal khusus untuk user ini
        Notification::where('patient_id', $patientId)
            ->where('is_read', false) // Cari yang belum dibaca (false / 0)
            ->update(['is_read' => true]); // Ubah jadi dibaca (true / 1)

        return view('patient.notifications.index', compact('notifications'));
    }
}