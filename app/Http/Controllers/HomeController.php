<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $questions = $user->questions()->paginate(6);
        return view('home')->with('questions', $questions);
    }

    public function admin (Request $req)
    {
        return view('middleware')->withMessage("Admin");
    }

    public function super_admin (Request $req)
    {
        return view('middleware')->withMessage("Super Admin");
    }

    public function member (Request $req)
    {
        return view('middleware')->withMessage("Member");
    }



}
