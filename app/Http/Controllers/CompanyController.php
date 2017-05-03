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

    public function allCompanies( Request $request ) {

        $companies = Company::orderBy('company_name')->get();

        return view('company.all')
            ->with( compact('companies') );

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

        // Save uploaded logo file url
        if ($request->file('logo')) {
            $company->logo = $request->file('logo')->store('company-logos');
            $company->save();
        }

        return redirect( route('get-company', ['id'=>$company->id]) );

    }

    public function getCompany(Request $request, $id) {

        $company = Company::find($id);

        return view('company.company')
            ->with(compact('company'));

    }

}
