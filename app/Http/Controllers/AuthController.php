<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && $this->verifyPassword($request->password, $user->password)) {
            if ($user->status === 'inactive') {
                return back()->withErrors([
                    'username' => 'Sua conta está inativa. Entre em contato com o administrador.'
                ]);
            }

            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Nome de usuário ou senha inválidos.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    private function verifyPassword($plainPassword, $hashedPassword)
    {
        // Compatibilidade com o sistema original: sha1(md5($password))
        $originalHash = sha1(md5($plainPassword));
        return $originalHash === $hashedPassword;
    }
}
