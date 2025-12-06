<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions', 'users')->paginate(10); 
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        // Mengarahkan ke resources/views/admin/roles/create.blade.php
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. TAMBAHKAN BLOK VALIDASI INI UNTUK MENDIFINISIKAN $validated
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id', // Harus cek ID
        ]);
        // END VALIDASI

        // 2. Dapatkan permissions dan keluarkan dari array $validated
        $permissions = $validated['permissions'] ?? []; // Sekarang $validated sudah didefinisikan
        unset($validated['permissions']); 

        // 3. Simpan Role
        $role = Role::create($validated); 

        // 4. Sinkronkan Permissions
        $role->permissions()->sync($permissions); 

        return redirect()->route('admin.user-roles.index')
                        ->with('success', 'Role berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $user_role) // Gunakan Route Model Binding
    {
        $permissions = Permission::all();
        // Mengarahkan ke resources/views/admin/roles/edit.blade.php
        return view('admin.roles.edit', compact('user_role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $user_role) // Gunakan Route Model Binding
    {
        // 1. Validasi Input
        $validated = $request->validate([
            // Kecualikan ID role saat ini dari cek unik
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $user_role->id], 
            'display_name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            // Pastikan mengecek keberadaan ID permission di tabel permissions
            'permissions.*' => 'exists:permissions,id', 
        ]);

        // 2. Pisahkan data permissions dari data Role
        $permissions = $validated['permissions'] ?? [];
        unset($validated['permissions']); 

        // 3. Update data Role (Mass Assignment)
        // Ini akan berhasil jika $fillable di Model Role sudah benar
        $user_role->update($validated); 

        // 4. Sinkronkan relasi Permissions (many-to-many)
        // $permissions sekarang berisi array ID, sehingga sync() akan bekerja
        $user_role->permissions()->sync($permissions); 

        // 5. Redirect dengan pesan sukses
        return redirect()->route('admin.user-roles.index')
                        ->with('success', 'Role ' . $user_role->name . ' berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $user_role)
    {
        // 1. Terapkan Prinsip Fail Secure: Cek apakah masih ada User
        if ($user_role->users()->exists()) {
            return redirect()->route('admin.user-roles.index')
                            ->with('error', 'Tidak dapat menghapus Role karena masih ada pengguna yang terkait.');
        }

        try {
            // 2. Putuskan relasi many-to-many
            $user_role->permissions()->detach();

            // 3. Hapus Role
            $user_role->delete();

            return redirect()->route('admin.user-roles.index')
                            ->with('success', 'Role berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('admin.user-roles.index')
                            ->with('error', 'Gagal menghapus Role: ' . $e->getMessage());
        }
    }
}
