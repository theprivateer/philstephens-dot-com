<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __invoke(string $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.show', [
            'page' => $page,
        ]);
    }
}
