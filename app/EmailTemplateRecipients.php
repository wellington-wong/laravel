<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplateRecipients extends Model
{

    protected $table = 'email_template_recipients';

    protected $fillable = ['company_id', 'email_template', 'recipient_id', 'recipient'];

}
