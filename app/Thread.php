<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $table = 'company_thread';

    protected $fillable = ['thread_id', 'company_id'];
}
