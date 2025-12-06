<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Peran (Roles)
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'System Administrator']);
        $doctorRole = Role::create(['name' => 'doctor', 'display_name' => 'Dokter Medis']);
        $patientRole = Role::create(['name' => 'patient', 'display_name' => 'Pasien']);

        // 2. Buat Izin (Permissions)
        $manageUsers = Permission::create(['name' => 'manage-users', 'display_name' => 'Kelola Pengguna', 'group' => 'user']);
        $viewAllAppointments = Permission::create(['name' => 'view-all-appointments', 'display_name' => 'Lihat Semua Janji', 'group' => 'appointment']);
        $createAppointment = Permission::create(['name' => 'create-appointment', 'display_name' => 'Buat Janji', 'group' => 'appointment']);
        $createMedicalRecord = Permission::create(['name' => 'create-medical-record', 'display_name' => 'Buat Rekam Medis', 'group' => 'medical']);

        // 3. Kaitkan Izin ke Peran (Role-Permission Assignment)
        $adminRole->permissions()->sync([$manageUsers->id, $viewAllAppointments->id]);
        $doctorRole->permissions()->sync([$viewAllAppointments->id, $createMedicalRecord->id]);
        $patientRole->permissions()->sync([$createAppointment->id]);
    }
}
