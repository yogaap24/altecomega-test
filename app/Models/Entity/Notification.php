<?php

namespace App\Models\Entity;

use App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends AppModel
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'read_at',
        'receiver_id',
        'fcm_multicast_id',
        'fcm_success',
        'fcm_canonical_ids',
        'fcm_results',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'fcm_multicast_id',
        'fcm_success',
        'fcm_canonical_ids',
        'fcm_results',
    ];
}
