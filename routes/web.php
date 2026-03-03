<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;

Route::get('/', [ListController::class, 'filterList']);
    
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
