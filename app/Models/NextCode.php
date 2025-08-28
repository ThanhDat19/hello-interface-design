<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextCode extends Model
{
    protected $table      = 'tbl_next_code';
    protected $primaryKey = 'next_code_id';
    public    $timestamps = false;
    protected $fillable   = [
        'table_name',
        'increament',
        'max_value',
        'cur_value',
    ];
    public static function _nextCode($table_name = '') {
        $next_val = 1;
        if ($table_name) {
            $next_code = NextCode::where('table_name', $table_name)->first();
            if ($next_code) {
                $next_val = $next_code->cur_value;
                NextCode::where('next_code_id', $next_code->next_code_id)->update([
                    'cur_value' => $next_val + 1,
                ]);
            } else {
                $next_val = 1;
                $data     = [
                    'table_name' => $table_name,
                    'cur_value'  => 2,
                    'increament' => 1,
                ];
                NextCode::create($data);
            }
        }
        return $next_val;
    }
    public static function createCode ($table_name, $prefix_code) {
        $number = self::_nextCode($table_name);
        $code = "$prefix_code" . str_pad($number, 9, 0,  STR_PAD_LEFT);
        return $code;
    }
}
