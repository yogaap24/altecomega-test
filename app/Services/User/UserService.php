<?php

namespace App\Services\User;

use App\Models\Table\UserTable;
use App\Services\AppService;
use App\Services\AppServiceInterface;
use Illuminate\Support\Facades\Hash;

class UserService extends AppService implements AppServiceInterface
{

    public function __construct(UserTable $model)
    {
        parent::__construct($model);
    }


    public function dataTable($filter)
    {
        return UserTable::datatable($filter)->paginate($filter->entries ?? 15);
    }

    public function getById($id)
    {
        return UserTable::findOrFail($id);
    }

    public function create($data)
    {
        return UserTable::create([
            'name' => $data->name,
            'email' => $data->email,
            'role' => $data->role,
            'fcm_token' => $data->fcm_token,
            'password' => Hash::make($data->password),
        ]);
    }

    public function update($id, $data)
    {
        $user = UserTable::findOrFail($id);
        $user->update([
            'name' => $data->name,
            'email' => $data->email,
            'role' => $data->role,
            'fcm_token' => $data->fcm_token,
        ]);
        return $user;
    }

    public function delete($id)
    {
        $user = UserTable::findOrFail($id);
        $user->delete();
        return $user;
    }
}
