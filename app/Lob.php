<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Lob\Exception\AuthorizationException;
use Lob\Exception\ResourceNotFoundException;
use Lob\Lob as OfficialLob;
use Illuminate\Support\Facades\Log;

use App\User;
use Illuminate\Support\Facades\Input;

class Lob extends Model
{
    protected $table = 'lobs';

    protected $fillable = ['company_id', 'apikey'];

    public $verified = false;

    public $lob;

    public static $states = array(
        'Alabama'=>'AL',
        'Alaska'=>'AK',
        'Arizona'=>'AZ',
        'Arkansas'=>'AR',
        'California'=>'CA',
        'Colorado'=>'CO',
        'Connecticut'=>'CT',
        'Delaware'=>'DE',
        'Florida'=>'FL',
        'Georgia'=>'GA',
        'Hawaii'=>'HI',
        'Idaho'=>'ID',
        'Illinois'=>'IL',
        'Indiana'=>'IN',
        'Iowa'=>'IA',
        'Kansas'=>'KS',
        'Kentucky'=>'KY',
        'Louisiana'=>'LA',
        'Maine'=>'ME',
        'Maryland'=>'MD',
        'Massachusetts'=>'MA',
        'Michigan'=>'MI',
        'Minnesota'=>'MN',
        'Mississippi'=>'MS',
        'Missouri'=>'MO',
        'Montana'=>'MT',
        'Nebraska'=>'NE',
        'Nevada'=>'NV',
        'New Hampshire'=>'NH',
        'New Jersey'=>'NJ',
        'New Mexico'=>'NM',
        'New York'=>'NY',
        'North Carolina'=>'NC',
        'North Dakota'=>'ND',
        'Ohio'=>'OH',
        'Oklahoma'=>'OK',
        'Oregon'=>'OR',
        'Pennsylvania'=>'PA',
        'Rhode Island'=>'RI',
        'South Carolina'=>'SC',
        'South Dakota'=>'SD',
        'Tennessee'=>'TN',
        'Texas'=>'TX',
        'Utah'=>'UT',
        'Vermont'=>'VT',
        'Virginia'=>'VA',
        'Washington'=>'WA',
        'West Virginia'=>'WV',
        'Wisconsin'=>'WI',
        'Wyoming'=>'WY'
    );

    public function startLob() {
        if ( null == $this->lob ) {
            $this->lob = new OfficialLob( $this->apikey );
        }
    }

    public function verifySenderAddress() {
        $from_user = User::find( auth()->user()->settings->master_user_id );
        try {
            $this->verifyAddress($from_user);
        } catch ( ResourceNotFoundException $e ) {
            return false;
        }
        return true;
    }

    public function verifyKey() {

        $this->startLob();
        try {
            $this->lob->postcards()->all( ['limit' => 2, 'offset' => 0] );
        } catch ( AuthorizationException $e ) {
            if ( 'Unauthorized' == $e->getMessage() ) {
                $this->verified = false;
                return;
            }
        }
        $this->verified = true;
    }



    public function createAddress(User $u, Address $a ) {
        $lob_address = $this->lob->addresses()->create(array(
            'name'              => $u->name,
            'address_line1'     => $a->address,
            'address_line2'     => $a->address2,
            'address_city'      => $a->city,
            'address_state'     => isset(static::$states[$a->state]) ? static::$states[$a->state] : $a->state,
            //'address_country'   => 'US',
            'address_zip'       => $a->zip,
        ));
        $a->lob_adr_id = $lob_address['id'];
        return $lob_address;
    }

    public function verifyAddress(User $u, Address $a ) {
        $primary_line = $a->address;
        if ( !is_null($a->address2) ) {
            $primary_line = $a->address . ' ' . $a->address2;
        }
        $lob_return = $this->lob->usVerifications()->verify(array(
            'primary_line'     => $primary_line,
            'city'      => $a->city,
            'state'     => isset(static::$states[$a->state]) ? static::$states[$a->state] : $a->state,
            'zip_code'  => $a->zip,
        ));
        $a->lob_verified =  ( 'deliverable' == $lob_return['deliverability'] ) ? 1 : 0;
        $a->lob_response = json_encode($lob_return);
        $a->save();

        return $lob_return;
    }


    public function sendCheck( Request $request, User $u, $amount ) {

        /*
https://app.incentful.loc/

user id 1 - send check

company id 3

11:32:44 PM) tinyhippo: iateadonut: look at all of the fireModelEvent() calls in \Illuminate\Database\Eloquent\Model


the thing is this works: ['lob_verified'=>'2', 'lob_response'=>'n'] + $request->only($input)
$request->only($input) + ['lob_verified'=>'2', 'lob_response'=>'n']
the second version keeps the keys but not the values of the added array in the new array



    Copied
Test API Key:
    Copied
API Version:
    2016-06-30 Outdated Version

  live_b34bf034adf37acb52f6b933e2850f12dff


array:10 [▼
  "id" => "us_ver_8e43d0ac3138d"
  "recipient" => ""
  "primary_line" => "2005 NUGGET DR"
  "secondary_line" => ""
  "urbanization" => ""
  "last_line" => "CLEARWATER FL 33755"
  "deliverability" => "no_match"
  "components" => array:25 [▼
    "primary_number" => "2005"
    "street_predirection" => ""
    "street_name" => "NUGGET"
    "street_suffix" => "DR"
    "street_postdirection" => ""
    "secondary_designator" => ""
    "secondary_number" => ""
    "pmb_designator" => ""
    "pmb_number" => ""
    "extra_secondary_information" => ""
    "city" => "CLEARWATER"
    "state" => "FL"
    "zip_code" => "33755"
    "zip_code_plus_4" => ""
    "zip_code_type" => "standard"
    "delivery_point_barcode" => ""
    "address_type" => ""
    "record_type" => ""
    "default_building_address" => false
    "county" => "PINELLAS"
    "county_fips" => "12103"
    "carrier_route" => ""
    "carrier_route_type" => ""
    "latitude" => null
    "longitude" => null
  ]
  "deliverability_analysis" => array:8 [▼
    "dpv_confirmation" => ""
    "dpv_cmra" => ""
    "dpv_vacant" => ""
    "dpv_footnotes" => array:1 [▶]
    "ews_match" => false
    "lacs_indicator" => "N"
    "lacs_return_code" => "00"
    "suite_return_code" => ""
  ]
  "object" => "us_verification"
]


array:10 [▼
  "id" => "us_ver_1831780d97d03"
  "recipient" => ""
  "primary_line" => "2006 NUGGET DR"
  "secondary_line" => ""
  "urbanization" => ""
  "last_line" => "CLEARWATER FL 33755-1344"
  "deliverability" => "deliverable"
  "components" => array:25 [▼
    "primary_number" => "2006"
    "street_predirection" => ""
    "street_name" => "NUGGET"
    "street_suffix" => "DR"
    "street_postdirection" => ""
    "secondary_designator" => ""
    "secondary_number" => ""
    "pmb_designator" => ""
    "pmb_number" => ""
    "extra_secondary_information" => ""
    "city" => "CLEARWATER"
    "state" => "FL"
    "zip_code" => "33755"
    "zip_code_plus_4" => "1344"
    "zip_code_type" => "standard"
    "delivery_point_barcode" => "337551344069"
    "address_type" => "residential"
    "record_type" => "street"
    "default_building_address" => false
    "county" => "PINELLAS"
    "county_fips" => "12103"
    "carrier_route" => "C017"
    "carrier_route_type" => "city_delivery"
    "latitude" => 27.994122289186
    "longitude" => -82.768239931702
  ]
  "deliverability_analysis" => array:8 [▼
    "dpv_confirmation" => "Y"
    "dpv_cmra" => "N"
    "dpv_vacant" => "N"
    "dpv_footnotes" => array:2 [▶]
    "ews_match" => false
    "lacs_indicator" => ""
    "lacs_return_code" => ""
    "suite_return_code" => ""
  ]
  "object" => "us_verification"
]
         */

        $this->startLob();

        //MAKE SURE BUSINESS HAS ADDRESS
        //dd( $request->_company );
        if ( !$request->_company->has('address') ) {
            //@todo
            //FIGURE OUT WHAT TO DO IF BUSINESS HAS NO ADDRESS
        } else {
            $ba = $request->_company->address->first();
        }

        $business_address = [
            'name'              => $request->_company->company_name,
            'address_line1'     => $ba->address,
            'address_line2'     => $ba->address2,
            'address_city'      => $ba->city,
            'address_state'     => isset(static::$states[$ba->state]) ? static::$states[$ba->state] : $ba->state,
            'address_zip'       => $ba->zip
        ];

        //dd( $this->verifyAddress( $u, $u->address->first() ) );
        //dd($u->address);

        //IF USER DOES NOT HAVE AN ADDRESS
        if ( !$u->has('address') ) {
            //@todo
            //SEND MESSAGE TO COMPANY

            //SEND MESSAGE/EMAIL TO USER

        //SEND A CHECK
        } else {

            //VERIFY ADDRESS WITH lob.com
            if ( 0 == $u->address->first()->lob_verified ) {
                $this->verifyAddress( $u, $u->address->first() );
            }

            //CHECK AGAIN
            if ( 0 == $u->address->first()->lob_verified ) {
                //@todo CAN'T SEND A CHECK, NO VERIFIABLE ADDRESS
                //SEND MESSAGE TO COMPANY

                //SEND MESSAGE/EMAIL TO USER

            } elseif ( 1 == $u->address->first()->lob_verified ) {
                if ( null == $u->address->first()->lob_adr_id ) {
                    $this->createAddress( $u, $u->address->first() );
                }
            }

            //$this->lob = new OfficialLob( $this->apikey );
            $bank_account_id = $this->lob->bankAccounts()->all()[0]['id'];

            if ( null != $u->address->first()->lob_adr_id ) {
                $this->lob->checks()->create([
                    'description' => 'Reward Check',
                    'to' => $u->address->first()->lob_adr_id,
                    'from' => $business_address,
                    'bank_account' => $bank_account_id,
                    'amount' => $amount
                ]);
            }



        }
        dd($u->address);

    }

    /*
     * copied from Unim - non-functioning
     */
    public function sendPostcard( $u, $a ) {

        $lob = new OfficialLob( $this->apikey );

        $from_user = User::find( auth()->user()->settings->master_user_id );

        try {

            $to_verified = $this->verifyAddress($u)['address'];
            unset($to_verified['object']);
            $to_verified['name'] = $u->displayName;
            $to = $lob->addresses()->create( $to_verified );

            $from_verified = $this->verifyAddress($from_user)['address'];
            unset($from_verified['object']);
            $from_verified['name'] = $from_user->displayName;
            $from = $lob->addresses()->create( $from_verified );

            //Log::info( print_r($u, 1) );
            //Log::info( print_r($to, 1) );

            $pcard_array = [
                'description'   => $a->name,
                'to'            => $to['id'],
                'from'          => $from['id'],
                'front'         => $a->renderedHtml,
                //'front'         => 'https://exults.alx3.com/public/file/121216',
                //'message'       => $a->content
            ];

            if ( $a->back_or_message == AutoContact::Message ) {
                $pcard_array['message'] = $a->content;
            } elseif ( $a->back_or_message == AutoContact::Back ) {
                $pcard_array['back'] = $a->postcard_back->fullUrl;
            } else {
                return;
            }
            //Log::info( print_r($pcard_array, 1) );

            $lob->postcards()->create($pcard_array);

        } catch ( \Lob\Exception\ResourceNotFoundException $e ) {
            Log::info( $e->getMessage() );

            $department = $from_user->settings->departments()->first()->id;
            $subject = 'Verify address';
            $description = "Please verify this user's address.  It failed to verify when attempting to send a postcard through lob.com.";
            $dueDate = date('Y-m-d', strtotime('now'));
            $client = $u->id;

            foreach ( ['department', 'subject', 'description', 'dueDate', 'client'] as $in ) {
                Input::merge([$in=>$$in]);
            }
            app()->make('TicketsController')->postCreateRequest();

        }


    }

}
