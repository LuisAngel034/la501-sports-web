<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()    { return view('auth.login'); }
    public function showRegistro() { return view('auth.registro'); }
    public function showRecuperar(){ return view('auth.recuperar'); }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $key = 'login-attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors(['email' => 'Cuenta bloqueada temporalmente por seguridad.']);
        }

        if (Auth::attempt($credentials)) {
            if (Auth::user()->is_active == 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Tu cuenta está suspendida. Contacta a gerencia.']);
            }

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
            } elseif ($role === 'empleado') {
                return redirect()->route('mesero.mesas');
            } else {
                return redirect()->intended('/admin/dashboard');
            }
        }

        RateLimiter::hit($key, 300);
        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users',
            'telefono'           => 'required',
            'password'           => [
                'required', 'confirmed', 'min:8',
                'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!@#$%^&*]/',
            ],
            'pregunta_secreta'   => 'required',
            'respuesta_secreta'  => 'required',
        ], [
            'password.regex'  => 'La contraseña debe tener una mayúscula, un número y un carácter especial.',
            'email.unique'    => 'Este correo ya está registrado en La 501.',
        ]);

        User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'telefono'           => $request->telefono,
            'password'           => Hash::make($request->password),
            'pregunta_secreta'   => $request->pregunta_secreta,
            'respuesta_secreta'  => Hash::make($request->respuesta_secreta),
            'role'               => 'cliente',
            'is_active'          => 1,
        ]);

        return redirect()->route('login')->with('status', '¡Registro exitoso en La 501!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('status', 'Sesión cerrada con seguridad.');
    }

    public function showPerfil()
    {
        $user = Auth::user();
        return view('auth.perfil', compact('user'));
    }

    // =========================================================================
    // SISTEMA DE RECUPERACIÓN DE CONTRASEÑA (OTP - 8 Dígitos)
    // =========================================================================

    // 1. GENERA Y ENVÍA EL CÓDIGO DE 8 DÍGITOS
    public function enviarCodigo(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $key = 'password-reset-' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors(['email' => 'Has excedido el límite de intentos. Por favor espera unos segundos antes de intentar de nuevo.']);
        }
        RateLimiter::hit($key, 60);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $codigo = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['token' => Hash::make($codigo), 'created_at' => Carbon::now()]
            );

            Mail::send('emails.otp', ['codigo' => $codigo], function ($message) use ($user) {
                $message->to($user->email)->subject('Tu código de seguridad - La 501 Sports');
            });
        }

        session(['email_para_codigo' => $request->email]);
        return redirect()->route('password.verify.code');
    }

    // 2. MUESTRA LA PANTALLA PARA ESCRIBIR EL CÓDIGO
    public function showVerifyCode()
    {
        if (!session('email_para_codigo')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-code', ['email' => session('email_para_codigo')]);
    }

    // 3. VALIDA EL CÓDIGO Y SU CADUCIDAD
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code'  => 'required|string|size:8',
        ], [
            'code.required' => 'Debes ingresar el código.',
            'code.size'     => 'El código debe tener exactamente 8 caracteres.',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->code, $record->token) || Carbon::parse($record->created_at)->addMinutes(5)->isPast()) {
            return back()->withErrors(['code' => 'El código es incorrecto o ha caducado.']);
        }

        session(['allow_password_reset' => $request->email]);
        return redirect()->route('password.reset.form');
    }

    // 4. MUESTRA EL FORMULARIO DE NUEVA CONTRASEÑA
    public function showCustomResetForm()
    {
        if (!session('allow_password_reset')) {
            return redirect()->route('login');
        }
        return view('auth.reset', ['email' => session('allow_password_reset')]);
    }

    // 5. GUARDA LA NUEVA CONTRASEÑA
    public function updateCustomPassword(Request $request)
    {
        $email = session('allow_password_reset');
        if (!$email) {
            return redirect()->route('login');
        }

        $request->validate([
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'password.min'     => 'La contraseña debe tener al menos 8 caracteres.',
            'password.mixed'   => 'La contraseña debe incluir al menos una letra mayúscula y una minúscula.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
            'password.symbols' => 'La contraseña debe incluir al menos un símbolo (!@#$).',
        ]);

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget('allow_password_reset');

        return redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida con éxito! Ya puedes iniciar sesión.');
    }
}
