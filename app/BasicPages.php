<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicPages extends Model
{

    protected $table = 'basic_pages';

    protected $fillable = ['company_id', 'route_name', 'title', 'content'];

    const SMALL      = 1;
    const MEDIUM       = 2;
    const ENTERPRISE    = 3;
    
}
