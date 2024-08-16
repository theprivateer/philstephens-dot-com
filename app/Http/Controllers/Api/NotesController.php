<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NotesController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->get('image')) {
            $data = base64_decode($request->get('image'));

            $filename = 'images/notes/' . str()->random(32) . '.jpg';
            Storage::disk('public')->put($filename, $data);
        }

        Note::create([
            'content' => $request->get('content'),
            'image' => $filename ?? null,
        ]);

        return;
    }
}
