<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\WidgetModel;
use File;
use App\Models\TemplateModel;
use Storage;
use Cache;
class WidgetController extends Controller
{
    /*
    * model: none
    * view: widgets
    * method: GET
    */
    public function index(){
        //Cache::forever('widgets', WidgetModel::orderBy('position','ASC')->where('active',1)->get());
    	return view('admin.widgets.index');
    }
    /*
    * model: WidgetModel
    * view: widgets/json
    * method: GET
    */
    public function json(){
        return WidgetModel::get();
    }
    /*
    * model: WidgetModel, TemplateModel
    * view: widgets/create
    * method: POST
    */
    public function create(Request $request){
        $templates = TemplateModel::get();
        if(File::isFile(base_path().'/resources/views/templates/gerro/widgets/'.$request->file('file')->getClientOriginalName()))
        {
            $name = time().$request->file('file')->getClientOriginalName();
        }
        else{
            $name = $request->file('file')->getClientOriginalName();
        }
        $file = $request->file('file');
        $exist = base_path().'/resources/views/templates/gerro/widgets/'.$name;
        foreach($templates as $template)
        {
            if($template->id == 1)
            {
                $file->move(base_path().'/resources/views/templates/'.$template->folder.'/widgets/',$name);
            }
            else{
                $exist_new = base_path().'/resources/views/templates/'.$template->folder.'/widgets/'.$name;
                File::copy($exist,$exist_new);
            }
        }
    	$widget = WidgetModel::create([
            'name'=>$request->name,
            'file'=>str_replace('.blade.php','',$name),
            'position'=>WidgetModel::count()+1,
            'active'=>$request->active
        ]);
        Cache::forever('widgets', WidgetModel::orderBy('position','ASC')->where('active',1)->get());
        return response()->json(['status'=>'is','status_desc'=>'Add new widget!','widget'=>$widget]);
    }
    /*
    * model: WidgetModel, TemplateModel
    * view: widgets/edit/{id}
    * method: PUT
    */
    public function update(Request $request, $id){
        $templates = TemplateModel::get();
        $widget = WidgetModel::find($id);
        $is_file = false;
        if($request->file('file') != null)
        {
            foreach($templates as $template)
            {
                $exists = base_path().'/resources/views/templates/'.$template->folder.'/'.$widget->file.'.blade.php';
                if(File::delete($exists))
                {
                    $is_file = true;
                    if(File::isFile(base_path().'/resources/views/templates/gerro/widgets/'.$request->file('file')->getClientOriginalName()))
                        {
                            $name = time().$request->file('file')->getClientOriginalName();
                        }
                        else{
                            $name = $request->file('file')->getClientOriginalName();
                        }
                    $request->file('file')->move(base_path().'/resources/views/templates/'.$template->folder.'/',$name);
                }
            }
        }
        
        
    	if($request->name != '')
        {
            $widget->name = $request->name;
        }
        $widget->file = $is_file ? $name : $widget->file;
    	$widget->active = $request->active;
    	$widget->position = $request->position;
    	$widget->save();
        Cache::forever('widgets', WidgetModel::orderBy('position','ASC')->where('active',1)->get());
		return response()->json(['status'=>'is','status_desc'=>'Saved!','widget'=>$widget]);
    }
    /*
    * model: WidgetModel, TemplateModel
    * view: widgets/delete/{id}
    * method: GET
    */
    public function destroy($id){
    	$widget = WidgetModel::find($id);
        if($widget->id > 4)
        {
            $templates = TemplateModel::get();
            foreach($templates as $template)
            {
                $exists = base_path().'/resources/views/templates/'.$template->folder.'/widgets/'.$widget->file.'.blade.php';
                File::delete($exists);
            }
            $widget->delete();
            Cache::forever('widgets', WidgetModel::orderBy('position','ASC')->where('active',1)->get());
            return response()->json(['status'=>'is','status_desc'=>'Removed widget !']);
        }
    }
}
