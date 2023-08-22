<?php

namespace App\Http\Controllers;

use App\Invite;
use Illuminate\Http\Request;
use Mail;
use App\Mail\InviteMail;

class InviteController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        return view('invite', compact('info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $segment1 = request()->segment1;
        $segment2 = request()->segment2;

        $request->validate([
            'friend_email' => 'required',
            'your_name' => 'required',
        ]);

        $data = [
            'friend_name' => $request->friend_name,
            'friend_email' => $request->friend_email,
            'your_name' => $request->your_name,
        ];
        Invite::insert($data);
        $data1 = [
            'segment1' => $segment1,
            'segment2' => $segment2
        ];
        $data[] = $data1;
        Mail::to($data['friend_email'])->send(new InviteMail($data));
        return redirect()->back()->with('message', 'Invite successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function show(Invite $invite) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function edit(Invite $invite) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invite $invite) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invite $invite) {
        //
    }

}
