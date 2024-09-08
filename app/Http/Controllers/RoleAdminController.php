<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleAdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'admin')
            ->paginate(5);

        return view('pages.role.admin.admin_index', compact('users'));
    }
}
