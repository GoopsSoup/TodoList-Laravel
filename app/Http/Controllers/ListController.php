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

    public function check(post $post) {
        if(!auth()->check()) {
            abort(403);
        }

        $post->update([
            'completed' => !$post->completed,
        ]);

        return redirect('/');
    }

    public function filterList() {
        if (!request()->has('filter')) {
            return redirect('/?filter=all');
        }

        if (!auth()->check()) {
            return view('todo', [
                'allPosts' => collect(),
                'posts' => collect(),
            ]);
        }

        $query = auth()->user()->userList()->latest();
        $allPosts = auth()->user()->userList()->latest()->get(); 

        if (request('filter') === 'today') {
            $query->whereDate('dueDate', today());
        }

        if (request('filter') === 'overdue') {
            $query->whereDate('dueDate', '<', today());
        }

        if (request('filter') === 'upcoming') {
            $query->whereDate('dueDate', '>', today());
        }

        if(request('filter') === 'completed') {
            $query->where('completed', true);
        }

        $posts = $query->get();

        // $posts = Post::where('user_id', auth()->id())->get();

        return view('todo', compact('allPosts', 'posts'));
    }
}
