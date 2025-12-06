<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'doctor']);
        Role::create(['name' => 'patient']);
    }

    public function test_patient_can_book_appointment()
    {
        // 1. Setup Doctor
        $doctorRole = Role::where('name', 'doctor')->first();
        $doctorUser = User::factory()->create(['role_id' => $doctorRole->id]);
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'username' => $doctorUser->username,
            'license_no' => 'DOC-TEST',
            'gender' => 'male',
            'address_clinic' => 'Test Clinic',
            'fee' => 150000,
        ]);

        // 2. Setup DoctorSession (Required for booking)
        $session = \App\Models\DoctorSession::create([
            'doctor_id' => $doctor->id,
            'date' => now()->next('Monday')->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '09:30',
            'is_available' => true,
        ]);

        // 3. Setup Patient
        $patientRole = Role::where('name', 'patient')->first();
        $patientUser = User::factory()->create(['role_id' => $patientRole->id]);
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'username' => $patientUser->username,
            'birth_date' => '1995-05-05',
            'gender' => 'female',
            'golongan_darah' => 'A',
            'address' => 'Patient Address',
        ]);

        // 4. Patient books appointment
        // Route: patient.appointments.book (POST)
        
        $response = $this->actingAs($patientUser)->post(route('patient.appointments.book'), [
            'doctor_id' => $doctor->id,
            'session_id' => $session->id,
            'complaint' => 'Headache',
        ]);

        // 5. Verify
        $response->assertRedirect(); // Likely redirects to payment or details
        
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'date' => $session->date,
            'status' => 'Scheduled',
        ]);
    }
}
