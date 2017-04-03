<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use File;
use App\Models\TemplateModel;
use Storage;
class EditorController extends Controller
{
    /*
    * model: none
    * view: admin/editor-html
    * method: GET
    */
    public function index(){
    	return view('admin.editor.index');
    }
    /*
    * model: TemplateModel
    * view: admin/editor-html/json
    * method: GET
    */
    public function json(){
    	$id = Storage::get('templates/page.txt');
    	$template = TemplateModel::find((int)$id);
    	$get_modules = base_path().'/resources/views/templates/'.$template->folder.'/modules';
    	$get_widgets = base_path().'/resources/views/templates/'.$template->folder.'/widgets';
    	$get_general = base_path().'/resources/views/templates/'.$template->folder;
        $get_css = base_path().'/public/'.$template->folder.'/css';
        $get_js = base_path().'/public/'.$template->folder.'/js';
    	$modules = [];
    	$widgets = [];
    	$generals = [];
        $css_files = [];
        $js_files = [];

    	foreach(File::files($get_modules) as $module)
    	{
    		$modules[] = ['name'=>explode('/modules/', $module)[1], 'file'=> $module];
    	}
    	
    	foreach(File::files($get_widgets) as $widget)
    	{
    		$widgets[] = ['name'=>explode('/widgets/', $widget)[1], 'file'=> $widget];
    	}

    	foreach(File::files($get_general) as $general)
    	{
    		$generals[] = ['name'=>explode('/'.$template->folder.'/', $general)[1], 'file'=> $general];
    	}
        foreach(File::files($get_css) as $css)
        {
            if(str_is('*.css',$css))
            {
                $css_files[] = ['name'=>explode('/'.$template->folder.'/css/', $css)[1], 'file'=> $css];
            }
        }
        foreach(File::files($get_js) as $js)
        {
            if(str_is('*.js',$js))
            {
                $js_files[] = ['name'=>explode('/'.$template->folder.'/js/', $js)[1], 'file'=> $js];
            }
        }
        
    	return response()->json([
    		'modules' => $modules,
    		'widgets' => $widgets,
    		'general' => $generals,
            'css' => $css_files,
            'js' => $js_files,
            
    	]);
    }
    /*
    * model: TemplateModel
    * view: admin/editor-html/{editor}/{path}
    * method: GET
    */
    public function open($editor, $path){
    	$id = Storage::get('templates/page.txt');
    	$template = TemplateModel::find((int)$id);
    	$file = base_path();
    	switch ($path) {
    		case 'widgets':
    			$file .= '/resources/views/templates/'.$template->folder.'/'.$path.'/'.$editor;
    		break;
    		
    		case 'modules':
    			$file .= '/resources/views/templates/'.$template->folder.'/'.$path.'/'.$editor;
    		break;

    		case 'general':
    			$file .= '/resources/views/templates/'.$template->folder.'/'.$editor;
    		break;

            case 'css':
                $file .= '/public/'.$template->folder.'/'.$path.'/'.$editor;
            break;

            case 'js':
                $file .= '/public/'.$template->folder.'/'.$path.'/'.$editor;
            break;
    	}

    	if(File::exists($file))
    	{
    		$content = File::get($file);
    		return response()->json([
    			'is_file' => true,
    			'content' => $content,
    			'file_edit' => $file		
    		]);
    	}
    	else
    	{
    		return response()->json([
    			'is_file' => false,
    			'content' => ''		
    		]);
    	}
    }
    /*
    * model: none
    * view: admin/editor-html/save
    * method: POST
    */
    public function save(Request $request)
    {
    	$text = $request->text_file;
    	$file_edit = $request->file;
    	if(File::exists($file_edit))
    	{
    		if(File::put($file_edit, $text))
    		{
    			return response()->json([
	    			'status' => 'is',
	    			'status_desc' => 'Saved !'	
    			]);
    		}
    	}

    }
}
