<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->paginate(20);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'fee' => 'nullable|numeric|min:0',
            'address_clinic' => 'nullable|string',
        ]);

        $doctor->update([
            'fee' => $request->input('fee'),
            'address_clinic' => $request->input('address_clinic', $doctor->address_clinic),
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil diperbarui');
    }
}
