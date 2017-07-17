<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cmgmyr\Messenger\Models\Thread;
use App\Thread as ThreadByCompany;
use App\EmailTemplate;
use App\Traits\PhoneTrait;
use App\Traits\AddressTrait;
use App\Referral;

class Company extends Model
{
    use PhoneTrait;
    use AddressTrait;
    
    protected $table = 'companies';

    protected $fillable = ['company_name', 'subdomain', 'owner_id'];

    public function owner() {
        return $this->hasOne(User::class);
    }

    public function addresses() {
        return $this->belongsToMany(Address::class, 'company_address');
    }

    public function address() {
        return $this->addresses()->where('default', 1);
    }

    public function phones() {
        return $this->belongsToMany(Phone::class, 'company_phone');
    }

    public function phone() {
        return $this->phones()->where('default', 1);
    }

    public function members() {
        return $this->membersByRole('member');
    }

    public function admins() {
        return $this->membersByRole('admin');
    }

    public function superAdmins() {
        return $this->membersByRole('superadmin');
    }

    public function emailLogs() {
        return $this->hasMany( LogEmail::class )->with('sender', 'recipient');
    }

    public function membersByRole( $role ) {
        if( !is_array($role) ) { $role = [$role]; }
        $role_ids = Role::whereIn('name', $role)->pluck('id');

        return $this->hasManyThrough( User::class, RoleUser::class , 'company_id', 'id' )
            ->whereIn('role_id', $role_ids);
    }

    public function threads() {
        return $this->hasManyThrough( Thread::class, ThreadByCompany::class, 'company_id', 'id' );
    }

    public function forms() {
        return $this->hasMany( ReferralForms::class );
    }

    public function emailTemplate() {
        return $this->hasOne( EmailTemplate::class );
    }

    public function lob() {
        return $this->hasOne( Lob::class );
    }

    public function referrals() {
        $request = request();
        return $this->hasMany( Referral::class );
    }

    /**
     * Sort Referrals
     * @return
     */
    public function filterSortReferralSubmissions($defaultSort = 'created_at') {

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
        $referrals = $this->referrals();

        if ((auth()->user()->hasRole('member'))) {
            $referrals->where('referrer_id', auth()->user()->id);
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
                $referrals->orderBy('id', $sort);
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
