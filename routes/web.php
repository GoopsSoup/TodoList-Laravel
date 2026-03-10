<?php

use App\Http\Controllers\ListController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', [ListController::class, 'filterList']);

Route::get('/check-username', function (Request $request) {
    $exists = User::where('name', $request->username)->exists();

    return response()->json([
        'available' => !$exists
    ]);
});

Route::get('/check-email', function (Request $request) {

    $email = $request->email;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response()->json([
            'valid' => false,
            'available' => false
        ]);
    }

    $exists = User::where('email', $email)->exists();

    return response()->json([
        'valid' => true,
        'available' => !$exists
    ]);
});
    
//User

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);  
Route::post('/login', [UserController::class, 'login']);

//Sedikit security
Route::middleware('auth' , 'verified')->group(function (){
    //List
    Route::post('/create-list', [ListController::class, 'createList']);
    //Edit  
    Route::put('/edit-list/{post}', [ListController::class, 'editList']);   
    //delete
    Route::delete('/delete-list/{post}', [ListController::class, 'deleteList']);
    //checkmark
    Route::patch('/posts/{post}/completed', [ListController::class, 'check']);
    //favourite
    Route::patch('/posts/{post}/favourite', [ListController::class, 'fav']);
});


//Page
Route::get('/register', [PageController::class, 'register']);
