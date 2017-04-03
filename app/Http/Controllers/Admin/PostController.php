<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\PostCategoryModel;
use Storage;
use Auth;
use File;
use Cache;

class PostController extends Controller
{
	/*
    * model: PostModel
    * view: admin/posts
    * method: GET
    */
    public function index(){
    	return view('admin.posts.index');
    } 
    /*
    * model: PostModel
    * view: admin/posts/json
    * method: GET
    */
    public function json(){
    	return PostModel::with(['post_category'=>function($query){
    		$query->with('category');
    	}])->orderBy('created_at','DESC')->paginate(10);
    }
    /*
    * model: PostModel
    * view: admin/posts/create
    * method: GET
    */
    public function create(){
    	$category = CategoryModel::get();
    	return view('admin.posts.create')
    		->with('category', $category);
    }
    /*
    * model: PostModel
    * view: admin/posts/create
    * method: POST
    */
    public function store(Requests\PostRequest $request){
    	$time = time();
    	
    	if($request->file('image') != null)
    	{
    		$ext = $request->file('image')->getClientOriginalExtension();
    		$image = 'post-image-'.$time.'.'.$ext;
			$request->file('image')->move(public_path().'/storage/posts/',$image);
		}
		else{
			$image = 'none.png';
		}    	

    	$description = 'post-text-'.$time.'.txt';
    	Storage::put('posts/'.$description, $request->description);

    	$post = PostModel::create([
    		'user_id' => Auth::user()->id,
    		'image' => $image,
    		'subject' => trim($request->subject),
    		'slug' => str_slug($request->subject,'-'),
    		'description' => $description,
    		'position' => PostModel::count() + 1,
    		'active' => $request->active,
    	]);
    	if(count($request->category_id) > 0)
    	{
	    	foreach($request->category_id as $cat_id)
	    	{
	    		PostCategoryModel::create([
	    			'post_id' => $post->id,
	    			'category_id' => $cat_id,
	    		]);
	    	}
	    }
    	Cache::forever('posts', PostModel::with(['post_category'=>function($query){
                return $query->with('category');
            }])->orderBy('position','DESC')->where('active',1)->get());
    	return redirect()->route('posts');
    }
    /*
    * model: PostModel
    * view: admin/posts/edit/{id}
    * method: GET
    */
    public function edit($id){
    	$category = CategoryModel::get();
    	$post = PostModel::with('post_category')->findOrFail($id);
    	return view('admin.posts.edit')
    		->with('category', $category)
    		->with('post', $post);
    }
    /*
    * model: PostModel
    * view: admin/posts/edit/{id}
    * method: PUT
    */
    public function update(Requests\PostRequest $request, $id){
    	$time = time();
    	$post = PostModel::findOrFail($id);
    	Storage::put('posts/'.$post->description, $request->description);
    	$is_new = false;
        $is_file = $post->image != 'none.png' ? true : false;
    	if($request->file('image') != null)
    	{
            $is_file ? '' : File::delete('storage/posts/'.$post->image);
        	$is_new = true;
    	    $ext = $request->file('image')->getClientOriginalExtension();
    	    $image = 'post-image-'.$time.'.'.$ext;
    		$request->file('image')->move(public_path().'/storage/posts/',$image);
    		
		}
		
    	$post->update([
    		'subject' => $request->subject,
    		'slug' => str_slug($request->subject,'-'),
    		'active' => $request->active,
    		'image' => $is_new ? $image : $post->image,
    	]);
    	
    	$post_category = PostCategoryModel::where('post_id',$post->id)->get();
    	$not_delete_ids = array();

    	if(count($request->category_id) > 0)
    	{
	    	foreach($request->category_id as $cat_id)
	    	{
	    		if($post_category->where('category_id',$cat_id)->count() == 0)
	    		{
	    			PostCategoryModel::create([
	    				'post_id' => $post->id,
	    				'category_id' => $cat_id
	    			]);
	    			$not_delete_ids[] = (int)$cat_id;
	    		}
	    		elseif($post_category->where('category_id',$cat_id)->count() == 1){
	    			$not_delete_ids[] = (int)$cat_id;
	    		}
	    	}
		    PostCategoryModel::where('post_id',$post->id)->whereNotIn('category_id',$not_delete_ids)->delete();
	    }
	    else{
	    	PostCategoryModel::where('post_id',$post->id)->delete();
	    }
        Cache::forever('posts', PostModel::with(['post_category'=>function($query){
                return $query->with('category');
            }])->orderBy('position','DESC')->where('active',1)->get());
    	return redirect()->back();
    }
    /*
    * model: PostModel
    * view: admin/posts/edit/position/{id}
    * method: PUT
    */
    public function position(Request $request, $id){
    	$post = PostModel::findOrFail($id);
    	$post->position = $request->position;
    	$post->save();
        Cache::forever('posts', PostModel::with(['post_category'=>function($query){
                return $query->with('category');
            }])->orderBy('position','DESC')->where('active',1)->get());
    	return response()->json(['status'=>'is','status_desc'=>'Successful change position', 'post'=> $post]);
    }
    /*
    * model: PostModel
    * view: admin/posts/delete/{id}
    * method: GET
    */
    public function destroy($id){
    	$post = PostModel::findOrFail($id);
    	if($post->image != 'none.png')
    	{
    		$file_image = 'storage/posts/'.$post->image;
    		$exists_1 = File::exists($file_image);
    	}
    	else{
    		$exists_1 = true;
    	}
    	$file_text = 'posts/'.$post->description;
        $exists_2 = Storage::disk('local')->exists($file_text);
        if($exists_1 && $exists_2)
        {
        	$post->image != 'none.png' ? File::delete($file_image) : '';
            Storage::delete($file_text);
        	$post->delete();
            Cache::forever('posts', PostModel::with(['post_category'=>function($query){
                return $query->with('category');
            }])->orderBy('position','DESC')->where('active',1)->get());
        	return response()->json(['status'=>'is','status_desc'=>'Removed post !']);
        }
        else
        {
        	return response()->json(['status'=>'is','status_desc'=>'Not removed page !']);
        }
    	

    }
    /*
    * Summernote upload image to server 
    */
    public function upload(Request $request){
        $plik = $request->file('file');
        $name_file = 'zdjeciegerro-'.time().'.'.$plik->getClientOriginalExtension();
        $plik->move(public_path().'/storage/posts/upload', $name_file);

        return url('/').'/storage/posts/upload/'.$name_file;
    }


}
