<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;

class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = AdminNotification::findOrFail($id);

        $notification->update([
            'is_read' => 1
        ]);

        if($notification->url){
            return redirect($notification->url);
        }

        return back();
    }
}