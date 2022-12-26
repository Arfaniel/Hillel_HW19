<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class PostController
{
    public function index()
    {
        Storage::disk('dropbox')->put('example.txt', 'content');
//        $posts = Post::with('category', 'user', 'tags')->get();
//        return view('index', compact('posts'));
    }
}
