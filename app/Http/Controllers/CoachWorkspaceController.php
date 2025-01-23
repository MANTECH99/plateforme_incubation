<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachWorkspaceController extends Controller
{
    public function index()
    {
        return view('workspace.coach');
    }
}
