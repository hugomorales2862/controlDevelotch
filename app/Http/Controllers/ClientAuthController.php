<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\ClientAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ClientAccessTokenMail;
use Carbon\Carbon;

class ClientAuthController extends Controller
{
    /**
     * Mostrar formulario para ingresar email (Acceso de Ayuda)
     */
    public function showLoginForm()
    {
        return view('auth.client-login');
    }

    /**
     * Generar y "enviar" token al cliente
     */
    public function sendToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $client = Client::where('email', $request->email)->first();

        if (!$client) {
            Log::warning('Intento de acceso de ayuda fallido: Email no encontrado', ['email' => $request->email]);
            return back()->withErrors(['email' => 'El correo ingresado no coincide con ningún cliente registrado.']);
        }

        Log::info('Generando token de acceso para cliente', ['email' => $request->email]);

        // Generar un token de 6 dígitos
        $token = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Almacenar token (válido por 15 minutos)
        ClientAccessToken::create([
            'email' => $request->email,
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(15),
            'used' => false
        ]);

        // Enviar token por correo electrónico
        $emailSent = false;
        try {
            Mail::to($request->email)->send(new ClientAccessTokenMail($token, $client->contact_name ?? $client->name));
            $emailSent = true;
            Log::info('Token enviado por correo exitosamente', ['email' => $request->email]);
        } catch (\Exception $e) {
            Log::error('Error al enviar token por correo: ' . $e->getMessage(), ['email' => $request->email]);
        }

        // Guardar en sesión como respaldo (para debug o si el correo falla)
        session(['support_token_debug' => $token]);

        $message = $emailSent 
            ? 'Hemos enviado un código de 6 dígitos a tu correo electrónico.'
            : 'Se ha generado tu código de acceso. (Revisa el código de respaldo en pantalla si no recibes el correo.)';

        return redirect()->route('client.auth.verify', ['email' => $request->email])
            ->with('success', $message);
    }

    /**
     * Mostrar formulario para ingresar el código
     */
    public function showVerifyForm(Request $request)
    {
        $email = $request->email;
        return view('auth.client-verify', compact('email'));
    }

    /**
     * Validar token y loguear
     */
    public function verifyToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string|size:6'
        ]);

        $accessToken = ClientAccessToken::where('email', $request->email)
            ->where('token', $request->token)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$accessToken) {
            return back()->withErrors(['token' => 'Código inválido o expirado.']);
        }

        // Marcar token como usado
        $accessToken->update(['used' => true]);

        // Buscar o crear el usuario vinculado al cliente
        $client = Client::where('email', $request->email)->first();
        
        $user = $client->user;

        if (!$user) {
            // Crear usuario si no existe
            $user = User::create([
                'name' => $client->contact_name ?? $client->name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(24)), // Password aleatoria, acceden por token
            ]);
            
            // Asignar rol client
            $user->assignRole('client');
            
            // Vincular al cliente
            $client->update(['user_id' => $user->id]);
        }

        // Loguear al usuario
        Auth::login($user);

        return redirect()->route('portal.dashboard')
            ->with('success', 'Bienvenido al portal de soporte de Develotech Global.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
