<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Patient;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Get patient role
        $patientRole = Role::where('name', 'patient')->first();
        if (!$patientRole) {
            throw new \Exception('Patient role not found');
        }

        // Generate username
        $baseUsername = explode('@', $request->email)[0];
        $username = $baseUsername;
        $counter = 1;
        
        // Ensure unique username across Users and Patients
        while (User::where('username', $username)->exists() || Patient::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $username,
                'password' => Hash::make($request->password),
                'role_id' => $patientRole->id,
                'gender' => null,
            ]);

            Patient::create([
                'user_id' => $user->id,
                'username' => $username,
                'birth_date' => null,
                'gender' => null,
                'golongan_darah' => null,
                'address' => null,
            ]);

            DB::commit();
            
            event(new Registered($user));
            Auth::login($user);

            return redirect()->route('patient.dashboard');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
