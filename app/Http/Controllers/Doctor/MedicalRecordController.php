<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found');
        }

        $medicalRecords = MedicalRecord::whereHas('appointment', function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
            ->with(['appointment.patient.user', 'appointment'])
            ->latest()
            ->paginate(10);

        return view('doctor.medical-records.index', compact('medicalRecords'));
    }
}
