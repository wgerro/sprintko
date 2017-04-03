@extends('admin.index')

@section('css')
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
@endsection

@section('content')
<div id="app">
	<form class="form-horizontal" action="{{ route('pages-update',['id'=>$page->id]) }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
		<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
		    <div class="panel panel-default panel-ko">
		        <div class="panel-heading panel-ko-heading">
					<ol class="breadcrumb" style="margin-bottom: 0px !important;">
						  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
						  <li class="breadcrumb-item"><a href="{{ route('pages') }}"><span class="label label-default">Pages</span></a></li>
						  <li class="breadcrumb-item"><span class="label label-default">Edit</span></li>
						  <li class="breadcrumb-item active"><span class="label label-success">{{ $page->name }}</span></li>
					</ol>
					<!-- Button -->
						<div class="form-group" style="margin-top:15px;">
						  <div class="col-md-12 ">
						  	<a href="{{ route('pages') }}" class="btn btn-primary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> RETURN</a>
						    <button id="singlebutton" name="singlebutton" class="btn btn-success"><i class="fa fa-floppy-o"></i> SAVE</button>
						  </div>
						</div>
		        </div>
			</div>
		</div>
		<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-12 col-md-6 col-sm-6 panel-ko-fluid" >
			    <div class="panel panel-default panel-ko">
			        <div class="panel-heading panel-ko-heading">
						Meta tags
			        </div>
			        <div class="panel-body">
			        		
			        		<input type="hidden" name="id" value="{{ $page->id }}"> 
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textinput">Name</label>  
							  <div class="col-md-10">
							  <input id="textinput" name="name" type="text" placeholder="name menu" class="form-control input-md" value="{{ $page->name }}" required>
							  @if ($errors->has('name'))
	                            <span class="label label-danger" >
	                                 <strong>{{ $errors->first('name') }}</strong>
	                            </span>
	                          @endif
							  </div>
							</div>

							@if($page->id != 1)
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textinput">Slug</label>  
							  <div class="col-md-10">
							  <input id="textinput" name="slug" type="text" placeholder="slug" class="form-control input-md" value="{{ $page->slug }}" required>
							  @if ($errors->has('slug'))
	                            <span class="label label-danger" >
	                                 <strong>{{ $errors->first('slug') }}</strong>
	                            </span>
	                          @endif
							  </div>
							</div>
							@endif

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textinput">Title</label>  
							  <div class="col-md-10">
							  <input id="textinput" name="title" type="text" placeholder="title" class="form-control input-md" value="{{ $page->title }}">
							  </div>
							</div>

							<!-- Textarea -->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textarea">Description</label>
							  <div class="col-md-10">                     
							    <textarea class="form-control" id="textarea" name="description">{{ $page->description }}</textarea>
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textinput">Keywords</label>  
							  <div class="col-md-10">
							  <input id="textinput" name="keyword" type="text" placeholder="e.g. car, house, cats " class="form-control input-md" value="{{ $page->keyword }}">
							  </div>
							</div>

							<!-- Select Basic -->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="selectbasic">Robots</label>
							  <div class="col-md-10">
							    <select id="selectbasic" name="robots" class="form-control">
							      <option value="0" {{ ($page->robots==0)?'selected':'' }}>NO</option>
							      <option value="1" {{ ($page->robots==1)?'selected':'' }}>YES</option>
							    </select>
							  </div>
							</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-sm-6 panel-ko-fluid" >
			    <div class="panel panel-default panel-ko">
			        <div class="panel-heading panel-ko-heading">
						Setting
			        </div>
			        <div class="panel-body">
			        		@if($page->id != 1)
			        			<!-- Select Basic -->
								<div class="form-group">
								  <label class="col-md-2 control-label" for="selectbasic">Assign page to:</label>
								  <div class="col-md-10">
								    <select id="selectbasic" name="page_sub_id" class="form-control">
								    		@if($page->sub)
								    		<option value="lack">none</option>
								    		@else 
								    		<option value="lack" selected>none</option>
								    		@endif
								    	@foreach($pages->where('id','!=',$page->id) as $page1)
								    		@if($page->sub)
								      		<option value="{{ $page1->id }}" {{ ($page1->id == $page->sub->page_sub_id) ? 'selected' : '' }}>{{ $page1->name }}</option>
								      		@else
								      		<option value="{{ $page1->id }}" >{{ $page1->name }}</option>
								      		@endif
								      	@endforeach
								    </select>
								  </div>
								</div>

								<!-- Select Basic -->
								<div class="form-group ">
								  <label class="col-md-2 control-label" for="selectbasic">Active</label>
								  <div class="col-md-10">
								    <select id="selectbasic" name="active" class="form-control">
								      <option value="0" {{ ($page->active==0)?'selected':'' }}>NO</option>
								      <option value="1" {{ ($page->active==1)?'selected':'' }}>YES</option>
								    </select>
								  </div>
								</div>
								<!-- Select Basic -->
								<div class="form-group ">
								  <label class="col-md-2 control-label" for="selectbasic">Category </label>
								  <div class="col-md-10">
								    <select id="selectbasic" name="category_id" class="form-control">
								    		<option value="0" {{ ($page->category_id==null)?'selected':'' }}>none</option>
								    	@foreach($category as $cat)
								      		<option value="{{$cat->id}}" {{ ($page->category_id==$cat->id)?'selected':'' }}>{{ $cat->name }}</option>
								      	@endforeach
								    </select>
								  </div>
								</div>
							@endif
							<div class="form-group">
	                            <label class="col-md-2 control-label" for="prependedcheckbox">Module</label>
	                                <div class="col-md-10">
	                                    @foreach($modules as $key=>$mod)
	                                    <input type="checkbox" id="cat-{{ $key }}" value="{{$key}}" name="module_id[]"
	                                    @if(count($page->module->where('module',$key)) > 0) checked @endif>
	                                    <label for="cat-{{$key}}">{{ $mod }}</label>
	                                    <br>
	                                    @endforeach
	                                </div>
	                        </div>
							<!-- Select Basic -->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="selectbasic">Widgets</label>
							  <div class="col-md-10">
							    <select id="selectbasic" name="is_widgets" class="form-control">
							      <option value="0" {{ ($page->is_widgets)?'selected':'' }}>NO</option>
							      <option value="1" {{ ($page->is_widgets)?'selected':'' }}>YES</option>
							    </select>
							  </div>
							</div>
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
<script src="{{asset('js/vue/pages-create.js')}}"></script>
@endsection