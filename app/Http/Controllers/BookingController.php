<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DoctorSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:doctor_sessions,id',
        ]);

        $user = Auth::user();

        // Transaction with row lock to avoid race conditions
        $booking = DB::transaction(function() use ($request, $user) {
            $session = DoctorSession::where('id', $request->session_id)->lockForUpdate()->first();
            if (!$session || !$session->is_available) {
                throw new \Exception('Session not available');
            }

            // Ensure user doesn't already have booking for this session
            if (Booking::where('session_id', $session->id)->exists()) {
                throw new \Exception('Session already booked');
            }

            $booking = Booking::create([
                'session_id' => $session->id,
                'user_id' => $user->id,
            ]);

            return $booking;
        });

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Jadwal berhasil dibooking.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }

}
