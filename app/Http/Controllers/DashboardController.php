<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('dashboard', compact('programs'));
    }
}
