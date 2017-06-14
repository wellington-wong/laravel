<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = 'role_user';
}
