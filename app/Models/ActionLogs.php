<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLogs extends Model
{
    protected $table      = 'tbl_action_logs';
    protected $primaryKey = 'action_log_id';
    public    $timestamps = false;
    protected $fillable = [
        'action_route',
        'action_date',
        'action_user',
        'action_type',
        'action_content',
        'ref_object_type',
        'ref_object_id',
    ];
}
