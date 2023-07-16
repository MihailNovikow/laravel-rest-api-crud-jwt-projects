<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function index()
    {
        $users = User::All();
        return $users;
    }
    public function singleUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        return $user;
    }

}
