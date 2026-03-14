<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //register
    public function register(Request $request) {
        //hal yang dibutuhkan untuk register
        $userRequired = $request->validate([
            'name' => ['required', 'min:6', 'max:30', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:22']
        ]);


        //hash password v
        $userRequired['password'] = bcrypt($userRequired['password']);

        //buat variable untuk baris akun user 
        $user = User::create($userRequired);

        return redirect('/register');
    }

    //logout
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/register');
    }

    //login
    public function login(Request $request) {

        //hal yang dibutuhkan untuk login
        $userRequired = $request->validate([
            'loginName' => ['required', 'min:6'],
            'loginPassword' => ['required', 'min:8', 'max:22']
        ]);

        $remember = $request->boolean('remember');

        //jika akunnya sesuai yg ada di database
        if (Auth::attempt([
            'name' => $userRequired['loginName'],
            'password' => $userRequired['loginPassword']
        ], $remember)) {    

            $request->session()->regenerate();

            return redirect('/');
        }

        //kembali ke homepage
        return redirect('/');
    }

}
