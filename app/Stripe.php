<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stripe extends Model
{
    public static function createCustomer () {

    	$request = request();

    	// Set stripe api key
        \Stripe\Stripe::setApiKey(env('STRIPE_SK'));

        // Create stripe customer
        return \Stripe\Customer::create(array(
            "description" => $request->_company->name,
            "email" => $request->input('email'),
            "source" => $request->input('stripe_id'),
            "plan" => $request->input('bus_plan')
        ));

    }
}
