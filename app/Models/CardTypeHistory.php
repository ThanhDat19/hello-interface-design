<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardTypeHistory extends Model
{
    protected $table      = 'tbl_card_type_history';
    protected $primaryKey = 'history_id';
    public    $timestamps = false;
    protected $fillable = [
        'ref_card_type_id',
        'card_type_name',
        'description',
        'is_hero',
        'create_user_id',
        'create_date',
        'update_user_id',
        'update_date',
        'version',
    ];
}
