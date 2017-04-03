<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\FilesModel;
use App\Models\MediaAlbumsModel;
use File;
use Cache;

class FilesController extends Controller
{
    /*
    * model: FilesModel
    * view: admin/galleries
    * method: GET
    */
    public function index($id, $option){
    	return view('admin.files.index')
    		->with('id',$id)
            ->with('option',$option);
    }
    /*
    * model: FilesModel
    * view: admin/galleries/files/json/{id}
    * method: GET
    */
    public function json($id, $option){
        return FilesModel::with('albums')->where('option',$option)->where('album_id',$id)->get();
    }
    /*
    * model: FilesModel
    * view: admin/galleries/files/create/{id}
    * method: POST
    */
    public function create(Request $request, $id, $option){
        $time = time();
        $table = array();

        if($request->link == '')
        {
            foreach($request->file('files') as $key=>$file)
            {
                File::isDirectory('storage/files') ? ' ' : File::makeDirectory('storage/files');
                $ext = $file->getClientOriginalExtension();
                $name = $time.'-'.$key.'.'.$ext;
                $file->move(public_path().'/storage/files/',$name);
                $object = new FilesModel();
                $getId = $object->create([
                    'album_id' => $id,
                    'name' => '#'.$key.' '.$request->name,
                    'url' => '/storage/files/'.$name,
                    'active' => $request->active,
                    'option' => $option,
                    'position' => $object->where('album_id', $id)->where('option',$option)->max('position')+1,
                ]);
                $table[] = [
                    'id'=> $getId->id,
                    'album_id' => $id,
                    'name' => '#'.$key.' '.$request->name,
                    'url' => '/storage/files/'.$name,
                    'active' => $request->active,
                    'option' => $option,
                    'position' => $getId->position,
                    ];
            }
        }
        else
        {
            $object = new FilesModel();
            $getId = $object->create([
                    'album_id' => $id,
                    'name' => $request->name,
                    'url' => $request->link,
                    'active' => $request->active,
                    'option' => $option,
                    'position' => $object->where('album_id', $id)->where('option',$option)->max('position')+1,
                ]);
            $table[] = [
                    'id'=> $getId->id,
                    'album_id' => $id,
                    'name' => $request->name,
                    'url' => $request->link,
                    'active' => $request->active,
                    'option' => $option,
                    'position' => $getId->position,
                    ];
        }
        /*
        * CACHE
        */
        Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])->orderBy('position','DESC')->where('active',1)->get());
        return response()->json(['status'=>'is','status_desc'=>'Added images!','file' => $table]);
    }
    /*
    * model: FilesModel
    * view: admin/galleries/files/edit/{id}
    * method: PUT
    */
    public function update(Request $request, $id){
        $file = FilesModel::find($id);
        $file->name = $request->name;
        $file->active = $request->active;
        $file->position = $request->position;
        $file->save();
        /*
        * CACHE
        */
        Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])->orderBy('position','DESC')->where('active',1)->get());
        return response()->json(['status'=>'is','status_desc'=>'Updated!','file' => $file]);
    }
    /*
    * model: FilesModel
    * view: admin/galleries/files/delete/{id}
    * method: GET
    */
    public function destroy($id){
        $file = FilesModel::find($id);
        
        if(str_contains($file->url, 'youtube'))
        {
            $file->delete();
            Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])->orderBy('position','DESC')->where('active',1)->get());
                    return response()->json(['status'=>'is','status_desc'=>'Removed file!']);
        }
        else
        {
            $exist = 'storage/'.explode('/storage/',$file->url)[1];
            if(File::exists($exist))
            {
                if(File::delete($exist))
                {
                    $file->delete();
                    /*
                    * CACHE
                    */
                    Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])->orderBy('position','DESC')->where('active',1)->get());
                    return response()->json(['status'=>'is','status_desc'=>'Removed file!']);
                }
            }
            else{
                return response()->json(['status'=>'not','status_desc'=>'Not removed file!']);
            }
        }
    }
}
