<?php

namespace App\Traits;

use App\Referral;
use Carbon\Carbon;

trait ReferralTrait {

    /**
     * Sort Referrals
     * @return
     */
    public function filterSortReferralSubmissions($defaultSort = 'status', $user_id = null) {

        $request = request();

        // Get sort and filter
        $column = $request->has('column') ? $request->get('column') : null;
        $sort = $request->has('sort') ? $request->get('sort') : null;
        $status = $request->has('status') ? $request->get('status') : null;
        $q = $request->has('q') ? strtolower($request->get('q')) : null;

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
            })
            ->orWhereHas('referrer', function ($query) use ($q) {
                $query->where(\DB::raw('lower(first_name)'), 'LIKE', '%' . $q . '%');
                $query->orWhere(\DB::raw('lower(last_name)'), 'LIKE', '%' . $q . '%');
                $query->orWhere(\DB::raw('lower(name)'), 'LIKE', '%' . $q . '%');
            });
        }

        switch ($column) {
            case ('referred'):
                $referrals->select('referrals.*');
                $referrals->join('users', 'users.id', 'referrals.user_id');
                $referrals->orderBy('users.first_name', $sort);
                break;
            case ('referrer_id'):
                $referrals->select('referrals.*');
                $referrals->join('users', 'users.id', 'referrals.referrer_id');
                $referrals->orderBy('users.first_name', $sort);
                break;
            case ('created_at'):
                $referrals->orderBy($column, $sort);
                break;
            case ('id' || 'user_id' || 'status'):
                $referrals->orderBy($column, $sort);
                break;
            default:
                $referrals->orderBy($defaultSort, 'asc');
                break;
        }

        return $referrals;
    }

    /**
     * Prepare referrals for excel export
     * @return
     */
    public function referralsExport( Request $request ) {

        if (count($request->all())) {
            $param = $referrals->getParams();
            if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin'])) {
                $referrals = $request->_company->filterSortReferralSubmissions()->paginate(15);
            } else {
                $referrals = $request->user()->filterSortReferralSubmissions()->paginate(15);
            }
        } else {
            if (auth()->user()->hasRole(['admin', 'superAdmin', 'globalAdmin'])) {
                $referrals = $request->_company->referrals()->orderBy('created_at', 'desc')->paginate(15);
            } else {
                $referrals = $request->user()->referrals()->orderBy('created_at', 'desc')->paginate(15);
            }
        }

        $referralArray = [];
        foreach ($referrals as $referral) {
            $currentReferral = [
                'SUBMITTED' => $referral->referred->created_at->format('m/d/y'),
                'REFERRAL ID' => $referral->id,
                'SUBMITTED BY' => auth()->user()->name,
                'NAME' => $referral->referred->first_name . ' ' . $referral->referred->last_name,
                'EMAIL' => $referral->referred->email,
                'STATUS' => \App\Referral::$status[$referral->status]
            ];
            $referralArray[] = $currentReferral;
        }

        \Excel::create('Referrals', function($excel) use ($referralArray) {
            $excel->sheet('Members', function($sheet) use ($referralArray) {
                $sheet->fromArray($referralArray);
            });
        })->export('xls');
        return;
    }


}