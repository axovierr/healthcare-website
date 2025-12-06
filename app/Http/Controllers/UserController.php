<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gunakan eager loading untuk mengambil data role (mengatasi N+1)
        $users = User::with('role')->paginate(15); 
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua roles dari database untuk dropdown
        $roles = Role::all(); 
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'username' => 'required|string|max:255|unique:users',
            'gender' => 'required|in:male,female',
        ];

        // 2. Tambah Validasi Berdasarkan Role
        $role = Role::find($request->role_id);
        if ($role) {
            if ($role->name === 'doctor') {
                $validationRules['license_no'] = 'required|string|max:50|unique:doctors,license_no';
                $validationRules['address_clinic'] = 'required|string|max:500';
            } elseif ($role->name === 'patient') {
                $validationRules['golongan_darah'] = 'required|in:A,B,AB,O';
                $validationRules['birth_date'] = 'required|date';
                $validationRules['address'] = 'required|string|max:500';
            }
        }

        $validated = $request->validate($validationRules);

        // 3. Buat User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'username' => $validated['username'],
            'gender' => $validated['gender'],
        ]);

        // 4. Simpan Data Tambahan Sesuai Role
        if ($role->name === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'username' => $validated['username'],
                'license_no' => $validated['license_no'],
                'gender' => $validated['gender'],
                'address_clinic' => $validated['address_clinic'],
            ]);
        } elseif ($role->name === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'username' => $validated['username'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'golongan_darah' => $validated['golongan_darah'],
                'address' => $validated['address'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna baru berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['role', 'doctor', 'patient'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with(['role', 'doctor', 'patient'])->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // 1. Validasi Input Dasar
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role_id' => 'required|exists:roles,id',
            'gender' => 'required|in:male,female',
        ];

        // Tambahkan validasi password hanya jika diisi
        if ($request->filled('password')) {
            $validationRules['password'] = 'string|min:8';
        }

        // 2. Tambah Validasi Berdasarkan Role
        $role = Role::find($request->role_id);
        if ($role) {
            if ($role->name === 'doctor') {
                $validationRules['license_no'] = 'required|string|max:50|unique:doctors,license_no,' . optional($user->doctor)->id;
                $validationRules['address_clinic'] = 'required|string|max:500';
            } elseif ($role->name === 'patient') {
                $validationRules['golongan_darah'] = 'required|in:A,B,AB,O';
                $validationRules['birth_date'] = 'required|date';
                $validationRules['address'] = 'required|string|max:500';
            }
        }

        $validated = $request->validate($validationRules);

        // 3. Update User
        DB::beginTransaction();
        try {
            // Update user data
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'role_id' => $validated['role_id'],
                'gender' => $validated['gender']
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            // Update role-specific data
            if ($role->name === 'doctor') {
                // Update or create doctor data
                if ($user->doctor) {
                    $user->doctor->update([
                        'license_no' => $validated['license_no'],
                        'address_clinic' => $validated['address_clinic']
                    ]);
                } else {
                    Doctor::create([
                        'user_id' => $user->id,
                        'license_no' => $validated['license_no'],
                        'address_clinic' => $validated['address_clinic']
                    ]);
                }
            } elseif ($role->name === 'patient') {
                // Update or create patient data
                if ($user->patient) {
                    $user->patient->update([
                        'golongan_darah' => $validated['golongan_darah'],
                        'birth_date' => $validated['birth_date'],
                        'address' => $validated['address']
                    ]);
                } else {
                    Patient::create([
                        'user_id' => $user->id,
                        'golongan_darah' => $validated['golongan_darah'],
                        'birth_date' => $validated['birth_date'],
                        'address' => $validated['address']
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Data terkait (doctor/patient) akan terhapus otomatis karena kita menggunakan onDelete('cascade')
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
