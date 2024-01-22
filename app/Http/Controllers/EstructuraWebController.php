<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstructuraWebController extends Controller
{
    public function index(){
        return view('dashboard-profil');
    }
}
