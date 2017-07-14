<?php

namespace App\Traits;

use User;

trait Phone {

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
        $address = $this->address()->first()->update(
            $request->only($input)
        );
        $this->address()->updateExistingPivot($this->address()->first()->id, ['default'=>1]);
        return $address;
    }
}