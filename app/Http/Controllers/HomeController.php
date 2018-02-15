<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {      
    }

    /**
     * Display the default home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Auth::user() !== null && Auth::user()->hasAnyPermission(['Administer Roles & Permissions', 'Edit Collection', 'View Collection']))
        return redirect('/list');
      else
        return view('home');
    }
}
