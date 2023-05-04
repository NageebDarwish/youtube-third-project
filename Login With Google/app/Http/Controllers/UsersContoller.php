<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersContoller extends Controller
{
    public function GetUsers()
    {
        return User::all();
    }
}
