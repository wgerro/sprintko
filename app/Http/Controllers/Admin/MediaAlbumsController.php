<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MediaAlbumsModel;
use App\Models\CategoryModel;
use File;
use Cache;
class MediaAlbumsController extends Controller
{
    public function index(){
    	$category = CategoryModel::get();
    	return view('admin.media-albums.index')
    		->with('category', $category);
    }

    public function json(){
    	return MediaAlbumsModel::with('category')->paginate(10);
    }

    public function create(Request $request){
    	$time = time();

    	if($request->file('url') != null)
    	{
            File::isDirectory('storage/media-albums') ? ' ' : File::makeDirectory('storage/media-albums');
	    	$ext = $request->file('url')->getClientOriginalExtension();
	    	$name = 'album-'.$time.'.'.$ext;
	    	$request->file('url')->move(public_path().'/storage/media-albums/',$name);
	    }
	    else
	    {
	    	$name = 'none.png';
	    }
        $n = trim($request->name=='') ? time() : $request->name;
    	$album = MediaAlbumsModel::create([
    		'category_id' => $request->category_id == 'null' ? null : $request->category_id,
    		'name' => $n,
    		'url' => '/storage/media-albums/'.$name,
    		'slug' => str_slug($n,'-'),
            'type' => str_slug($request->type,'-'),
    		'active' => $request->active,
    		'position' => MediaAlbumsModel::count() + 1
    	]);

        /*
        * CACHE
        */
        Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])->orderBy('position','DESC')->where('active',1)->get());
    	
        return response()->json(['status'=>'is','status_desc'=>'Added album', 'album'=> MediaAlbumsModel::with('category')->find($album->id)]);

    }

    public function update(Request $request, $id){
    	$album = MediaAlbumsModel::with('category')->findOrFail($id);
    	$exists = 'storage/'.explode('/storage/',$album->url)[1];
    	$time = time();
        $is_file = false;
        
    	if($request->file('url_2') != null)
    	{
    		if(File::exists($exists))
    		{
    			if(File::delete($exists))
    			{
                    $is_file = true;
	    			$ext = $request->file('url_2')->getClientOriginalExtension();
			    	$name = 'album-'.$time.'.'.$ext;
			    	$request->file('url_2')->move(public_path().'/storage/media-albums/',$name);
			    }
    		}
    		else{
    			return 'brak';
    		}
	    }
	    $album->category_id = $request->category_id_2 == 'null' ? null : $request->category_id_2;
	    $album->url = $is_file ? '/storage/media-albums/'.$name : $album->url;
	    $album->name = $request->name_2;
	    $album->slug = str_slug($request->name_2,'-');
	    $album->active = $request->active_2;
        $album->type = str_slug($request->type,'-');
	    $album->position = $request->position_2;
	    $album->save();

        /*
        * CACHE
        */
        Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])->orderBy('position','DESC')->where('active',1)->get());

	    return response()->json(['status'=>'is','status_desc'=>'Able to edit', 'album'=> MediaAlbumsModel::with('category')->findOrFail($id)]);
        //return redirect()->back();

    }


    public function destroy($id){
    	$album = MediaAlbumsModel::with('files')->findOrFail($id);
    	$exists = 'storage/'.explode('/storage/',$album->url)[1];
    	if(File::exists($exists))
    	{
    		File::delete($exists);
            foreach($album->files as $file)
            {
                $file = 'storage/'.explode('/storage/',$file->url)[1];
                if(File::exists($file))
                {
                    File::delete($file);
                }
            }
    		$album->delete();
            /*
            * CACHE
            */
            Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])->orderBy('position','DESC')->where('active',1)->get());
            return response()->json(['status'=>'is','status_desc'=>'Removed album!']);
    	}
    	else{
    		return response()->json(['status'=>'not','status_desc'=>'Not removed album!']);
    	}
    }
}
