<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function userpage(){
//        dd(session('user'));
        return view('user/userpage');
    }
}
