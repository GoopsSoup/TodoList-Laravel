<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request) {
        $userRequired = $request->validate([
            'name' => ['required', 'min:6', 'max:30', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:22']
        ]);

        $userRequired['password'] = bcrypt($userRequired['password']);
        $user = User::create($userRequired);
        auth()->login($user);

        return redirect('/');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request) {
        $userRequired = $request->validate([
            'loginName' => ['required', 'min:6'],
            'loginEmail' => ['required', 'email'],
            'loginPassword' => ['required', 'min:8', 'max:22']
        ]);

        if (auth()->attempt(['name' => $userRequired['loginName'], 'email' => $userRequired['loginEmail'], 'password' => $userRequired['loginPassword']])) {
            $request->session()->regenerate();
        }

        return redirect('/');
    }

    public function delete() {

    }
}
