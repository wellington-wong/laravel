<?php

namespace App\Http\Controllers;

use App\Address;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request) {


        return view('company.create');

    }

    public function postCreate(Request $request) {

        $rules = [
            'address'=>'required|max:100',
            'address2'=>'max:25',
            'city'=>'required',
            'state'=>'required|max:2',
            'zip'=>'required|max:11',
            'company_name'=>'required',
            'subdomain'=>'required|unique:companies|not_in:app',
            'phone'=>'required|phone:US'
        ];
        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        $company = $request->user()->companies()
            ->create( $request->only('owner_id', 'company_name', 'subdomain') );
        $address = $company->address()->create(
            $request->only('address', 'address2', 'city', 'state', 'zip')
        );
        $company->addresses()->updateExistingPivot($address->id, ['default'=>1]);

        return redirect( route('get-company', ['id'=>$company->id]) );

    }

    public function getCompany(Request $request, $id) {

        $company = Company::find($id);
        dd($company);

    }

}
