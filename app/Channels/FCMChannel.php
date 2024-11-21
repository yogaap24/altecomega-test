<?php

namespace App\Channels;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

class FCMChannel
{
    const ENDPOINT = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $key = config('broadcasting.connections.fcm.server_key');
        $token = $notifiable->fcm_token;
        $message = $notification->toFCM($notifiable);

        $payloads = [
            'to' => $token,
            'priority' => $message->priority ?? 'high',
            'notification' => $message->notification,
            'data' => $message->data,
        ];

        if ($message->timeToLive !== null && $message->timeToLive >= 0) {
            $payloads['time_to_live'] = (int) $message->timeToLive;
        }

        $headers = [
            'Authorization' => 'key='.$key,
            'Content-Type' => 'application/json',
        ];

        if(!blank($token) && !blank($key)){
            $result = Http::withHeaders($headers)
                ->post(self::ENDPOINT, $payloads);

            $message->data->update([
                'fcm_multicast_id' => $result->json()['multicast_id'],
                'fcm_success' => $result->json()['success'],
                'fcm_canonical_ids' => $result->json()['canonical_ids'],
                'fcm_results' => json_encode($result->json()['results']),
            ]);
        }
    }
}
