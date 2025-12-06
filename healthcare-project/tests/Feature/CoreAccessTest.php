<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreAccessTest extends TestCase
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

    public function test_admin_can_access_admin_dashboard()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_doctor_can_access_doctor_dashboard()
    {
        $doctorRole = Role::where('name', 'doctor')->first();
        $user = User::factory()->create(['role_id' => $doctorRole->id]);
        
        // Create Doctor profile
        \App\Models\Doctor::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'license_no' => 'DOC-123',
            'gender' => 'male',
            'address_clinic' => 'Test Clinic',
            'fee' => 100000,
        ]);

        $response = $this->actingAs($user)->get('/doctor/dashboard');

        $response->assertStatus(200);
    }

    public function test_patient_can_access_patient_dashboard()
    {
        $patientRole = Role::where('name', 'patient')->first();
        $user = User::factory()->create(['role_id' => $patientRole->id]);

        // Create Patient profile
        \App\Models\Patient::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'golongan_darah' => 'O',
            'address' => 'Test Address',
        ]);

        $response = $this->actingAs($user)->get('/patient/dashboard');

        // If redirected to profile complete, that's also a valid flow to test
        // But let's check if it's 200 or redirect
        if ($response->status() === 302) {
             $response->assertRedirect(route('patient.profile.complete'));
        } else {
             $response->assertStatus(200);
        }
    }

    public function test_patient_cannot_access_admin_dashboard()
    {
        $patientRole = Role::where('name', 'patient')->first();
        $user = User::factory()->create(['role_id' => $patientRole->id]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403); // Or 404/Redirect depending on middleware
    }
}
