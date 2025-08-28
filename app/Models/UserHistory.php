<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $table      = 'tbl_user_history';
    protected $primaryKey = 'history_id';
    public    $timestamps = false;
    protected $fillable   = [
        'ref_user_id',
        'fullname',
        'nickname',
        'email',
        'password',
        'username',
        'phone',
        'role',
        'create_user_id',
        'create_date',
        'update_user_id',
        'update_date',
        'access_token',
        'version',
    ];
}
