<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardType extends Model
{
    const     KEY_CRYPT   = 'cardtype';
    protected $table      = 'tbl_card_type';
    protected $primaryKey = 'card_type_id';
    public    $timestamps = false;
    protected $fillable = [
        'card_type_name',
        'description',
        'is_hero',
        'create_user_id',
        'create_date',
        'update_user_id',
        'update_date',
    ];
}
