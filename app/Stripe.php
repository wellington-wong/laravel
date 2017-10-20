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
 
   /**
    * Create a new Stripe customer for a given user.
    *
    * @var Stripe\Customer $customer
    * @param string $token
    * @return Stripe\Customer $customer
    */
    public function createStripeCustomer($token)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SK'));
 
        $customer = \Stripe\Customer::create(array(
            "description" => auth()->user()->email,
            "source" => $token
        ));
 
        Auth::user()->stripe_id = $customer->id;
        Auth::user()->save();
 
        return $customer;
    }
 
   /**
    * Check if the Stripe customer exists.
    *
    * @return boolean
    */
    public function isStripeCustomer()
    {
        return Auth::user() && \App\User::where('id', Auth::user()->id)->whereNotNull('stripe_id')->first();
    }
 
   /**
    * Get plan for a company
    *
    * $token
    * @return boolean
    */
    public function getCompanyPlan( $token )
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SK'));
 
        $plan = \Stripe\Plan::retrieve(array(
            "id" => $token,
        ));
 
        return $plan;
    }
 
   /**
    * Get stripe all customers
    *
    * @return boolean
    */
    public function getAllCustomers( )
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SK'));
 
        $customers = \Stripe\Customer::all([ 'limit' => 100 ]);
        $customersData = $customers->data;
        $lastCustomer = end($customers->data);

        // Get all stripe customers
        // use while to overcome the 100 customers per server request.
        while ( $customers->has_more && isset($lastCustomer) ) {
            $customers = \Stripe\Customer::all([
                'limit' => 100,
                'starting_after' => $lastCustomer->id
            ]);
            $customersData = array_merge($customersData, $customers->data);
            $lastCustomer = end($customers->data);
        }

        return $customersData;
    }

}
