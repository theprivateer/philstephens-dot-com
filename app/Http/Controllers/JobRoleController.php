<?php

namespace App\Http\Controllers;

use App\Models\JobRole;
use Illuminate\Http\Request;

class JobRoleController extends Controller
{
    public function __invoke(string $slug)
    {
        $role = JobRole::where('slug', $slug)->firstOrFail();

        return view('resume.role', [
            'role' => $role,
        ]);
    }
}
