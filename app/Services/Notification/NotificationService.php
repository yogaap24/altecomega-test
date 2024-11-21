<?php

namespace App\Services\Notification;

use App\Http\Traits\FirebaseNotification;
use App\Models\Table\NotificationTable;
use App\Models\Table\UserTable;
use App\Services\AppService;
use App\Services\AppServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationService extends AppService implements AppServiceInterface
{
    use FirebaseNotification;

    public function __construct(NotificationTable $model)
    {
        parent::__construct($model);
    }


    public function dataTable($filter)
    {
        return NotificationTable::datatable($filter)->where('receiver_id', Auth::id())->paginate($filter->entries ?? 15);
    }

    public function getById($id)
    {
        $notification = NotificationTable::where('receiver_id', Auth::id())->findOrFail($id);
        $notification->update([
           'read_at' => Carbon::now(),
        ]);
        return $notification;
    }

    public function create($data)
    {
        $user = UserTable::findOrFail($data->receiver_id);
        return $this->sendNotification($user, $data->title, $data->body);
    }

    public function update($id, $data)
    {
        $notification = NotificationTable::where('receiver_id', Auth::id())->findOrFail($id);
        $notification->update([
            'title' => $data->title,
            'body' => $data->body,
            'read_at' => Carbon::parse($data->read_at),
            'receiver_id' => $data->receiver_id,
        ]);
        return $notification;
    }

    public function delete($id)
    {
        $notification = NotificationTable::where('receiver_id', Auth::id())->findOrFail($id);
        $notification->delete();
        return $notification;
    }
}
