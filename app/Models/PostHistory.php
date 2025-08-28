<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostHistory extends Model
{
    protected $table      = 'tbl_post_history';
    protected $primaryKey = 'history_id';
    public    $timestamps = false;
    protected $fillable = [
        'ref_post_id',
        'title',
        'content',
        'create_user_id',
        'create_date',
        'update_user_id',
        'update_date',
        'version',
    ];
}
