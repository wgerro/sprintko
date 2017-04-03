<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\MediaSingleModel;
use File;
use Cache;
use App\Models\CategoryModel;
class MediaSingleController extends Controller
{
	/*
    * model: none
    * view: admin/media-single
    * method: GET
    */
    public function index(){
        $category = CategoryModel::get();
    	return view('admin.media-single.index')
            ->with('category', $category);
    }
    /*
    * model: MediaSingleModel
    * view: admin/media-single/json
    * method: GET
    */
    public function json(){
        return MediaSingleModel::with('category')->paginate(10);
    }
    /*
    * model: MediaSingleModel
    * view: admin/media-single/create
    * method: POST
    */
    public function create(Request $request){
    	$formats = ['image','audio','video'];
        $time = time();
    	$table = array();
        //jesli to nie youtube
        if($request->link == '')
        {
            foreach($request->file('files') as $key=>$file)
            {
                File::isDirectory('storage/media-single') ? ' ' : File::makeDirectory('storage/media-single');
                $object = new MediaSingleModel();
                $mime = explode('/', $file->getMimeType())[0];
                if(in_array($mime, $formats))
                {
                    $option = $mime;
                }
                else
                {
                    $option = 'document';
                }
                $ext = $file->getClientOriginalExtension();
                $name = $time.'-'.$key.'.'.$ext;
                $file->move(public_path().'/storage/media-single/',$name);
                $media_single = $object->create([
                    'name' => '#'.$key.' '.$request->name,
                    'url' => '/storage/media-single/'.$name,
                    'active' => $request->active,
                    'position' => $object->count() + 1,
                    'type' => str_slug($request->type,'-'),
                    'category_id' => $request->category_id == 'null' ? null : $request->category_id,
                    'option' => $option
                ]);
                $table[] = [
                    'id' => $media_single->id,
                    'name' => '#'.$key.' '.$request->name,
                    'url' => '/storage/media-single/'.$name,
                    'active' => $request->active,
                    'position' => $media_single->position,
                    'type' => str_slug($request->type,'-'),
                    'category' => $media_single->category,
                    'option' => $option
                    ];
            }
        }
        else{
            $object = new MediaSingleModel();
            $media_single = $object->create([
                    'name' => $request->name,
                    'url' => $request->link,
                    'active' => $request->active,
                    'position' => $object->count() + 1,
                    'type' => str_slug($request->type,'-'),
                    'category_id' => $request->category_id == 'null' ? null : $request->category_id,
                    'option' => 'video'
                ]);
            $table[] = [
                    'id' => $media_single->id,
                    'name' => $request->name,
                    'url' => $request->link,
                    'active' => $request->active,
                    'position' => $media_single->position,
                    'type' => str_slug($request->type,'-'),
                    'category' => $media_single->category,
                    'option' => 'video'
                    ];
        }
        /*
        * CACHE
        */
        Cache::forever('media-single', MediaSingleModel::with('category')->orderBy('position','DESC')->where('active',1)->get());
        return response()->json(['status'=>'is','status_desc'=>'Added files!','media_single'=>$table]);
    	
    }
    /*
    * model: MediaSingleModel
    * view: admin/media-single/edit/{id}
    * method: PUT
    */
    public function update(Request $request, $id){
    	$media_single = MediaSingleModel::find($id);
        $media_single->name = $request->name;
        $media_single->active = $request->active;
        if($request->has('link'))
        {
            $media_single->url = $request->link;
        } 
        $media_single->position = $request->position;
        $media_single->type = str_slug($request->type,'-');
        $media_single->category_id = $request->category_id_2 == 'null' ? null : $request->category_id_2;
        $media_single->save();
        /* CACHE */
        Cache::forever('media-single', MediaSingleModel::with('category')->orderBy('position','DESC')->where('active',1)->get());
        return response()->json(['status'=>'is','status_desc'=>'Saved !','media_single'=>MediaSingleModel::with('category')->find($id)]);
    }
    /*
    * model: MediaSingleModel
    * view: admin/media-single/delete/{id}
    * method: GET
    */
    public function destroy($id){
    	$media = MediaSingleModel::find($id);
        if(str_is('/storage/*', $media->url))
        {
            $file = 'storage/'.explode('/storage/',$media->url)[1];
            if(File::exists($file))
            {
                if(File::delete($file))
                {
                    $media->delete();
                    /* CACHE */
                    Cache::forever('media-single', MediaSingleModel::with('category')->orderBy('position','DESC')->where('active',1)->get());
                    return response()->json(['status'=>'is','status_desc'=>'Removed file!']);
                }
            }
            else{
                return response()->json(['status'=>'not','status_desc'=>'Not removed file!']);
            }
        }
        else
        {
            $media->delete();
            /* CACHE */
            Cache::forever('media-single', MediaSingleModel::with('category')->orderBy('position','DESC')->where('active',1)->get());
            return response()->json(['status'=>'is','status_desc'=>'Removed file!']);
        }
        
    }


}
