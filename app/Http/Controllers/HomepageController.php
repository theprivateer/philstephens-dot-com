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



        return view('pages.homepage', [
            'page' => $page,
        ]);
    }
}
