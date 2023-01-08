<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class UsersBaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('public.users.profile');
    }
}
