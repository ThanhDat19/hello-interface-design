<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardTypeHistory extends Model
{
    const     KEY_CRYPT   = 'cardtypehistory';
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

    public function cardType() {
        return $this->hasOne('App\Models\CardType', 'card_type_id', 'ref_card_type_id');
    }

    public function createUser() {
        return $this->hasOne('App\Models\User', 'user_id', 'create_user_id');
    }

    public function updateUser() {
        return $this->hasOne('App\Models\User', 'user_id', 'update_user_id');
    }
}