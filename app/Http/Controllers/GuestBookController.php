<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    public function index(){
        return view('guestbooks.index');
    }

    public function create(){
        return view('guestbooks.create');
    }

    public function store(Request $request){
        dd($request);
    }
}
