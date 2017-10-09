<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(User $user)
    {
        if ($user->id != auth()->id()) {
            return redirect('users/' . auth()->id());
        }

        return view('users.index');
    }
}
