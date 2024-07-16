<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __invoke(string $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        if ($page->redirects_to) {
            return redirect($page->redirects_to);
        }

        return view('pages.show', [
            'page' => $page,
        ]);
    }
}
