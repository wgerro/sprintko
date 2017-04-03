<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\GeneralModel;
use App\Models\EnvModel;
use File;
use Cache;

class GeneralController extends Controller
{
    /*
    * model: EnvModel
    * view: admin/general
    * method: GET
    */
    public function index(){
        $robots = File::get('robots.txt');
        $class = new EnvModel();
    	return view('admin.general.index')
            ->with('robots', $robots)
            ->with('api_facebook_app', $class->api_facebook_app)
            ->with('api_facebook_secret', $class->api_facebook_secret);
    }
    /*
    * model: GeneralModel
    * view: admin/general/json
    * method: GET
    */
    public function json(){
    	return GeneralModel::findOrFail(1);
    }
    /*
    * model: GeneralModel
    * view: admin/general/update
    * method: PUT
    */
    public function update(Request $request){
    	$general = GeneralModel::findOrFail(1);
    	$is_file = false;
    	if($request->file('image') != null)
    	{
            $is_none = $general->logo != 'none.png' ? true : false; 
            $is_none ? File::delete($general->logo) : '';
	    	$is_file = true;
	   		$name = time().'logo.'.$request->file('image')->getClientOriginalExtension();
	 		$file = 'storage/'.$name;
    		$request->file('image')->move(public_path().'/storage',$file);
	    	
    	}
    	
    	$general->articles_count = (int)$request->articles_count;
        $general->api = $request->api;
        $general->logo = $is_file ? $file : $general->logo;
        $general->google_verification = $request->google_verification;
        $general->gallery_widgets = $request->gallery_widgets;
        $general->search_widgets = $request->search_widgets;
        $general->article_widgets = $request->article_widgets;
        $general->category_widgets = $request->category_widgets;
        $general->error_widgets = $request->error_widgets;
        $general->save();

        $robots = 'robots.txt';
        File::put($robots, $request->content_robots);
        Cache::forever('global', GeneralModel::get());
        return response()->json([
        	'status' => 'is',
        	'status_desc' => 'SAVED !',
            'logo' => $is_file ? $file : '',
        ]);
    }
    /*
    * model: EnvModel
    * view: admin/general/update-api
    * method: PUT
    */
    public function update_api(Request $request){
        $class = new EnvModel();
        $class->api_facebook_app = $request->api_facebook_app;
        $class->api_facebook_secret = $request->api_facebook_secret;
        $env = $class->env();

        File::put(base_path().'/.env', $env);
        return response()->json([
            'status' => 'is',
            'status_desc' => 'SAVED !'
        ]);
    }

}
