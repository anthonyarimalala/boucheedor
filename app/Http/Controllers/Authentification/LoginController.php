<?php

namespace App\Http\Controllers\Authentification;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //

    public function register(Request $request)
    {
        // Valider les données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'contact' => 'string|min:10|max:10',
            'email' => 'string|max:255|unique:users',
            'role' => 'string|min:1',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Créer un nouvel utilisateur
        $user = User::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'contact' => $validatedData['contact'],
            'role' => $validatedData['role'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        auth()->login($user);

        return redirect('/');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'id' => 'required|integer',
            'password' => 'required',
        ]);

        $user = User::find($request->id);
        if($user == null){
            return back()->withErrors([
                'id' => 'id non reconu.',
            ]);
        }else if(Auth::attempt(['id' => $credentials['id'], 'password'=>$credentials['password']])){
            $request->session()->regenerate();
            return redirect('/');
        }
        return back()->withErrors([
            'password' => 'Mot de passe incorrect.',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectionRoute(){
        if (Auth::user() == null){
            redirect('/login');
        }
        else if (Auth::user()->role == 'admin'){
            redirect('/dashboard');
        }

    }
}
