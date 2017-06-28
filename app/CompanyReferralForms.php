<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyReferralForms extends Model
{

	protected $table = 'company_referral_forms';

    protected $fillable = [
    	'company_id', 'template_name', 'raw_form_data'
    ];
}
