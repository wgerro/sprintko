<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use File;
use ZipArchive;
use App\Models\TemplateModel;
use Storage;
use Validator;
use App\Models\WidgetModel;
use Cache;
class TemplatesController extends Controller
{
    /*
    * model: none
    * view: templates
    * method: GET
    */
    public function index(){
    	$id = Storage::get('templates/page.txt');
    	return view('admin.templates.index')
    		->with('id',(int)$id);
    }
    /*
    * model: TemplateModel
    * view: templates/create
    * method: POST
    */
    public function create(Request $request){
	    	$template = TemplateModel::create([
	    		'name' => str_slug(str_replace('.zip', '', $request->file('file')->getClientOriginalName()),'_').'_'.time(),
	    		'folder' => str_slug(str_replace('.zip', '', $request->file('file')->getClientOriginalName()),'_').'_'.time()
	    	]);

	    	if(File::makeDirectory(base_path().'/public/'.$template->folder))
	        {
	            if(File::makeDirectory(base_path().'/resources/views/templates/'.$template->folder))
	            {
	                $zip = new ZipArchive();
	                $zip->open($request->file('file'));
	                if($zip->extractTo(base_path()."/resources/views/templates/".$template->folder))
	                {
	                    if(File::isDirectory(base_path().'/resources/views/templates/'.$template->folder.'/css'))
	                    {
	                        if(File::copyDirectory(base_path().'/resources/views/templates/'.$template->folder.'/css',base_path().'/public/'.$template->folder.'/css')){
	                            File::deleteDirectory(base_path().'/resources/views/templates/'.$template->folder.'/css'); //usuwanie folderu css
	                        }
	                    }
	                    if(File::isDirectory(base_path().'/resources/views/templates/'.$template->folder.'/js'))
	                    {
	                        if(File::copyDirectory(base_path().'/resources/views/templates/'.$template->folder.'/js',base_path().'/public/'.$template->folder.'/js')){
	                            File::deleteDirectory(base_path().'/resources/views/templates/'.$template->folder.'/js');
	                        }
	                    }
	                    if(File::isDirectory(base_path().'/resources/views/templates/'.$template->folder.'/images'))
	                    {
	                        if(File::copyDirectory(base_path().'/resources/views/templates/'.$template->folder.'/images',base_path().'/public/'.$template->folder.'/images')){
	                            File::deleteDirectory(base_path().'/resources/views/templates/'.$template->folder.'/images');
	                        }
	                    }
	                }
	            }
	        }
            //podczas dodawania nowej templatki trzeba dodac nowe widgety
            $widgets_files = base_path().'/resources/views/templates/gerro/widgets';
            $new_template = base_path().'/resources/views/templates/'.$template->folder.'/widgets';
            $array = File::files($new_template);
            $new_tablica = array();
            foreach($array as $arr)
            {   
                $new_tablica[] = explode('/widgets/', $arr)[1];
            }

            foreach(File::files($widgets_files) as $file)
            {
                $now = explode('/widgets/', $file)[1];
                if(!in_array($now, $new_tablica))
                {
                    File::copy($widgets_files.'/'.$now, $new_template.'/'.$now);
                }
            }
            Cache::forever('template', TemplateModel::get());
	        return response()->json(['status'=>'is','status_desc'=>'Added to template !', 'template'=>$template]);
    	
    }
    /*
    * model: TemplateModel
    * view: templates/edit
    * method: PUT
    */
    public function select(Request $request){
    	Storage::disk('local')->put('templates/page.txt', $request->id);
    	return response()->json(['status'=>'is','status_desc'=>'Changed to template !','id_template'=>$request->id]);
    }
    /*
    * model: TemplateModel
    * view: templates/json
    * method: GET
    */
    public function json(){
    	return TemplateModel::get();
    }
    /*
    * model: TemplateModel
    * view: templates/delete/{id}
    * method: GET
    */
    public function destroy($id){
    	$template = TemplateModel::find($id);
    	if(File::isDirectory(base_path().'/resources/views/templates/'.$template->folder) && File::isDirectory(public_path().'/'.$template->folder))
    	{
    		if(File::deleteDirectory(base_path().'/resources/views/templates/'.$template->folder) && File::deleteDirectory(public_path().'/'.$template->folder))
    		{
    			$template->delete();
                Cache::forever('template', TemplateModel::get());
    			return response()->json(['status'=>'is','status_desc'=>'Removed to template !']);
    		}
    	}
    	else{
    		return response()->json(['status'=>'is','status_desc'=>'Lack folder template !']);
    	}
    	
    }
}
