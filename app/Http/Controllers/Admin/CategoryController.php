<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CategoryModel;
use Validator;
use App\Models\PostModel;
use App\Models\MediaAlbumsModel;
use Cache;
use App\Models\MediaSingleModel;
class CategoryController extends Controller
{
    /*
    * model: none
    * view: admin/category
    * method: GET
    */
    public function index(){
    	return view('admin.category.index');
    }
    /*
    * model: CategoryModel
    * view: admin/category/json
    * method: GET
    */
    public function json(){
    	return CategoryModel::paginate(10);
    }
    /*
    * model: CategoryModel
    * view: admin/category/create
    * method: POST
    */
    public function create(Request $request){
    	$validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:category'
            ]
        );

        if ($validation->fails()) {
            return response()->json(['status'=>'not','status_desc'=>'Category can not be same !', 'category'=> '']);
        }
        else{
	    	$category = CategoryModel::create([
	    		'name' => $request->name,
	    		'description' => $request->description,
	    		'slug' => str_slug($request->name,'-'),
	    	]);
            Cache::forever('category', CategoryModel::get());
	    	return response()->json(['status'=>'is','status_desc'=>'Added new categories', 'category'=> $category]);
	    }
    }
    /*
    * model: CategoryModel
    * view: admin/category/edit/{id}
    * method: PUT
    */
    public function update(Request $request, $id){
    	$validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:category,name,'.$id,
            ]
        );
        if ($validation->fails()) {
            return response()->json(['status'=>'not','status_desc'=>'Category can not be same !', 'category'=> '']);
        }
        else{
	    	$category = CategoryModel::findOrFail($id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->slug = str_slug($request->name,'-');
            $category->save();
            Cache::forever('category', CategoryModel::get());
	    	return response()->json(['status'=>'is','status_desc'=>'Able to edit', 'category'=> $category]);
	    }
    }
    /*
    * model: CategoryModel
    * view: admin/category/delete/{id}
    * method: GET
    */
    public function destroy($id){
    	$cat = CategoryModel::findOrFail($id);
    	if($cat->delete())
    	{
            //category
            Cache::forever('category', CategoryModel::get());
            //posts
            Cache::forever('posts', PostModel::with(['post_category'=>function($query){
                return $query->with('category');
            }])->orderBy('position','DESC')->where('active',1)->get());
            //files to albums media
            Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])
            ->orderBy('position','DESC')->where('active',1)->get());
            //media single
            Cache::forever('media-single', MediaSingleModel::with('category')->orderBy('position','DESC')->where('active',1)->get());
            
    		return response()->json(['status'=>'is','status_desc'=>'Removed category !']);
    	}
    	else{
    		return response()->json(['status'=>'is','status_desc'=>'Not removed category !']);
    	}
    }
}
