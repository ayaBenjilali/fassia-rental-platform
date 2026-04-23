<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function mentionsLegales()
    {
        return view('legal.mentions-legales');
    }

    public function confidentialite()
    {
        return view('legal.confidentialite');
    }
}
