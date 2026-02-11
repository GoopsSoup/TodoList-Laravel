<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ListController extends Controller
{

    //buat list baru
    public function createList(Request $request) {
        $listField = $request->validate([
            'list' => 'required'
        ]); 

        $listField['list'] = strip_tags($listField['list']);

        //tambahkan user_id ke id list yang sudah dibuat 
        $listField['user_id'] = auth()->id();
        Post::create($listField);
        return redirect('/');
    }

    //berpindah ke halaman edit
    public function editScreen(Post $post) {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }
        return view('edit-list', ['post' => $post]);
    }

    public function editList(Post $post, Request  $request) {
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
        if (auth()->user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect('/');
    }
}
