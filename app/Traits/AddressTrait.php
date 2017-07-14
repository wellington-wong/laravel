<?php

namespace App\Traits;

use App\Address;

trait AddressTrait {

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
        if (null === $this->address()->first()) { return; }
        $address = $this->address()->first()->update(
            $request->only($input)
        );
        $this->address()->updateExistingPivot($this->address()->first()->id, ['default'=>1]);
        return $address;
    }
}