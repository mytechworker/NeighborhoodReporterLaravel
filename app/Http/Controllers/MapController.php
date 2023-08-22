<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('map');
    }

}
