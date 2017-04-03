<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PageModel;
use App\Models\CategoryModel;
use App\Models\PageModuleModel;
use App\Models\PageSubModel;
use Storage;
use Validator;
use Cache;
use App\Models\TemplateModel;
class PageController extends Controller
{
    public $modules = [
            1 => 'articles',
            2 => 'media with albums',
            3 => 'media single',
            4 => 'cookies',
            5 => 'form contact',
    ];

    public $block_name = [  'storage',
                            'admin',
                            'install',
                            'article',
                            'albums',
                            'media-albums',
                            'media-single',
                            'category',
                            'json',
                            'search',
                            'sitemap',
                            'create-comment',
                            'send-mail',
                            'login',
                            'register',
                            'doc'];
    /*
    * model: none
    * view: admin/pages
    * method: GET
    */
    public function index(){
    	return view('admin.pages.index')
            ->with('modules',$this->modules);
    }
    /*
    * model: PageModel
    * view: admin/pages/json
    * method: GET
    */
    public function json(){
    	return PageModel::with(['category','module','sub'=>function($query){
            $query->with('page');
        }])->paginate(10);
    }
    /*
    * model: CategoryModel, PageModel
    * view: admin/pages/create
    * method: GET
    */
    public function create(){
        $category = CategoryModel::get();
        $pages = PageModel::where('id','>',1)->get();
    	return view('admin.pages.create')
            ->with('modules', $this->modules)
            ->with('pages', $pages)
            ->with('category',$category);
    }
    /*
    * model: PageModel, TemplateModel
    * view: admin/pages/create
    * method: POST
    */
    public function store(Requests\PageRequest $request){
        $templates = TemplateModel::get();
        foreach($templates as $tmp)
        {
                array_push($this->block_name, $tmp->folder);
        }
        $new_name = 'example'.time();
        $name = strtolower(str_slug($request->slug,'-'));
        $check_slug = in_array($name , $this->block_name) ? $new_name : $name;
    	$page = PageModel::create([
	    		'name' => trim($request->name),
                'slug' => $check_slug,
		        'title' => $request->title,
		        'description' => $request->description,
		        'keyword' => $request->keyword,
		        'robots' => $request->robots,
		        'active' => $request->active,
                'position' => (PageModel::count() + 1),
		        'category_id' => ($request->category_id=='0')? NULL : $request->category_id,
		        'is_widgets' => $request->is_widgets
    		]);

        if(count($request->module_id) > 0)
        {
            foreach($request->module_id as $module_id)
            {
                PageModuleModel::create([
                    'page_id' => $page->id,
                    'module' => $module_id,
                ]);
            }
        }
        if($request->page_sub_id != 'lack')
        {
            PageSubModel::create([
                'page_id' => $page->id,
                'page_sub_id' => $request->page_sub_id
            ]);
        }

         Cache::forever('pages', PageModel::orderBy('position','ASC')->with(['module','sub'=> function($query){
            $query->with('page');
        }])->where('active',1)->get());
        //pages submenus
        Cache::forever('pages-sub', PageSubModel::with(['page','page_submenu'])->get());
    	return redirect()->route('pages');
    }
    /*
    * model: CategoryModel
    * view: admin/pages/edit/{id}
    * method: GET
    */
    public function edit($id){
        $category = CategoryModel::get();
        if($id != 1)
        {
            $pages = PageModel::with(['module','sub'])->where('id','!=',1)->get();
            $page = $pages->where('id',$id)->first();
    	}
        else{
            $pages = '';
            $page = PageModel::with(['module','sub'])->findOrFail($id);
        }
        return view('admin.pages.edit')
            ->with('category',$category)
            ->with('modules',$this->modules)
            ->with('pages', $pages)
    		->with('page',$page);
    }
    /*
    * model: PageModel
    * view: admin/pages/edit/{id}
    * method: PUT
    */
    public function update(Requests\PageRequest $request, $id){
    	$page = PageModel::with(['module','sub'])->findOrFail($id);

        if($page->id != 1)
        {
            $templates = TemplateModel::get();
            foreach($templates as $tmp)
            {
                array_push($this->block_name, $tmp->folder);
            }
            $new_name = 'example'.time();
            $name = strtolower(str_slug($request->slug,'-'));
            $check_slug = in_array($name , $this->block_name) ? $page->slug : $name;
        }

    	$page->name = trim($request->name);
        if($page->id != 1)
        {
            $page->slug = $check_slug;
        }
        $page->title = $request->title;
        $page->description = $request->description;
        $page->keyword = $request->keyword;
        $page->robots = $request->robots;
        if($page->id != 1)
        {
            $page->active = $request->active;
            $page->category_id = ($request->category_id=='0')? NULL : $request->category_id;
        }
        $page->is_widgets = $request->is_widgets;
        $page->save();
        //Operation in modules
        $not_delete_ids = array();
        if(count($request->module_id) > 0)
        {
            foreach($request->module_id as $module_id)
            {
                if($page->module->where('module',$module_id)->count() == 0)
                {
                    PageModuleModel::create([
                        'page_id' => $page->id,
                        'module' => $module_id,
                    ]);
                    $not_delete_ids[] = (int)$module_id;
                }
                elseif($page->module->where('module',$module_id)->count() == 1)
                {
                    $not_delete_ids[] = (int)$module_id;
                }
                
            }
            PageModuleModel::where('page_id',$page->id)->whereNotIn('module',$not_delete_ids)->delete();
        }
        else{
            PageModuleModel::where('page_id',$page->id)->delete();
        }
        if($page->id != 1)
        {
            //Page submenu
            if($request->page_sub_id == 'lack')
            {
                PageSubModel::where('page_id',$id)->delete();
            }
            else{
                $check = PageSubModel::where('page_id',$id)->where('page_sub_id',$request->page_sub_id)->count();
                if($check == 0)
                {
                    if($page->sub)
                    {
                        PageSubModel::where('page_id',$page->id)->where('page_sub_id',$page->sub->page_sub_id)->delete();
                    }
                    PageSubModel::create([
                        'page_id' => $page->id,
                        'page_sub_id' => $request->page_sub_id
                    ]);
                }
                else{

                }
            }
        }
         Cache::forever('pages', PageModel::orderBy('position','ASC')->with(['module','sub'=> function($query){
            $query->with('page');
        }])->where('active',1)->get());
        //pages submenus
        Cache::forever('pages-sub', PageSubModel::with(['page','page_submenu'])->get());
        return redirect()->back();
    }
    /*
    * model: PageModel
    * view: admin/pages/edit/position/{id}
    * method: PUT
    */
    public function position(Request $request, $id)
    {
        $page = PageModel::with(['category','module','sub'=>function($query){
            $query->with('page');
        }])->findOrFail($id);
        $page->position = $request->position;
        $page->save();
         Cache::forever('pages', PageModel::orderBy('position','ASC')->with(['module','sub'=> function($query){
            $query->with('page');
        }])->where('active',1)->get());
        //pages submenus
        Cache::forever('pages-sub', PageSubModel::with(['page','page_submenu'])->get());
        return response()->json(['status'=>'is','status_desc'=>'Successful change position', 'page'=> $page]);
    }

    public function position_modules(Request $request, $id)
    {
        $page = PageModel::with(['category','module','sub'=>function($query){
            $query->with('page');
        }])->findOrFail($id);
        foreach($page->module as $module)
        {
            PageModuleModel::find($module->id)->update([
                'position' => $request->{'position'.$module->id},
            ]);
        }
         Cache::forever('pages', PageModel::orderBy('position','ASC')->with(['module','sub'=> function($query){
            $query->with('page');
        }])->where('active',1)->get());
        //pages submenus
        Cache::forever('pages-sub', PageSubModel::with(['page','page_submenu'])->get());
        return response()->json(['status'=>'is','status_desc'=>'Successful change module position', 'page'=> PageModel::with(['category','module'])->findOrFail($id)]);
    }

    /*
    * model: PageModel
    * view: admin/pages/delete/{id}
    * method: GET
    */
    public function destroy(Request $request, $id){
        $page = PageModel::with(['contents','page_sub_id'])->find($id);
        foreach($page->contents as $content)
        {
            if(Storage::disk('local')->exists('pages/'.$content->file))
            {
                Storage::delete('pages/'.$content->file);                
            }
        }    
        $ids_deleting = []; //ustawianie tabeli w razie wypadku jakby submenu sie usunelo

        if($page->page_sub_id->count() > 0)
        {
            $ids = [];

            foreach($page->page_sub_id as $page_sub)
            {
                $ids[] = $page_sub->id;
                $ids_deleting[] = $page_sub->page_id;
            }
            PageSubModel::whereIn('id',$ids)->delete();
        }

        $page->delete();
        Cache::forever('pages', PageModel::orderBy('position','ASC')->with(['module','sub'=> function($query){
            $query->with('page');
        }])->where('active',1)->get());
        //pages submenus
        Cache::forever('pages-sub', PageSubModel::with(['page','page_submenu'])->get());
        return response()->json([
            'status'        =>  'is',
            'status_desc'   =>  'Removed page !',
            'ids'           =>   $ids_deleting,
            ]);
        
    }
}
