<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopsisController extends Controller
{

    public function index()
    {
        return view('hasil-seleksi.topsis');
    }
}
