@extends('admin.index')

@section('css')
<style>
.alert{
    display: none;
}
.tabela{
    display: none;
}
.do_ukrycia{
    display: block;
}
.pokaz_tabele{
    display: table-row;
}
</style>
@endsection

@section('content')
<div id="app">
<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
				  <li class="breadcrumb-item active"><span class="label label-success">General</span></li>
			</ol>
            
        	<div  class="alert alert-success text-center erorrs" v-if="status == 'is'" style="background: #1B9C01; color:white;">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success!</strong> @{{ status_desc }}
        	</div>
        	<div  class="alert alert-danger text-center erorrs" v-if="status == 'not'" style="background: #CB0000; color:white; ">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Warning!</strong> @{{ status_desc }}
        	</div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-6 col-sm-12 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
        <div class="panel-body">
        	<form method="POST" id="form-edit" action="{{ route('general-update') }}" class="form-horizontal" v-on:submit.prevent="edit('')" enctype="multipart/form-data">
       			{{ csrf_field() }}
       			{{ method_field('PUT') }}
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Count articles </label>  
				  <div class="col-md-7">
				  <input id="textinput" name="articles_count" type="text"  class="form-control input-md" value="@{{ general.articles_count }}">
				  </div>
				</div>
				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Api</label>
				  <div class="col-md-7">
				    <select id="selectbasic" name="api" class="form-control" >
				      <option v-for="api in apis" :value="api.name" v-bind:selected="(api.name == general.api) ? true : false">@{{ api.name }}</option>
				    </select>
				  </div>
				</div>

				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Comments</label>
				  <div class="col-md-7">
				    <select id="selectbasic" name="is_comments" class="form-control" >
				      <option :value="0" selected="@{{ general.is_comments == 0? true : false }}">NO</option>
				      <option :value="1" selected="@{{ general.is_comments == 1? true : false }}">YES</option>
				    </select>
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Google verification</label>  
				  <div class="col-md-7">
				  <input id="textinput" name="google_verification" type="text" class="form-control input-md" value="@{{ general.google_verification }}">
				  </div>
				</div>

				<!-- File Button --> 
				<div class="form-group">
				  <label class="col-md-4 control-label" for="filebutton">Logo page</label>
				  <div class="col-md-7">
				    <input id="filebutton" name="image" class="input-file" type="file">
				  </div>
				</div>

				<div class="form-group">
					<div class="col-md-7 col-md-offset-4">
						<input type="hidden" value="{{url('/')}}" v-model="url_general">
						<img v-bind:src="url_general + '/' + general.logo" alt="" style="height: 100px; ">
					</div>
				</div>

				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Gallery widgets</label>
				  <div class="col-md-7">
				    <select id="selectbasic" name="gallery_widgets" class="form-control" >
				      <option :value="0" selected="@{{ general.gallery_widgets == 0? true : false }}">NO</option>
				      <option :value="1" selected="@{{ general.gallery_widgets == 1? true : false }}">YES</option>
				    </select>
				  </div>
				</div>

				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Article widgets</label>
				  <div class="col-md-7">
				    <select id="selectbasic" name="article_widgets" class="form-control" >
				      <option :value="0" selected="@{{ general.article_widgets == 0? true : false }}">NO</option>
				      <option :value="1" selected="@{{ general.article_widgets == 1? true : false }}">YES</option>
				    </select>
				  </div>
				</div>

				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Category widgets</label>
				  <div class="col-md-7">
				    <select id="selectbasic" name="category_widgets" class="form-control" >
				      <option :value="0" selected="@{{ general.category_widgets == 0? true : false }}">NO</option>
				      <option :value="1" selected="@{{ general.category_widgets == 1? true : false }}">YES</option>
				    </select>
				  </div>
				</div>

				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Search widgets</label>
				  <div class="col-md-7">
				    <select id="selectbasic" name="search_widgets" class="form-control" >
				      <option :value="0" selected="@{{ general.search_widgets == 0? true : false }}">NO</option>
				      <option :value="1" selected="@{{ general.search_widgets == 1? true : false }}">YES</option>
				    </select>
				  </div>
				</div>

				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="selectbasic">Error widgets</label>
				  <div class="col-md-7">
				    <select id="selectbasic" name="error_widgets" class="form-control" >
				      <option :value="0" selected="@{{ general.error_widgets == 0? true : false }}">NO</option>
				      <option :value="1" selected="@{{ general.error_widgets == 1? true : false }}">YES</option>
				    </select>
				  </div>
				</div>

				<!-- Textarea -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textarea">File robots.txt</label>
				  <div class="col-md-7">                     
				    <textarea class="form-control" id="textarea" name="content_robots" style="height: 200px;"> {{ $robots }}</textarea>
				  </div>
				</div>

				<!-- Button -->
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
					</div>
				</div>
			</form>
        	
        	
       	</div>
    </div>
   
</div>

<div class="col-xs-12 col-md-6 col-sm-12 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
	    <form method="POST" id="form-edit-api" action="{{ route('general-api') }}" class="form-horizontal" v-on:submit.prevent="edit('-api')" enctype="multipart/form-data">
	       			{{ csrf_field() }}
	       			{{ method_field('PUT') }}
	        <div class="panel-body">
		        	<div class="col-xs-12 text-center" style="padding-bottom: 20px;">
		        		<p style="font-size:23px;">FACEBOOK API</p>
		        	</div>
					
					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="textinput">API KEY </label>  
					  <div class="col-md-7">
					  <input id="textinput" name="api_facebook_app" type="text"  class="form-control input-md" value=" {{ $api_facebook_app }}">
					  </div>
					</div>

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="textinput">API SECRET </label>  
					  <div class="col-md-7">
					  <input id="textinput" name="api_facebook_secret" type="text"  class="form-control input-md" value="{{ $api_facebook_secret }}">
					  </div>
					</div>

					
	        </div>
	        <!-- Button -->
			<div class="form-group">
				<div class="col-md-12 text-center">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
				</div>
			</div>
		</form>
    </div>
</div>


</div>
@endsection

@section('js_body')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/general.js')}}"></script>
@endsection