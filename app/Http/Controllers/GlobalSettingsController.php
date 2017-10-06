<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\User;
use App\BasicPages;
use Auth;
use Session;
use Illuminate\Support\Facades\Validator;

class GlobalSettingsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show submit referral member
     *
     * @return view
     */
    public function submitReferralMember(Request $request) 
    {
        return view('global-settings.submit-referral-member');
    }

    /**
     * Show edit member information
     *
     * @return view
     */
    public function editMemberInformation(Request $request) 
    {
        return view('global-settings.edit-member-information');
    }

    /**
     * Show export member information
     *
     * @return view
     */
    public function exportMemberInformation(Request $request) 
    {
        return view('global-settings.export-member-information');
    }

    /**
     * Show add/delete admin
     *
     * @return view
     */
    public function addDeleteAdmin(Request $request) 
    {
        return view('global-settings.add-delete-admin');
    }

    /**
     * Show define user roles
     *
     * @return view
     */
    public function defineUserRoles(Request $request) 
    {
        return view('global-settings.define-user-roles');
    }

    /**
     * Show login as any super admin
     *
     * @return view
     */
    public function loginSuperAdmin(Request $request) 
    {
        return view('global-settings.login-super-admin');
    }

    /**
     * Show login as user
     *
     * @return view
     */
    public function loginAsUser(Request $request) 
    {
        $companies = Company::orderBy('company_name')->get();

        return view('global-settings.login-as-user')
        ->with(compact('companies'));
    }

    /**
     * Show login as user id
     *
     * @return view
     */
    public function loginAsUserId(Request $request, $id) 
    {
        Session::put( 'currentUserId', Auth::user()->id);
        Auth::loginUsingId($id);

        return redirect(route('home'))->with('success', ['Successfully logged in as ' . auth()->user()->getName()]);
    }

    /**
     * Show login as original user
     *
     * @return view
     */
    public function loginAsOrigin(Request $request) 
    {   
        Auth::loginUsingId(Session::get('currentUserId'));
        Session::forget( 'currentUserId' );
        return redirect(route('home'))->with('success', ['Successfully logged in back as ' . auth()->user()->getName()]);
    }

    /**
     * Show edit pages
     *
     * @return view
     */
    public function editBasicPages(Request $request) 
    {   
        // Get constants
        $pageTypes = new \ReflectionClass(new BasicPages());
        $pageTypes = $pageTypes->getConstants();
        $pageTypes = array_splice($pageTypes, 0, count($pageTypes) -2);
    
        return view('global-settings.edit-basic-pages')
            ->with(compact('pageTypes'));
    }

    /**
     * Show edit basic pages
     *
     * @return view
     */
    public function editBasicPage( Request $request, $route ) 
    {   
        
        $basicPage = BasicPages::fetch($route, 0)->first();
        $loremIpsum = 'Lorem ipsum dolor sit amet, quo quidam tacimates et, cum primis neglegentur reprehendunt et. At zril graecis lucilius pri. Ne meliore euripidis scripserit sit, eum labitur facilis deseruisse ne, eam id volutpat interpretaris. Eam ut habeo soluta indoctum. Id nec quot nostro postulant, cu sed vidit mazim, ea repudiandae vituperatoribus mel. Eius aeque ea ius.';

        return view('global-settings.edit-basic-page')
            ->with(compact('basicPage', 'route', 'loremIpsum'));
    }

    /**
     * Post edit basic pages
     *
     * @return view
     */
    public function postEditBasicPage( Request $request, $route ) 
    {   

        $rules = [
            'title'=>'required',
            'content'=>'required',
        ];

        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        $request->merge(['company_id' => 0]);
        $request->merge(['route_name' => $route]);

        if ( $page = BasicPages::fetch($route, 0)->first() ?: null ) {
            $page->update($request->all());            
        } else {
            $page = new BasicPages();
            $page->create($request->all());      
        }
        
        return back()->with('success', ['Page successfully saved']);
    }

    /**
     * Show edit member pages
     *
     * @return view
     */
    public function editMemberPage(Request $request, $route) 
    {   
        
        $basicPage = BasicPages::fetch($route, $request->_company->id)->first();
        $loremIpsum = 'Lorem ipsum dolor sit amet, quo quidam tacimates et, cum primis neglegentur reprehendunt et. At zril graecis lucilius pri. Ne meliore euripidis scripserit sit, eum labitur facilis deseruisse ne, eam id volutpat interpretaris. Eam ut habeo soluta indoctum. Id nec quot nostro postulant, cu sed vidit mazim, ea repudiandae vituperatoribus mel. Eius aeque ea ius.';

        return view('global-settings.edit-member-pages')
            ->with(compact('basicPage', 'route', 'loremIpsum'));
    }

    /**
     * Post edit member pages
     *
     * @return view
     */
    public function postEditMemberPage(Request $request, $route) 
    {   

        $rules = [
            'title'=>'required',
            'content'=>'required',
        ];

        $validator = Validator::make($request->input(), $rules);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()
                ->with(['errors'=>$validator->errors()]);
        }

        $request->merge(['company_id' => $request->_company->id]);
        $request->merge(['route_name' => $route]);

        if ( $page = BasicPages::fetch($route, $request->_company->id)->first() ?: null ) {
            $page->update($request->all());            
        } else {
            $page = new BasicPages();
            $page->create($request->all());      
        }
        
        return back()->with('success', ['Page successfully saved']);
    }
}
