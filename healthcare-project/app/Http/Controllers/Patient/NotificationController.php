<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the patient's notifications.
     */
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        // Mark unread notifications as read
        auth()->user()->unreadNotifications->markAsRead();

        return view('patient.notifications.index', compact('notifications'));
    }
}