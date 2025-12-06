<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorSessionController extends Controller
{
    public function index(Doctor $doctor)
    {
        $sessions = $doctor->sessions()->orderBy('date')->orderBy('start_time')->paginate(50);
        return view('admin.doctors.sessions.index', compact('doctor', 'sessions'));
    }

    public function create(Doctor $doctor)
    {
        return view('admin.doctors.sessions.create', compact('doctor'));
    }

    public function store(Request $request, Doctor $doctor)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $start = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $end = (clone $start)->addHour();

        DoctorSession::create([
            'doctor_id' => $doctor->id,
            'date' => $request->date,
            'start_time' => $start->format('H:i:00'),
            'end_time' => $end->format('H:i:00'),
            'is_available' => true,
        ]);

        return redirect()->route('doctors.sessions.index', $doctor)->with('success', 'Session created');
    }

    /**
     * Generate daily slots for a given date (08:00 - 19:00 start times meaning last slot 19:00-20:00)
     */
    public function generate(Request $request, Doctor $doctor)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = $request->date;

        DB::transaction(function() use ($doctor, $date) {
            for ($hour = 8; $hour < 20; $hour++) {
                $start = sprintf('%02d:00:00', $hour);
                $end = sprintf('%02d:00:00', $hour + 1);

                DoctorSession::firstOrCreate([
                    'doctor_id' => $doctor->id,
                    'date' => $date,
                    'start_time' => $start,
                ], [
                    'end_time' => $end,
                    'is_available' => true,
                ]);
            }
        });

        return redirect()->route('doctors.sessions.index', $doctor)->with('success', 'Slots generated');
    }

    public function destroy(Doctor $doctor, DoctorSession $session)
    {
        $session->delete();
        return back()->with('success', 'Session removed');
    }
}
