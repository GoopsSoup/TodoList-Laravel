<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ListController extends Controller
{
    //buat list baru
    public function createList(Request $request) {
        //security plus plus

        if (!auth()->check()) {
            return redirect('/register');
        }   

        $listField = $request->validate([
            'list' => 'required|max:255',
            'dueDate' => 'nullable|date'
        ]); 

        $listField['list'] = strip_tags($listField['list']);


        //tambahkan user_id ke id list yang sudah dibuat 
        $listField['user_id'] = auth()->id();
        Post::create($listField);

        return redirect('/');
    }

    public function editList(Post $post, Request $request) {
        if (!auth()->check()) {
            return redirect('/register');
        } 

        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        $listField = $request->validate([
            'list' => 'required'
        ]); 

        $listField['list'] = strip_tags($listField['list']);

        $post->update($listField);
        return redirect('/');
    }


    public function deleteList(Post $post) {
        //security yes
        if (!auth()->check()) {
            return redirect('/register');
        } 

        if (auth()->user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect('/');
    }

    public function times(Post $post) {
        $table->timestamp('added_on')->nullable()->default(time());
    }
}
