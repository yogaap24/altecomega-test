<?php

namespace Database\Seeders;

use App\Models\Table\NotificationTable;
use App\Models\Table\UserTable;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = UserTable::all();
        foreach ($users as $key => $user) {
            NotificationTable::create([
                "id" => "00000002-0000-0000-0000-00000000001".$key,
                'title' => 'Welcome Notification',
                'body' => "<b>Halo $user->name,</b> selamat datang",
                'receiver_id' => $user->id,
            ]);
        }
    }
}
