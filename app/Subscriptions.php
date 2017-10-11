<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    protected $table = 'subscriptions';
    protected $fillable = ['user_id', 'company_id', 'subscription_name', 'stripe_id', 'stripe_plan', 'amount', 'quantity', 'trial_ends_at', 'ends_at'];

}
