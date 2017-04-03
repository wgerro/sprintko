<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CommentsModel;
use Cache;
class CommentController extends Controller
{
    /*
    * model: none
    * view: admin/comments
    * method: GET
    */
    public function index(){
    	return view('admin.comments.index');
    }
    /*
    * model: CommentsModel
    * view: admin/comments/json
    * method: GET
    */
    public function json(){
    	return CommentsModel::with(['post','user'])->paginate(10);
    }
    /*
    * model: CommentsModel
    * view: admin/comments/edit/{id}
    * method: PUT
    */
    public function update(Request $request, $id){
    	$comment = CommentsModel::with(['post','user'])->find($id);
        $comment->active = $request->active;
        $comment->save();
        Cache::forever('comments', CommentsModel::with('user')->where('active',1)->get());
        return response()->json(['status'=>'is','status_desc'=>'', 'comment'=> $comment]);
    }
    /*
    * model: CommentsModel
    * view: admin/comments/delete/{id}
    * method: GET
    */
    public function destroy($id){
    	$comment = CommentsModel::find($id);
        $comment->delete();
        Cache::forever('comments', CommentsModel::with('user')->where('active',1)->get());
        return response()->json(['status'=>'is','status_desc'=>'Removed comment !']);
    }
}
