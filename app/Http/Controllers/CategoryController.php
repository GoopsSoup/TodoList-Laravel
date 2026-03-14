<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function create(Request $request) {
        if(!auth()->check()){
            return redirect('/');
        }

        $fields = $request->validate([
            'name' => 'required|max:50'
        ]);

        $fields['user_id'] = auth()->id();

        Category::create($fields);

        return redirect('/');
    }

    public function deleteCategory(Category $category) {
        if(!auth()->check()){
            abort(403);
        }

        if(auth()->id() !== $category->user_id){
            abort(403);
        }

        $category->delete();

        return redirect('/');
    }
}