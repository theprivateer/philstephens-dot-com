<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Page;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'bookshelf')->first();

        $books = Book::published()
                    ->get();

        return view('books.index', [
            'page' => $page,
            'books' => $books,
        ]);
    }

    public function show(string $slug)
    {
        $book = Book::where('slug', $slug)
                    ->published()
                    ->firstOrFail();

        return view('books.show', [
            'book' => $book,
        ]);
    }
}
