<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'blog')->first();

        $posts = Article::published()
                    ->get();

        return view('articles.index', [
            'page' => $page,
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $post = Article::where('slug', $slug)
                    ->published()
                    ->firstOrFail();

        return view('articles.show', [
            'post' => $post,
        ]);
    }
}
