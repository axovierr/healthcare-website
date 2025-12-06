<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function today()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found');
        }

        // Get appointments for today that are actually booked (paid or has schedule_id)
        \Illuminate\Support\Facades\Log::info('Querying appointments for doctor: ' . $doctor->id);
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('date', today()->toDateString())
            ->where(function($q) {
                $q->where('payment_status', 'paid')
                  ->orWhereNotNull('schedule_id');
            })
            ->with(['patient.user', 'schedule'])
            ->orderBy('start_time')
            ->get();
        \Illuminate\Support\Facades\Log::info('Found ' . $appointments->count() . ' appointments.');

        return view('doctor.appointments.today', compact('appointments'));
    }

    public function start(Appointment $appointment)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found');
        }

        // Verify this appointment belongs to this doctor
        if ($appointment->doctor_id !== $doctor->id) {
            abort(403, 'Unauthorized action');
        }

        // Check if appointment is paid
        if ($appointment->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Pasien belum melakukan pembayaran.');
        }

        return view('doctor.appointments.consultation', compact('appointment'));
    }
}