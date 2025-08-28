<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table      = 'tbl_post';
    protected $primaryKey = 'post_id';
    public    $timestamps = false;
    protected $fillable = [
        'title',
        'content',
        'create_user_id',
        'create_date',
        'update_user_id',
        'update_date',
    ];
}
