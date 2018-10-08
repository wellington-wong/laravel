<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReviews extends Model
{

	protected $table = 'user_reviews';

	protected $fillable = ['user_id', 'company_id', 'url', 'screenshot'];

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}

}
