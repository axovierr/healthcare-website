<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // Get week parameter from request, default to current week
        $weekOffset = (int) $request->get('week', 0);
        
        // Calculate start and end of week
        $startOfWeek = now()->addWeeks($weekOffset)->startOfWeek();
        $endOfWeek = now()->addWeeks($weekOffset)->endOfWeek();
        
        // Get schedules for the selected week
        // Get schedules for the selected week
        $schedules = DoctorSession::where('doctor_id', Auth::user()->doctor->id)
            ->with('appointment') // Load appointment relation
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        // Optimization: Pre-fetch all paid appointments for this week to avoid N+1 queries in accessor
        $paidAppointments = \App\Models\Appointment::where('doctor_id', Auth::user()->doctor->id)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->where('payment_status', 'paid')
            ->get();

        // Map appointments by date-start_time for O(1) lookup
        $appointmentMap = [];
        foreach ($paidAppointments as $app) {
            $key = $app->date->format('Y-m-d') . '-' . $app->start_time;
            $appointmentMap[$key] = true;
        }

        // Set override on sessions
        foreach ($schedules as $session) {
            // Check linked appointment first (already eager loaded)
            if ($session->appointment && $session->appointment->payment_status === 'paid') {
                $session->is_booked_override = true;
                continue;
            }

            // Check unlinked appointments via map
            $key = $session->date->format('Y-m-d') . '-' . $session->start_time;
            $session->is_booked_override = isset($appointmentMap[$key]);
        }

        $groupedSchedules = $schedules->groupBy('date');

        return view('doctor.schedule.index', [
            'schedules' => $groupedSchedules,
            'currentWeek' => $weekOffset,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek
        ]);
    }
}