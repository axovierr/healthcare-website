<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function complete()
    {
        return view('patient.profile.complete');
    }

    public function edit()
    {
        $user = Auth::user();
        $patient = $user->patient;
        return view('patient.profile.edit', compact('user', 'patient'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:patients,username,' . Auth::id() . ',user_id',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'golongan_darah' => 'required|in:A,B,AB,O',
            'address' => 'required|string',
        ]);

        // Update user gender
        Auth::user()->update(['gender' => $request->gender]);

        // Update patient profile
        Patient::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'username' => $request->username,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'golongan_darah' => $request->golongan_darah,
                'address' => $request->address,
            ]
        );

        return redirect()->route('patient.dashboard')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:patients,username,' . Auth::id() . ',user_id',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'golongan_darah' => 'required|in:A,B,AB,O',
            'address' => 'required|string',
        ]);

        // Update user gender
        Auth::user()->update(['gender' => $request->gender]);

        // Create or update patient profile
        Patient::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'username' => $request->username,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'golongan_darah' => $request->golongan_darah,
                'address' => $request->address,
            ]
        );

        return redirect()->route('patient.dashboard')->with('success', 'Profil berhasil dilengkapi!');
    }
}