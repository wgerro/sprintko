<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ContentRequest;
use App\Http\Controllers\Controller;
use File;
use App\Models\Contents;
use App\Models\PageContents;
use App\Models\PageModel;
use Storage;

class ContentController extends Controller
{
    public function index(){
        return view('admin.contents.index');
    }

    public function json(){
        return response()->json([
            'contents' => Contents::get(),
            'pages' => PageModel::with('contents')->get()
        ]);
    }

    public function create(ContentRequest $request){
        $contents = Contents::create([
            'name' => str_slug($request->name, '-')
        ]);
        return response()->json([
            'status' => 'is',
            'status_desc' => 'SAVED !',
            'contents' => $contents
        ]);
    }

    public function edit(ContentRequest $request, $id){
        $contents = Contents::find($id);
        $contents->update([
            'name' => $request->name
        ]);
        return response()->json([
            'status' => 'is',
            'status_desc' => 'SAVED !',
            'contents' => $contents
        ]);
    }

    public function destroy(Request $request, $id){
        $contents = Contents::with('page_contents')->find($id);
        
        foreach($contents->page_contents as $p_c)
        {
            if(Storage::disk('local')->exists('pages/'.$p_c))
            {
                Storage::delete('pages/'.$p_c);                
            }
        }
        $contents->delete();
        return response()->json([
            'status' => 'is',
            'status_desc' => 'Removed content ',
        ]);
    }

    public function edit_page_contents(Request $request){
        $p_c = new PageContents();

        if(count($request->contents) > 0) //jesli cos odznaczone
        {
            foreach($request->contents as $key=>$content)
            {
                if(!$p_c->where('page_id',(int)$request->page_id)->where('content_id', $content)->exists())
                {
                    Storage::disk('local')->put('pages/'.time().$key.'.txt', ' ');
                    $p_c->create([
                        'page_id' => $request->page_id,
                        'page_str' => '',
                        'content_id' => $content,
                        'file' => time().$key.'.txt'
                    ]);
                }
            }
            $deleting = $p_c->where('page_id',(int)$request->page_id)->whereNotIn('content_id', $request->contents);
        }
        else //jesli wszystko odznaczone
        {
            $deleting = $p_c->where('page_id',(int)$request->page_id);
        }
        //do usuwania 
        

        //trzeba usunac plik
        foreach($deleting->get() as $delete)
        {
            if(Storage::disk('local')->exists('pages/'.$delete->file))
            {
                Storage::delete('pages/'.$delete->file);                
            }
        }

        //potwierdzenie ze usunie rekord
        $deleting->delete();

        return response()->json([
            'status' => 'is',
            'status_desc' => 'SAVED !',
            'contents' => PageModel::with('contents')->find((int)$request->page_id), 
        ]);
    }

    public function view_page_contents($id){
        $page = PageModel::with(['contents'=>function($query){
            $query->with('content');
        }])->find($id);
        return view('admin.contents.view')
            ->with('page', $page);
    }

    public function save_file_page_contents(Request $request){
        foreach($request->content as $key=>$content)
        {
            Storage::disk('local')->put('pages/'.$key, trim($content));
        }
        return redirect()->back();
    } 

}
