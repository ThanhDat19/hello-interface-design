<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    const     KEY_CRYPT       = 'card';
    const     CODE            = 'CARD';
    const     KEY_TABLE       = 'tbl_card';
    const     FOLDER_FILE     = 'cardgame';
    const     CONTROLLER_NAME = 'CardAPIController';
    protected $table          = 'tbl_card';
    protected $primaryKey     = 'card_id';
    public    $timestamps     = false;
    protected $fillable       = [
        'card_code',
        'card_name',
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
    ];
    public function cardType() {
        return $this->hasOne('App\Models\CardType','card_type_id','card_type_id');
    }
    public function createUser() {
        return $this->hasOne('App\Models\User', 'user_id', 'create_user_id');
    }
    public function updateUser() {
        return $this->hasOne('App\Models\User', 'user_id', 'update_user_id');
    }
}
