<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Notification; // <--- PENTING: Tambahkan Import Model Notification
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function today()
    {
        // Ambil ID User yang sedang login sebagai dokter
        $doctorId = Auth::id();

        // Get appointments for today
        // Kita asumsikan 'payment_status' ada di tabel appointments.
        // Jika tidak ada, hapus bagian ->where('payment_status'...)
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', today())
            ->where(function($q) {
                $q->where('payment_status', 'paid')
                  ->orWhereNotNull('schedule_id');
            })
            // Pastikan relasi 'patient' di model Appointment sudah benar (belongsTo User)
            ->with(['patient', 'schedule']) 
            ->orderBy('start_time')
            ->get();

        return view('doctor.appointments.today', compact('appointments'));
    }

    public function start(Appointment $appointment)
    {
        $doctorId = Auth::id();

        // Verify this appointment belongs to this doctor
        if ($appointment->doctor_id !== $doctorId) {
            abort(403, 'Unauthorized action. Ini bukan pasien Anda.');
        }

        // Check if appointment is paid
        if ($appointment->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Pasien belum melakukan pembayaran.');
        }

        return view('doctor.appointments.consultation', compact('appointment'));
    }

    /**
     * Fitur Baru: Kirim Link Zoom ke Notifikasi Pasien
     */
    public function sendZoomLink(Request $request, Appointment $appointment)
    {
        // 1. Validasi Input
        $request->validate([
            'zoom_link' => 'required|url',
            'message' => 'nullable|string',
        ]);

        // 2. Pastikan dokter yang mengirim adalah dokter yang menangani appointment ini
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        // 3. Simpan ke Tabel Notifications Manual
        Notification::create([
            'patient_id' => $appointment->patient_id, // ID Pasien target
            'doctor_id'  => Auth::id(),               // ID Dokter pengirim
            'title'      => 'Link Telemedicine Masuk',
            // Kita gabungkan pesan dokter dan linknya agar muncul rapi di notifikasi pasien
            'message'    => ($request->message ?? 'Silakan bergabung untuk konsultasi.') . ' Link: ' . $request->zoom_link,
            'is_read'    => false, // Default belum dibaca
        ]);

        // 4. (Opsional) Update status appointment jadi 'Ongoing' atau simpan link di tabel appointment
        // $appointment->update(['meet_link' => $request->zoom_link]); 

        return back()->with('success', 'Link Zoom berhasil dikirim ke notifikasi pasien!');
    }
}