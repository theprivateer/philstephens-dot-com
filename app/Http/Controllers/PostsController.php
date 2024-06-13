<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'blog')->first();

        $posts = Post::published()
                    ->get();

        return view('posts.index', [
            'page' => $page,
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
                    ->published()
                    ->firstOrFail();

        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
