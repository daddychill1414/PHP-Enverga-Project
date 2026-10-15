<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function internationalization()
    {
        return view('pages.internationalization');
    }

    public function sustainability()
    {
        return view('pages.sustainability');
    }
}
