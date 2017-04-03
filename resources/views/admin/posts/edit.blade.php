@extends('admin.index')

@section('css')
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
@endsection

@section('content')
<div id="app">
    <form class="form-horizontal" method="POST" action="{{ route('posts-update',['id'=>$post->id]) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
            <div class="panel panel-default panel-ko" >
                <div class="panel-heading panel-ko-heading">
        			<ol class="breadcrumb">
        				  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
        				  <li class="breadcrumb-item "><a href="{{ route('posts') }}"><span class="label label-default">Posts</span></a></li>
                          <li class="breadcrumb-item active"><span class="label label-success">Edit</span></li>
        			</ol>
                    <div class="form-group" style="margin-top:15px;">
                        <div class="col-md-12 ">
                            <a href="{{ route('posts') }}" class="btn btn-primary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> RETURN</a>
                            <button id="singlebutton" name="singlebutton" class="btn btn-success"><i class="fa fa-floppy-o"></i> SAVE</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 col-sm-12 panel-ko-fluid" >
            <div class="panel panel-default panel-ko" >
                <div class="panel-body">
                    
                    <input type="hidden" name="id" value="{{$post->id}}">
                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Subject</label>  
                          <div class="col-md-8">
                          <input id="textinput" name="subject" type="text"  class="form-control input-md" value="{{ $post->subject }}" required>
                          @if ($errors->has('subject'))
                            <span class="label label-danger" >
                                 <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                          @endif
                          </div>

                        </div>
                       
                        <div class="form-group">
                                  <label class="col-md-4 control-label" for="prependedcheckbox">Category</label>
                                  <div class="col-md-8"  style="height:180px; overflow-y:scroll;">
                                    @foreach($category as $cat)
                                        <input type="checkbox" id="cat-{{ $cat->id }}" value="{{$cat->id}}" name="category_id[]" 
                                        {{ ($post->post_category->where('category_id',$cat->id)->count() == 1)? 'checked' : '' }}>
                                        <label for="cat-{{$cat->id}}">{{ $cat->name }}</label>
                                        <br>
                                    @endforeach
                                  </div>
                        </div>

                        <!-- Select Basic -->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="selectbasic">Active</label>
                          <div class="col-md-8">
                            <select id="selectbasic" name="active" class="form-control">
                              <option value="0" {{ ($post->active==0)?'selected':'' }}>NO</option>
                              <option value="1" {{ ($post->active==1)?'selected':'' }}>YES</option>
                            </select>
                          </div>
                        </div>

                        <!-- File Button --> 
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="filebutton">Image</label>
                          <div class="col-md-8">
                            <input id="filebutton" name="image" class="input-file" type="file">
                          </div>
                          @if ($errors->has('image'))
                            <span class="label label-danger" >
                                 <strong>{{ $errors->first('image') }}</strong>
                            </span>
                          @endif
                          <div class="col-xs-12 text-center" style="margin-top:20px;">
                            <img src="{{ asset('storage/posts/'.$post->image) }}" style="height: 200px; width: 100%;">  
                          </div>
                        </div>
                        

                   

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-8 col-sm-12 panel-ko-fluid" >
            <div class="panel panel-default panel-ko" >
                <div class="panel-body">
                    <!-- Textarea -->
                    <div class="form-group">
                        <div class="col-md-12">                     
                            <textarea class="form-control" id="description" name="description">{{ Storage::get('posts/'.$post->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js_body')
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/posts-create.js')}}"></script>
@endsection