<?php

namespace App\Models\Table;

use App\Models\Entity\Notification;

class NotificationTable extends Notification
{

    /**
     * Get notification receiver.
     */
    public function receiver(){
        return $this->belongsTo(UserTable::class, 'receiver_id');
    }
}
