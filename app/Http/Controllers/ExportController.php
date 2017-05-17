<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * public function referrals
     * This action returns all user referrals
     * @param integer user ID of the referral
     * @return
     */     
    public function referral( Request $request, $id )
    {

        \Excel::create('Filename', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {

            $sheet->fromArray(array(
                array('data1', 'data2'),
                array('data3', 'data4')
            ));

            });

        })->export('xls');

    	return;
    }

    /**
     * public function referrals
     * This action returns all user referrals
     *
     * @return
     */     
    public function referrals( Request $request, $id )
    {

        \Excel::create('Filename', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {

            $sheet->fromArray(array(
                array('data1', 'data2'),
                array('data3', 'data4')
            ));

            });

        })->export('xls');

    	return;
    }
}
