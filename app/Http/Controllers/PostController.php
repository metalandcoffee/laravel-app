<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        return view('posts.index', [
            'posts' => Post::latest('created_at')->with('category', 'author')->filter(request(['search', 'category']))->get()
        ]);
    }

    public function show(Post $post) {
        return view('post.show', [
            'post' => $post
        ]);
    }
}
