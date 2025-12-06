<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSession;
use Illuminate\Database\Seeder;

class DoctorSessionSeeder extends Seeder
{
    public function run(): void
    {
        $doctor = Doctor::where('username', 'dian.p')->first();

        if (! $doctor) {
            throw new \Exception('ERROR: Doctor "dian.p" tidak ditemukan. Pastikan DoctorSeeder dijalankan.');
        }

        $timeSlots = [
            ['09:00:00', '09:30:00'],
            ['09:30:00', '10:00:00'],
            ['10:00:00', '10:30:00'],
            ['10:30:00', '11:00:00'],
        ];

        $startDate = now()->startOfDay();

        for ($day = 0; $day < 14; $day++) {
            $dateValue = $startDate->copy()->addDays($day);

            foreach ($timeSlots as [$startTime, $endTime]) {
                $session = DoctorSession::where('doctor_id', $doctor->id)
                    ->whereDate('date', $dateValue)
                    ->where('start_time', $startTime)
                    ->first();

                if ($session) {
                    $session->update([
                        'date' => $dateValue->toDateString(),
                        'end_time' => $endTime,
                        'is_available' => $session->is_available,
                    ]);
                } else {
                    DoctorSession::create([
                        'doctor_id' => $doctor->id,
                        'date' => $dateValue->toDateString(),
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'is_available' => true,
                    ]);
                }
            }
        }
    }
}
