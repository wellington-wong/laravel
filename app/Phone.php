<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    protected $table = 'phones';

    protected $fillable = ['country', 'country_code', 'phone'];

    public static function sanitize($phone) {
        return preg_replace("/[^0-9]/","",$phone);
    }

}
