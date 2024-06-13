<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'albums')->first();

        $albums = Album::published()
                    ->get();

        return view('albums.index', [
            'page' => $page,
            'albums' => $albums,
        ]);
    }

    public function show(string $slug)
    {
        $album = Album::where('slug', $slug)
                    ->published()
                    ->firstOrFail();

        return view('albums.show', [
            'album' => $album,
        ]);
    }
}
