<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Page;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function __invoke()
    {
        $page = Page::where('slug', 'notes')->first();

        $notes = Note::latest()->get();

        $notes = $notes->groupBy(function ($note) {
            return $note->created_at->format('F j, Y');
        });

        // dd($notes);

        return view('notes.index', [
            'page' => $page,
            'notes' => $notes,
        ]);
    }
}
