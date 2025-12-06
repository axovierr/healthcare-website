<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found');
        }

        // Count appointments for today that are actually booked (paid or has schedule_id)
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('date', today())
            ->where(function($q) {
                $q->where('payment_status', 'paid')
                  ->orWhereNotNull('schedule_id');
            })
            ->count();

        return view('doctor.dashboard', compact('doctor', 'todayAppointments'));
    }
}
