<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardHistory extends Model
{
    protected $table      = 'tbl_card_history';
    protected $primaryKey = 'history_id';
    public    $timestamps = false;
    protected $fillable   = [
        'card_code',
        'card_name',
        'ref_card_id',
        'card_type_id',
        'description',
        'defense_stat',
        'magic_stat',
        'support_stat',
        'attack_stat',
        'dodge_stat',
        'create_user_id',
        'create_date',
        'update_user_id',
        'update_date',
        'version',
    ];
}
