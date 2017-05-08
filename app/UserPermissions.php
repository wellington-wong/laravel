<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    protected $table = 'user_permissions';

    protected $fillable = ['user_id', 'permission_id'];

    /**
     * @return UserPermissionTypes
     */
    public function type() {
    	return $this->belongsTo(UserPermissionTypes::class, 'permission_id');
    }

    /**
     * @return UserPermission
     */
    public function user() {
    	return $this->belongsTo(UserPermissions::class, 'permission_id');
    }
}
