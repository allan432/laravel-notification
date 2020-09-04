<?php

namespace App\Http\Controllers\Users\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecruiterNotificationController extends Controller
{
    public function show()
    {
    	$notifications = auth()->user()->unreadNotifications;

        return view('users.recruiter.notifications.show', [
        	'notifications' => $notifications
        ]);
    }
}
