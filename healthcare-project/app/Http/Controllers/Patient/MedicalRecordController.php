<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the patient's medical records.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Perbaikan: Menggunakan whereHas untuk memfilter berdasarkan relasi appointment -> patient
        $medicalRecords = MedicalRecord::whereHas('appointment', function ($query) use ($user) {
            $query->where('patient_id', $user->patient->id);
        })
        ->with(['appointment.doctor.user', 'prescriptions']) // Load relasi yang benar
        ->latest()
        ->paginate(10);

        return view('patient.medical-records.index', compact('medicalRecords'));
    }
}