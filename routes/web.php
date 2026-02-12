<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\PageController;
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

//Sedikit security
Route::middleware('auth')->group(function (){
    //List
    Route::post('/create-list', [ListController::class, 'createList']);
    //Edit  
    Route::get('/edit-list/{post}', [ListController::class, 'editScreen']);
    Route::put('/edit-list/{post}', [ListController::class, 'editList']);   
    //delete
    Route::delete('/delete-list/{post}', [ListController::class, 'deleteList']);
});


//Page
Route::get('/register', [PageController::class, 'register']);
