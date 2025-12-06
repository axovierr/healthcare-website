<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PatientHistoryController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found');
        }

        // Get all completed appointments to show patient history
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->with(['patient.user', 'medicalRecord'])
            ->latest()
            ->paginate(15);

        return view('doctor.patient-history.index', compact('appointments'));
    }
}
