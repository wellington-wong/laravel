<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $table = "notifications";

	public function referrer(){
		return $this->hasOne(User::class, 'id', 'notifiable_id');
	}

}
