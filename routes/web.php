<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    $posts = [];
    if (auth()->check()) {
        $posts = auth()->user()->userList()->latest()->get();
    }
    // $posts = Post::where('user_id', auth()->id())->get();
    return view('todo', ['posts' => $posts]);
});

//User
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

//List
Route::post('/create-list', [ListController::class, 'createList']);

