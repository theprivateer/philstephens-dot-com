<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Page;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function __invoke()
    {
        $page = Page::where('slug', 'links')->first();

        $links = Link::latest()->get();

        $links = $links->groupBy(function ($link) {
            return $link->created_at->format('F j, Y');
        });

        return view('links.index', [
            'page' => $page,
            'links' => $links,
        ]);
    }
}
