<?php

namespace App\Http\Controllers;

use App\Address;
use App\Company;
use App\Stripe;
use App\BasicPages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\Handler;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Log;

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
            'zip'=>'required|digits:5',
            'company_name'=>'required',
            'subdomain'=>'required|unique:companies|not_in:app,www',
            'phone'=>'required|phone:LENIENT,AUTO,US',
            'logo_blob' => 'required',
        ];

        $messages = [
            'logo_blob.required' => 'The logo field is required.',
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        $company = $request->user()->companies()
            ->create( $request->only('owner_id', 'company_name', 'subdomain') );
        $address = $company->address()->create(
            $request->only('address', 'address2', 'city', 'state', 'zip')
        );

        $request->merge(['country'=>'']);
        $request->merge(['country_code'=>'']);
        $phone = $company->phone()->create(
            $request->only('country', 'country_code', 'phone')
        );
        $company->addresses()->updateExistingPivot($address->id, ['default'=>1]);
        $company->phones()->updateExistingPivot($phone->id, ['default'=>1]);

        // Save uploaded logo file url
        if ($request->file('logo')) {
            $company->logo = $request->file('logo')->store('company-logos');
            $company->save();
        }

        return redirect( route('get-company', ['id'=>$company->id]) );

    }

    /**
     * Show company
     *
     * @return
     */
    public function getCompany(Request $request, $id) {

        // Prepare variables
        $_company = Company::find($id);
        $user = auth()->user();
        $hosts = explode('.', $request->getHost());
        $shareUrl = 'https://' . (isset($_company->subdomain) ? $_company->subdomain : '') . '.' . $hosts[1] . '.' . $hosts[2];

        $address = $_company->address()->first();

        return view('company.company')
            ->with(compact('_company', 'shareUrl', 'user', 'address'));

    }

    /**
     * Update company
     *
     * @return
     */
    public function postUpdate(Request $request) {

        if (Gate::denies('update-post', $request->_company)){
            return back()->withErrors('You do not have permission to update this company.');
        }

        $rules = [
            'company_name'=>'required',
            'email'=>'nullable|email',
            'website'=>'nullable|url'
        ];

        $request->merge([
            'address' => $request->get('address') ?: '',
            'address2' => $request->get('address2') ?: '',
            'city' => $request->get('city') ?: '',
            'state' => $request->get('state') ?: '',
            'zip' => $request->get('zip') ?: '',
        ]);        

        $messages = [
            'website.url' => 'Please use complete url starting with "http://" or "https://"',
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        $company = Company::find($request->get('company_id'));
        if (isset($company)) {
            $company->company_name = $request->get('company_name');
            $company->email = $request->get('email');
            $company->website = $request->get('website');
            $company->save();
        }

        $company->updateDefaultAddress($request);
        $company->updateDefaultPhone($request);

        return back()->with('success', ['Company profile successfully saved.']);

    }

    /**
     * Update logo via ajax
     *
     * @return
     */
    public function postUpdateLogo(Request $request, $id) {

        // Save new uploaded logo to current company
        $company = Company::find($id); 
        if ($request->file('update-logo')) {
            $company->logo = $request->file('update-logo')->store('company-logos');
            $company->save();
        }

        return back();
    }

    /**
     * Update credit card
     *
     * @return
     */
    public function updateCard ( Request $request ) {

        $billingTerms = BasicPages::fetch('billing-terms', 0)->first();
        return view('company.update-card')->with(compact('billingTerms'));
    }

    /**
     * Update credit card
     *
     * @return
     */
    public function postUpdateCard ( Request $request ) {

        $rules = [
            'stripe_id'=>'required',
            'card_brand'=>'required',
            'card_last_four'=>'required',
            'bus_plan'=>'required',
            'cc_accept_terms'=>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        // Create strip customer
        try {
            $customer = Stripe::createCustomer();         
        } catch(\Exception $e) {

            Log::error($e);
            $h = new Handler( Container::getInstance() );
            $h->sendEmail($e);

            return back()->with('error', 'Your credit card has been declined. Please try again or contact us.');
        }       

        // Save new credit card.
        $request->_company->stripe_id = $customer->id;
        $request->_company->card_brand = $request->input('card_brand');
        $request->_company->card_last_four = $request->input('card_last_four');
        $request->_company->current = true;
        $request->_company->save();

        return back()->with('success', [(isset($request->_company->card_brand) ? $request->_company->card_brand : 'Credit card' ) . ' ending in ' . (isset($request->_company->card_last_four) ? $request->_company->card_last_four : 'N/A') . ' successfully saved.']);
    }

    /**
     * Delete company
     *
     * @return
     */
    public function postDeleteCompany ( Request $request ) {

        return 'delete company';
    }

}
