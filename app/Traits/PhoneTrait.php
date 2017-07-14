<?php

namespace App\Traits;

trait PhoneTrait {

    /*
     * update default phone number to a user from a request
     */
    public function updateDefaultPhone() {

        $request = request();
        if ( null == $request->input('phone')) {
            return null;
        } else {
            $request->merge(['phone'=>Phone::sanitize($request->input('phone'))]);
            $request->merge(['number'=>Phone::sanitize($request->input('phone'))]);
            $request->merge(['country'=>'']);
            $request->merge(['country_code'=>'']);
        }
        $input = [];
        $phone = new Phone();
        foreach ($phone->getFillable() as $c) {
            if ( isset($request->$c) ) {
                $input[] = $c;
            }
        }
        $phone = $this->phones()->first()->update(
            $request->only($input)
        );
        $this->phone()->updateExistingPivot($this->phones()->first()->id, ['default'=>1]);
        return $phone;
    }
}