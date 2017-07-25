<?php

namespace App\Traits;

use App\Address;

trait AddressTrait {


    public function addDefaultAddress() {

        $request = request();
        if ( null == $request->input('address')) {
            return null;
        }
        $input = [];
        $address = new Address();
        foreach ($address->getFillable() as $c) {
            if ( isset($request->$c) ) {
                $input[] = $c;
            }
        }
        $address = $this->address()->create(
            $request->only($input)
        );
        $this->address()->updateExistingPivot($address->id, ['default'=>1]);
        return $address;
    }

    /*
     * update default address to a user from a request
     */
    public function updateDefaultAddress() {

        $request = request();
        if ( null == $request->input('address')) {
            return null;
        }

        $input = [];
        $address = new Address();
        foreach ($address->getFillable() as $c) {
            $input[] = $c;
        }
        //THIS REMOVES LOB VERIFICATION INFO FOR THE OLD ADDRESS
        $address = $this->address()->first()->update(
            array_merge($request->only($input), ['lob_verified'=>'0', 'lob_response'=>null])
        //['lob_verified'=>'0', 'lob_response'=>null] + $request->only($input)
        );
        $this->address()->updateExistingPivot($this->address()->first()->id, ['default'=>1]);
        return $address;
    }
}