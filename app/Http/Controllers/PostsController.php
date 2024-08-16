<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'posts')->first();

        $posts = Post::where('top_level', true)
                    ->latest('updated_at')
                    ->get();

        $posts = $posts->groupBy(function ($post) {
            return $post->updated_at->format('F j, Y');
        });

        return view('posts.index', [
            'page' => $page,
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
                    ->firstOrFail();

        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
