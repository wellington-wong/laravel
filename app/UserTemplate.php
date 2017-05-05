<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTemplate extends Model
{
    protected $table = 'user_templates';

    const TEMPLATE_ID_GLOBALADMIN 	= 1;
    const TEMPLATE_ID_SUPERADMIN 		= 2;
    const TEMPLATE_ID_ADMIN 		= 2;
    const TEMPLATE_ID_MEMBER 		= 2;
}
