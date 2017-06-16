<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogEmail extends Model
{
    protected $table = 'logs_email';

    protected $fillable = ['user_id', 'recipient_id', 'thread_id', 'company_id'];
}
