<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $projects = auth()->user()->projects()->paginate(12);

        return view('dashboard', compact('projects'));
    }
}
