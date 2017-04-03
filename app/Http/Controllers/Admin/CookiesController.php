<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Storage;

class CookiesController extends Controller
{
    /*
    * model: none
    * view: admin/policy-cookies
    * method: GET
    */
    public function index(){
    	$content = Storage::disk('local')->get('modules/cookies/cookies.txt');
    	return view('admin.cookies.index')
    		->with('content', $content);
    }
    /*
    * model: none
    * view: admin/policy-cookies/update
    * method: PUT
    */
    public function update(Request $request){
    	Storage::disk('local')->put('modules/cookies/cookies.txt', $request->content);
    	return response()->json([
            'status' => 'is',
            'status_desc' => 'SAVED !'
        ]);
    }

}
