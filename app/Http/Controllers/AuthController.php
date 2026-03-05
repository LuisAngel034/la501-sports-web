<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegistro() { return view('auth.registro'); }
    public function showRecuperar() { return view('auth.recuperar'); }

    // Lógica de Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $key = 'login-attempts:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) { 
            return back()->withErrors(['email' => 'Cuenta bloqueada temporalmente por seguridad.']);
        }

        if (Auth::attempt($credentials)) {
            // VERIFICACIÓN por si el empleado está suspendido
            if (Auth::user()->is_active == 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Tu cuenta está suspendida. Contacta a gerencia.']);
            }

            // VERIFICACIÓN para roles sin acceso al sistema 
            $rolesSinAcceso = ['limpieza'];
            if (in_array(Auth::user()->role, $rolesSinAcceso)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Tu puesto no requiere acceso al sistema.']);
            }

            $request->session()->regenerate();
            RateLimiter::clear($key); 

            $role = Auth::user()->role;

            if ($role === 'cliente') {
                return redirect()->intended('/a-domicilio'); 
            } 
            elseif ($role === 'repartidor') {
                return redirect()->route('repartidor.index');
            }
            elseif ($role === 'empleado') {
                return redirect()->route('mesero.mesas');
            }
            else {
                return redirect()->intended('/admin/dashboard'); 
            }
        }

        RateLimiter::hit($key, 300); 
        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function registrar(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telefono' => 'required',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*]/',
            ],
            'pregunta_secreta' => 'required',
            'respuesta_secreta' => 'required',
        ], [
            'password.regex' => 'La contraseña debe tener una mayúscula, un número y un carácter especial.',
            'email.unique' => 'Este correo ya está registrado en La 501.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password), 
            'pregunta_secreta' => $request->pregunta_secreta,
            'respuesta_secreta' => Hash::make($request->respuesta_secreta), 
            'role' => 'cliente',
            'is_active' => 1,
        ]);

        return redirect()->route('login')->with('status', '¡Registro exitoso en La 501!');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Sesión cerrada con seguridad.');
    }

    public function showPerfil() {
    $user = Auth::user();
    return view('auth.perfil', compact('user'));
}
}