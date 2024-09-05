<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function showUser()
    {
        $users = User::where('role', 'user')
            ->paginate(5);

        return view('pages.role.user.user_index', compact('users'));
    }
}
