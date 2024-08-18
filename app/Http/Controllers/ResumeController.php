<?php

namespace App\Http\Controllers;

use App\Models\JobRole;
use App\Models\Page;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = Page::where('slug', 'resume')->first();

        $jobs = JobRole::latest('started_at')->get();

        return view('resume.index', [
            'page' => $page,
            'jobs' => $jobs,
        ]);
    }
}
