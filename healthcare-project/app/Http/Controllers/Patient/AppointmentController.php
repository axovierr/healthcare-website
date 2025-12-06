<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\DoctorSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments for the patient.
     */
    public function index()
    {
        $patient = $this->currentPatient();

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'schedule'])
            ->latest()
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create(Request $request)
    {
        $query = Doctor::with('user');

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        $doctors = $query->paginate(10)->withQueryString();

        return view('patient.appointments.create', compact('doctors'));
    }

    public function schedule(Request $request, Doctor $doctor)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        
        $sessions = DoctorSession::where('doctor_id', $doctor->id)
            ->whereDate('date', $date)
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get();

        return view('patient.appointments.schedule', compact('doctor', 'sessions', 'date'));
    }

    public function book(Request $request)
    {
        $patient = $this->currentPatient();

        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'session_id' => 'required|exists:doctor_sessions,id',
        ]);

        // Begin transaction
        DB::beginTransaction();

        try {
            // Check if session is still available
            $session = DoctorSession::where('id', $validated['session_id'])
                ->where('doctor_id', $validated['doctor_id'])
                ->where('is_available', true)
                // ->lockForUpdate() // SQLite might have issues
                ->firstOrFail();

            $session->loadMissing('doctor');

            // Create appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $validated['doctor_id'],
                'schedule_id' => null,
                'date' => $session->date,
                'start_time' => $session->start_time,
                'end_time' => $session->end_time,
                'complaint' => $request->input('complaint', ''),
                'status' => 'Scheduled',
                'type' => 'Offline',
                'consultation_fee' => $session->doctor->fee,
                'payment_status' => 'pending',
                'va_number' => null,
                'payment_url' => null,
                'expired_at' => now()->addHours((int) config('services.payment.expired_hours', 24)),
            ]);

            // Mark session as unavailable
            $session->update(['is_available' => false]);

            DB::commit();

            return redirect()->route('patient.appointments.show', $appointment)
                ->with('success', 'Jadwal konsultasi berhasil dibuat.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Maaf, jadwal sudah tidak tersedia. Silahkan pilih jadwal lain.');
        }
    }



    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $patient = $this->currentPatient();

        if ($appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access');
        }
        
        $appointment->load(['doctor', 'schedule']);
        return view('patient.appointments.show', compact('appointment'));
    }

    private function currentPatient()
    {
        $user = Auth::user();

        if (!$user || !$user->patient) {
            abort(403, 'Patient profile not found');
        }

        return $user->patient;
    }
}