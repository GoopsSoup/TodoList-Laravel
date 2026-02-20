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
        auth()->login($user);

        return redirect('/');
    }

    //logout
    public function logout() {
        auth()->logout();
        return redirect('/register');
    }

    //login
    public function login(Request $request) {
        //hal yang dibutuhkan untuk login
        $userRequired = $request->validate([
            'loginName' => ['required', 'min:6'],
            'loginEmail' => ['required', 'email'],
            'loginPassword' => ['required', 'min:8', 'max:22']
        ]);

        //jika akunnya sesuai yg ada di database
        if (auth()->attempt(['name' => $userRequired['loginName'], 'email' => $userRequired['loginEmail'], 'password' => $userRequired['loginPassword']])) {
            //lanjut
            $request->session()->regenerate();
        } else {
            return redirect('/register');
        }

        //kembali ke homepage
        return redirect('/');
    }

}
