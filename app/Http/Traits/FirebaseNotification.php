<?php

namespace App\Http\Traits;

use App\Models\Table\NotificationTable;
use App\Models\Table\UserTable;
use App\Notifications\GeneralNotification;

trait FirebaseNotification
{
    public function sendNotification(UserTable $user, $title, $body, $type = 'INFO', $image_url = null)
    {
        $notification = NotificationTable::create([
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'receiver_id' => $user->id,
            'image_url' => $image_url,
        ]);
        $user->notify(new GeneralNotification($notification));
        return $notification;
    }
}
