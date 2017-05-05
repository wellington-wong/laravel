<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTemplate extends Model
{
    protected $table = 'user_templates';

    const TEMPLATE_ID_GLOBALADMIN 	= 1;
    const TEMPLATE_ID_SUPERADMIN 		= 2;
    const TEMPLATE_ID_ADMIN 			= 3;
    const TEMPLATE_ID_MEMBER 			= 4;

    public function newQuery() {
        $q = parent::newQuery();
        if ( Auth::user() ) { //NEED THIS IN CASE A MIGRATION NEEDS TO ACCESS ALL
            $q->whereIn( 'user_template.subdomain_id', [0, Auth::user()->settings->id ]);
        }
        return $q;
    }

    public static function listUserTemplateNames() {

        return self::select('id', 'name')
            ->pluck('name', 'id');

    }

    public static function getUserTemplates() {

        return self::select('*')
            ->get();

    }
}
