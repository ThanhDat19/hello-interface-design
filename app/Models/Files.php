<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table      = 'tbl_files';
    protected $primaryKey = 'file_id';
    public    $timestamps = false;
    protected $fillable = [
        'ref_object_id',
        'controller_name',
        'child_type',
        'path',
        'size',
        'extention',
        'create_user_id',
        'create_date',
    ];
}
