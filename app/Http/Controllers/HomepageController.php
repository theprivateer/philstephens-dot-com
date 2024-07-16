<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Album;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __invoke()
    {
        $page = Page::where('slug', 'home')->first();

        // $posts = Post::published()
        //             ->limit(10)
        //             ->get();

        $albums = Album::published()
                    ->limit(10)
                    ->get();

        return view('pages.homepage', [
            'page' => $page,
            // 'posts' => $posts,
            'albums' => $albums,
        ]);
    }
}
