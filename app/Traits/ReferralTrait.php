<?php

namespace App\Traits;

use App\Referral;

trait ReferralTrait {

    /**
     * Sort Referrals
     * @return
     */
    public function filterSortReferralSubmissions($defaultSort = 'created_at', $user_id = null) {

        $request = request();

        // Get sort and filter
        $column = $request->has('column') ? $request->get('column') : null;
        $sort = $request->has('sort') ? $request->get('sort') : null;
        $status = $request->has('status') ? $request->get('status') : null;
        $q = strtolower($request->has('q') ? $request->get('q') : null);

        // Get date range
        $daterange = explode('|', $request->get('daterange'));
        $datarangeFrom = isset($daterange[0]) && (bool)strtotime($daterange[0]) ? $daterange[0] : null;
        $datarangeTo = isset($daterange[1]) && (bool)strtotime($daterange[1]) ? $daterange[1] : null;

        // Change query when sorting and filtering.
        if (isset($user_id)) {
            $referrals = Referral::where('referrer_id',  $user_id )->where('company_id', $request->_company->id);
        } else {
            $referrals = $this->referrals();
        }

        if ((auth()->user()->hasRole('member')) || $user_id) {
            $referrals->where('referrer_id', isset($user_id) ? $user_id : auth()->user()->id);
        }

        if (isset($status)) {
            $referrals->where('status', $status);
        }

        if (isset($datarangeFrom) && isset($datarangeTo)) {
            $referrals->whereBetween('created_at', [Carbon::parse($datarangeFrom)->toDateTimeString(), Carbon::parse($datarangeTo)->addDay()->toDateTimeString()]);
        }

        if (isset($q)) {
            $referrals->whereHas('referred', function ($query) use ($q) {
                $query->where(\DB::raw('lower(first_name)'), 'LIKE', '%' . $q . '%');
                $query->orWhere(\DB::raw('lower(last_name)'), 'LIKE', '%' . $q . '%');
                $query->orWhere(\DB::raw('lower(name)'), 'LIKE', '%' . $q . '%');
            });
        }

        switch ($column) {
            case ('referred'):
                $referrals->orderBy('user_id', $sort);
                break;
            case ('created_at'):
                $referrals->orderBy($column, $sort);
                break;
            case ('id' || 'user_id' || 'status'):
                $referrals->orderBy($column, $sort);
                break;
            default:
                $referrals->orderBy($defaultSort, 'desc');
                break;
        }

        return $referrals;
    }


}