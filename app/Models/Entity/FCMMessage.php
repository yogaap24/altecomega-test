<?php

namespace App\Models\Entity;

use Illuminate\Database\Eloquent\Model;

class FCMMessage extends Model
{
    public $data;
    public $notification;
    public $timeToLive;
    public $priority;

    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    public function notification(array $notification = [])
    {
        $this->notification = $notification;

        return $this;
    }

    public function priority(string $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function timeToLive(int $timeToLive)
    {
        if ($timeToLive < 0) {
            $timeToLive = 0; // (0 seconds)
        }
        if ($timeToLive > 2419200) {
            $timeToLive = 2419200; // (28 days)
        }

        $this->timeToLive = $timeToLive;

        return $this;
    }
}
