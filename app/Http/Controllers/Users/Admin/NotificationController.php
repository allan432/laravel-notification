<?php

namespace App\Http\Controllers\Users\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminToRecruiterNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = \App\Notification::all();
        
        json_decode($notifications, true);

        return view('users.admin.notification', compact('notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
        ]); // validate 

        $users = User::where('role', $request->get('role'))->get();

        if($users->isEmpty()){
            return response()->json(['status' => false ,'message' => "No users found to send notification"]);
        }

        $title = $request->get('title');
        $description = $request->get('description');

        $current_timestamp = Carbon::now()->timestamp;
        $uuid = uniqid();
        $batch_id = $current_timestamp.$uuid;

        Notification::send($users, new AdminToRecruiterNotification($title, $description, $batch_id));
        return response()->json(['status' => true ,'message' => "Notification Created" ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
