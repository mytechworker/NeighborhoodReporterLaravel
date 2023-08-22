<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advertise;

class AdvertisementController extends Controller {

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
        return view('advertisement');
    }

    public function store(Request $request) {
        $request->validate([
            'business_name' => 'required',
            'zip_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'exampleRadios' => 'required',
            'about_your_business' => 'required'
        ]);
        $advertise=new Advertise();
        $advertise->business_name = $request->business_name;
        $advertise->zip_code = $request->zip_code;
        $advertise->first_name = $request->first_name;
        $advertise->last_name = $request->last_name;
        $advertise->email = $request->email;
        $advertise->phone_no = $request->phone_no;
        $advertise->advertising_goal = $request->exampleRadios;
        $advertise->about_your_business = $request->about_your_business;
        $advertise->type = 'user';
        $advertise->save();
        //return view('advertisement');
        return redirect()->back()->with('message', 'Advertise created successfully.');
    }
}
