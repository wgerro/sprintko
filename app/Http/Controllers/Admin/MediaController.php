<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use App\Models\TemplateModel;
class MediaController extends Controller
{
    /*
    * model: none
    * view: media
    * method: GET
    */
    public function index(){
    	return view('admin.media.index');
    }
    /*
    * model: none
    * view: media/json
    * method: GET
    */
    public function json(){
        $file = public_path().'/storage/media';
        $table = array();
        
        foreach(File::files($file) as $file1)
        {
            $str = strtolower(explode('.',$file1)[1]);
            $type = $this->checkExt($str);
            $table[] = [
                'name'=>explode('/media/',$file1)[1],
                'type'=>$type
            ];
        }
        return response()->json($table);
    }
    /*
    * model: none
    * view: media/create
    * method: POST
    */
    public function create(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $name = str_slug(explode('.',$file->getClientOriginalName())[0],'-');
        $original_new = $file->getClientOriginalName();
        $file->move(public_path().'/storage/media/', $original_new);

        return response()->json([
            'status' => 'is',
            'status_desc' => 'SAVED !',
            'name' => $original_new,
            'type' => $this->checkExt($ext)
        ]);
    }
    /*
    * model: none
    * view: media/download/{file}
    * method: GET
    */
    public function download($file)
    {
        return response()->download('storage/media/'.$file);
    }
    /*
    * sprawdzanie jaki to typ pliku czy to zdjecie czy to muzyka czy to film
    */
    public function checkExt($str)
    {
        $str = strtolower($str);
        $images = ['png','jpg','jpeg'];
        $musics = ['mp3','wav'];
        $videos = ['mp4','ogg','avi','mov'];
        $docs = ['pdf','docx','txt'];
        $zips = ['zip','rar'];

        if(in_array( $str ,$images))
        {
            $type = 'image';
        }
        elseif(in_array( $str ,$musics))
        {
            $type = 'music';
        }
        elseif(in_array( $str ,$videos))
        {
            $type = 'video';
        }
        elseif(in_array( $str ,$docs))
        {
            $type = 'doc';
        }
        elseif(in_array( $str ,$zips))
        {
            $type = 'zip';
        }
        else
        {
            $type = 'lack';
        }
        return $type;
    }
    /*
    * model: none
    * view: media/delete
    * method: GET
    */
    public function destroy($file)
    {
        $plik = 'storage/media/'.$file;

        if(File::exists($plik))
        {
            if(File::delete($plik))
            {
                return response()->json([
                    'status'=> 'is',
                    'status_desc' => 'REMOVED!'
                ]);
            }
        }
        else{
            return response()->json([
                'status'=> 'not',
                'status_desc' => 'lack file '.$file.' !'
            ]);
        }    
    }
}
