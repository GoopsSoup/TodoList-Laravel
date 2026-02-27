<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    $posts = [];
    $allPosts = [];
    $allPosts = auth()->user()->userlist()->latest()->get();

    if (auth()->check()) {
        $query = auth()->user()->userList()->latest();


        if (request('filter') === 'all') {
            $allPosts;
        }
        if (request('filter') === 'today') {
            $query->whereDate('dueDate', today());
        } 
        if (request('filter') === 'overdue') {
            $query->whereDate('dueDate', '<', today());
        } 
        if (request('filter') === 'upcoming') {
            $query->whereDate('dueDate', '>', today());
        }

        $posts = $query->get();

    }

    // $posts = Post::where('user_id', auth()->id())->get();
    return view('todo', ['posts' => $posts], ['allPosts' => $allPosts]);
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
});


//Page
Route::get('/register', [PageController::class, 'register']);
