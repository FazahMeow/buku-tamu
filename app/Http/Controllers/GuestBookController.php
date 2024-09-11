<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    public function index(){
        return view('guestbook.index');
    }

    public function create(){
        return view('guestbook.create');
    }
}
