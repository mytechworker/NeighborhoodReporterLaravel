<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller {

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
    public function create() {
        return view('submit_request');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'email' => 'required',
            'description' => 'required',
            'attachement' => 'mimes:jpg,png,jpeg,gif,pdf,doc,docx,html,csv,ppt,txt,svg',
        ]);

        $ticket = new Ticket;
        $ticket->email = $request->email;
        $ticket->description = $request->description;
        $ticket->town = $request->town;
        $ticket->url = $request->url;
        if ($request->hasFile('attachement')) {
            $files = $request->file('attachement');
            $filename = $files->getClientOriginalName();
            $files->move('images', $filename);
            $src = $filename;
            $ticket->attachement = $src;
        }
        $ticket->save();
        return redirect()->back()->with('message', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket) {
        //
    }

}
