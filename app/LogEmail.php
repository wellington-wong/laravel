<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cmgmyr\Messenger\Models\Thread;

class LogEmail extends Model
{
    protected $table = 'logs_email';

    protected $fillable = ['user_id', 'recipient_id', 'company_id', 'subject', 'body', 'created_at', 'updated_at'];
    public $timestamps = true;

    public function sender (){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function recipient (){
    	return $this->belongsTo(User::class, 'recipient_id');
    }

}
