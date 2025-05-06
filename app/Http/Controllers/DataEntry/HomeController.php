<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // index method
    public function index(){

        return view('data_entry.home.index');

    }
}
