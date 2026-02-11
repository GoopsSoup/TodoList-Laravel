<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function createList(Request $request) {
        $listField = $request->validate([
            'list' => 'required'
        ]); 

        $listField['list'] = strip_tags($listField['list']);
        $listField['user_id'] = auth()->id();
        Post::create($listField);
        return redirect('/');
    }
}
