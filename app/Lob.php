<?php

namespace App;

use Carbon\Carbon;
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

    public $verified = null;

    public $lob;

    public $bankAccounts;
    protected $banksVerified = null;

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

    public function company() {
        return $this->belongsTo(Company::class);
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

    public function numberBankAccounts() {
        $this->startLob();
        $this->verifyKey();
        if ( false == $this->verified ) {
            return 0;
        }
        $this->bankAccounts = $this->lob->bankAccounts()->all();
        return count( $this->bankAccounts );
    }

    public function banksVerified() {
        $this->verifyKey();
        if ( false == $this->verified ) {
            return false;
        }
        $this->numberBankAccounts();
        if ( is_null( $this->banksVerified ) ) {
            if ( count( $this->bankAccounts ) > 0 ) {
                $this->banksVerified = true;
                foreach ( $this->bankAccounts as $b ) {
                    if ( false == $b['verified'] ) {
                        $this->banksVerified = false;
                    }
                }
            }
        }
        return $this->banksVerified;
    }


    public function sendCheck( Request $request, Referral $r, $amount, $memo = null ) {

        
        if( count($r->check) > 0 ) {
            dd($r->check);
        }

        $u = $r->referrer;

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
        if ( 0 == $u->address()->count() ) {
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

            $send_date = new Carbon('today + 3 days');
            $send_date = $send_date->format('Y-m-d');

            if ( null != $u->address->first()->lob_adr_id ) {
                $check = $this->lob->checks()->create([
                    'description' => 'Reward Check',
                    'to' => $u->address->first()->lob_adr_id,
                    'from' => $business_address,
                    'bank_account' => $bank_account_id,
                    'amount' => $amount,
                    'send_date' => $send_date,
                    'memo' => $memo
                ]);

                $this->saveCheck( $check, $r );
                //var_export($check);
            }

        }
        //dd($u->address);

    }


    public function saveCheck( $lob_response, Referral $r ) {

        $c = new Check();
        $c->lob_id          = $this->id;
        $c->company_id      = $this->company->id;
        $c->user_id         = $r->referrer->id;
        $c->lob_check_id    = $lob_response['id'];
        $c->amount          = $lob_response['amount'];
        $c->check_number    = $lob_response['check_number'];
        $c->pdf             = $lob_response['url'];
        $c->thumbnail       = $lob_response['thumbnails'][0]['small'];
        $c->send_date       = Carbon::createFromTimestamp(strtotime($lob_response['send_date']))->format('Y-m-d');
        $c->expected_delivery_date = Carbon::createFromTimestamp(strtotime($lob_response['expected_delivery_date']))->format('Y-m-d');
        $c->lob_response    = json_encode($lob_response);
        $c->save();

        $r->check()->attach($c);

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
