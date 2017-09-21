<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicPages extends Model
{

    protected $table = 'basic_pages';

    protected $fillable = ['company_id', 'route_name', 'title', 'content'];

    const REWARDS = 1;
    const HOW_THIS_WORKS = 2;
    const HOW_TO_GET_MORE_REFERRALS = 3;

    

}
