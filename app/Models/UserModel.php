<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = "desktop_users";
    public $timestamps = false;
    protected $fillable = [
        'device_id',
        'email',
        'password',
        'server',
    ];
}
