<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleSuperAdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'super_admin')
            ->paginate(5);

        return view('pages.role.super_admin.index', compact('users'));
    }
}
