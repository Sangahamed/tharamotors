<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Afficher la page de connexion
     */
    public function showLogin()
    {
        return view('connexion');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Format email invalide',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit avoir au minimum 6 caractères',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Connexion réussie!');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont invalides.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Vous avez été déconnecté.');
    }
}
