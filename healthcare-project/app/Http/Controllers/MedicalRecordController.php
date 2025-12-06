<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('patient')) {
            // Ambil medical records milik pasien ini
            $medicalRecords = MedicalRecord::whereHas('appointment', function ($query) use ($user) {
                $query->where('patient_id', $user->patient->id);
            })->with(['appointment.doctor.user'])->latest()->get();

            return view('medical-records.index', compact('medicalRecords'));
        } elseif ($user->hasRole('doctor')) {
            // Ambil medical records yang dibuat oleh dokter ini
            $medicalRecords = MedicalRecord::whereHas('appointment', function ($query) use ($user) {
                $query->where('doctor_id', $user->doctor->id);
            })->with(['appointment.patient.user'])->latest()->get();

            return view('medical-records.index', compact('medicalRecords'));
        }

        return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Appointment $appointment)
    {
        // Pastikan user adalah dokter yang bersangkutan
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->hasRole('doctor') || $appointment->doctor_id !== $user->doctor->id) {
            abort(403);
        }

        // Cek apakah record sudah ada
        if ($appointment->medicalRecord) {
            return redirect()->route('medical-records.show', $appointment->medicalRecord->id);
        }

        return view('medical-records.create', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Appointment $appointment)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->hasRole('doctor') || $appointment->doctor_id !== $user->doctor->id) {
            abort(403);
        }

        // Cek apakah record sudah ada
        if ($appointment->medicalRecord) {
            return redirect()->route('medical-records.index')
                ->with('error', 'Medical record already exists for this appointment.');
        }

        $request->validate([
            'diagnosis' => 'required|string',
            'doctor_notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'prescriptions' => 'nullable|array',
            'prescriptions.*.medication' => 'required|string',
            'prescriptions.*.dosage' => 'required|string',
            'prescriptions.*.instructions' => 'required|string',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('medical-records', 'public');
        }

        $medicalRecord = MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'visit_date' => now(),
            'diagnosis' => $request->diagnosis,
            'doctor_notes' => $request->doctor_notes,
            'attachment_path' => $attachmentPath,
        ]);

        // Simpan Resep Obat jika ada
        if ($request->has('prescriptions')) {
            foreach ($request->prescriptions as $prescriptionData) {
                \App\Models\Prescription::create([
                    'medical_record_id' => $medicalRecord->id,
                    'doctor_id' => $user->doctor->id,
                    'patient_id' => $appointment->patient_id,
                    'medication' => $prescriptionData['medication'],
                    'dosage' => $prescriptionData['dosage'],
                    'instructions' => $prescriptionData['instructions'],
                ]);
            }
        }

        // Update status appointment jika perlu, misal jadi 'completed'
        $appointment->update(['status' => 'completed']);

        return redirect()->route('medical-records.index')->with('success', 'Medical record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Otorisasi: Hanya pasien ybs atau dokter ybs yang boleh lihat
        $isPatient = $user->hasRole('patient') && $medicalRecord->appointment->patient_id === $user->patient->id;
        $isDoctor = $user->hasRole('doctor') && $medicalRecord->appointment->doctor_id === $user->doctor->id;

        if (!$isPatient && !$isDoctor) {
            abort(403);
        }

        return view('medical-records.show', compact('medicalRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Authorization: Only the creating doctor can edit
        if (!$user->hasRole('doctor') || $medicalRecord->appointment->doctor_id !== $user->doctor->id) {
            abort(403);
        }

        return view('medical-records.edit', compact('medicalRecord'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->hasRole('doctor') || $medicalRecord->appointment->doctor_id !== $user->doctor->id) {
            abort(403);
        }

        $request->validate([
            'diagnosis' => 'required|string',
            'doctor_notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'prescriptions' => 'nullable|array',
            'prescriptions.*.medication' => 'required|string',
            'prescriptions.*.dosage' => 'required|string',
            'prescriptions.*.instructions' => 'required|string',
        ]);

        $data = [
            'diagnosis' => $request->diagnosis,
            'doctor_notes' => $request->doctor_notes,
        ];

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($medicalRecord->attachment_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($medicalRecord->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment')->store('medical-records', 'public');
        }

        $medicalRecord->update($data);

        // Update Prescriptions
        // Delete existing
        $medicalRecord->prescriptions()->delete();

        // Create new
        if ($request->has('prescriptions')) {
            foreach ($request->prescriptions as $prescriptionData) {
                \App\Models\Prescription::create([
                    'medical_record_id' => $medicalRecord->id,
                    'doctor_id' => $user->doctor->id,
                    'patient_id' => $medicalRecord->appointment->patient_id,
                    'medication' => $prescriptionData['medication'],
                    'dosage' => $prescriptionData['dosage'],
                    'instructions' => $prescriptionData['instructions'],
                ]);
            }
        }

        return redirect()->route('medical-records.show', $medicalRecord)->with('success', 'Medical record updated successfully.');
    }
}
