<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            PatientSeeder::class,
            DoctorSeeder::class,
            DoctorSessionSeeder::class,
            ScheduleSeeder::class,
            AppointmentSeeder::class,
            MedicalRecordSeeder::class,
            TelemedicineSessionSeeder::class,
            PrescriptionSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}