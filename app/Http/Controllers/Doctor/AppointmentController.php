<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Notification; // <--- PENTING: Model Notification wajib di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Menampilkan daftar janji temu hari ini.
     */
    public function today()
    {
        $doctorId = Auth::id();

        $appointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', today())
            ->where(function($q) {
                // Filter status pembayaran atau jadwal (sesuaikan dengan logic app kamu)
                $q->where('payment_status', 'paid')
                  ->orWhereNotNull('schedule_id');
            })
            ->with(['patient', 'schedule']) // Pastikan relasi patient ada di model Appointment
            ->orderBy('start_time')
            ->get();

        return view('doctor.appointments.today', compact('appointments'));
    }

    /**
     * Memulai sesi konsultasi & Mengirim Notifikasi ke Pasien.
     */
    public function start(Request $request, Appointment $appointment)
    {
        // 1. Validasi: Pastikan appointment ini milik dokter yang sedang login
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action. Ini bukan pasien Anda.');
        }

        // 2. Update Status Appointment
        // Pastikan kolom 'status' ada di tabel appointments kamu (enum: pending, processing, completed, cancelled)
        $appointment->update([
            'status' => 'processing'
        ]);

        // 3. Sistem Kirim Notifikasi ke Pasien
        Notification::create([
            'user_id' => $appointment->patient_id, // Mengirim ke ID Pasien
            'title'   => 'Pemeriksaan Dimulai',
            'message' => 'Dokter ' . Auth::user()->name . ' telah memulai sesi konsultasi Anda. Mohon bersiap.',
            'type'    => 'info',
            'is_read' => false,
        ]);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Status diperbarui menjadi Processing. Notifikasi dikirim ke pasien.');
    }

    /**
     * Fitur Tambahan: Kirim Link Zoom/Meet Manual ke Notifikasi Pasien
     */
    public function sendZoomLink(Request $request, Appointment $appointment)
    {
        // 1. Validasi Input
        $request->validate([
            'zoom_link' => 'required|url',
            'message'   => 'nullable|string',
        ]);

        // 2. Validasi Kepemilikan
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        // 3. Simpan ke Tabel Notifications
        Notification::create([
            'user_id' => $appointment->patient_id, // ID Pasien target
            'title'   => 'Link Telemedicine Masuk',
            'message' => ($request->message ?? 'Silakan bergabung untuk konsultasi.') . ' Link: ' . $request->zoom_link,
            'type'    => 'action', // Tipe notifikasi (bisa disesuaikan)
            'is_read' => false,
        ]);

        // Opsional: Simpan link ke tabel appointment juga jika perlu
        // $appointment->update(['meet_link' => $request->zoom_link]); 

        return back()->with('success', 'Link Zoom berhasil dikirim ke notifikasi pasien!');
    }
}