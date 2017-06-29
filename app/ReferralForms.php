<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralForms extends Model
{

	protected $table = 'referral_forms';

    protected $fillable = ['company_id', 'form_name', 'raw_form_json'];
    public $timestamps = true;
}
