<?php

namespace App\Notifications;

use App\Models\Entity\FCMMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;
    protected $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['fcm'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return FCMMessage
     */
    public function toFcm($notifiable)
    {
        return (new FCMMessage)
            ->notification([
                "title" => $this->notification->title,
                "body" => $this->notification->description,
                "content_available" => true,
                "priority" => "high",
                "click_action" => "FLUTTER_NOTIFICATION_CLICK"
            ])
            ->data($this->notification)
            ->priority('high');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
