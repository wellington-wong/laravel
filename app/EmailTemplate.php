<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{

    protected $table = 'email_templates';

    protected $fillable = ['user_id', 'company_id', 'email_html'];

    public function owner() {
    	return $this->hasOne(User::class);
    }

    public function prepareEmail($referral) {
    	return dd($referral);
    }

}
