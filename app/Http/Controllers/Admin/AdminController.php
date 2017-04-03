<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use File;
use App\Models\VisitsModel;


class AdminController extends Controller
{
	/*
    * model: none
    * view: admin
    * method: GET
    */
    public function index(){
        return view('admin.dashboard');
    }
    /*
    * model: VisitsModel
    * view: admin/json
    * method: GET
    */
    public function json(){
    	$visit = new VisitsModel(VisitsModel::get());
    	$table_month = [];
        $table_year = [];
    	foreach($visit->groupMonth() as $key=>$month)
    	{
    		if(explode('-',$key)[0] == date('Y', time()+7200))
    		{
    			$table_month[] = ['year_month' => $key, 'numbers' => $month->sum('numbers') ];
    		}
    	}

        foreach($visit->groupYear() as $key=>$year)
        {
            $table_year[] = ['year' => $key, 'numbers' => $year->sum('numbers') ];
        }
    	return response()->json([
    		'month' => $table_month,
            'year' => $table_year,
            'countDay' => $visit->countDay(),
            'countMonth' => $visit->countMonth(),
            'countYear' => $visit->countYear()
    	]);
    }


}
