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
    display: block;
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
					  <li class="breadcrumb-item active"><span class="label label-success">Media</span></li>
				</ol>
	            
	        	<div  class="alert alert-success text-center erorrs" v-if="status == 'is'" style="background: #1B9C01; color:white;">
	        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        		<strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success!</strong> @{{ status_desc }}
	        	</div>
	        	<div  class="alert alert-danger text-center erorrs" v-if="status == 'not'" style="background: #CB0000; color:white; ">
	        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        		<strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Warning!</strong> @{{ status_desc }}
	        	</div>
	        	<button type="button" class="btn btn-primary" data-target="#create" data-toggle="modal"><i class="fa fa-plus" ></i> Add media</button>
				<br>
	        	
	        
	        </div>
	    </div>
	</div>
	<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	MEDIA
	        </div>
	        <input type="hidden" v-model="url" value="{{url('/')}}">
	        <div class="panel-body tabela" style="overflow-y: scroll; max-height: 800px;">
	        	<div class="col-xs-12 col-md-3 text-center" v-for="m in medias | orderBy 'name'" track-by="$index" style="min-height: 150px;">
	        		<div class="image">
	        			
	        			<div v-if="m.type == 'image'">
	        				<img v-bind:src="url+'/storage/media/'+m.name" style="height:100px;margin-top:10px;">
	        			</div>
	        			<div v-if="m.type == 'music'">
	        				<img v-bind:src="url+'/storage/icons/music.png'" style="height:100px;margin-top:10px;">
	        			</div>
	        			<div v-if="m.type == 'video'">
	        				<img v-bind:src="url+'/storage/icons/video.png'" style="height:100px;margin-top:10px;">
	        			</div>
	        			<div v-if="m.type == 'doc'">
	        				<img v-bind:src="url+'/storage/icons/doc.png'" style="height:100px;margin-top:10px;">
	        			</div>
	        			<div v-if="m.type == 'zip'">
	        				<img v-bind:src="url+'/storage/icons/zip.png'" style="height:100px;margin-top:10px;">
	        			</div>
	        			<div v-if="m.type == 'lack'">
	        				<img v-bind:src="url+'/storage/icons/lack.png'" style="height:100px;margin-top:10px;">
	        			</div>
	        		</div>
	        		<div class="caption" style="margin-top:5px;">
	        			<span class="label label-primary" style="font-size:13px;">@{{ m.name }} </span><br>
	        			<button @click="show(m)" type="button" class="btn btn-danger btn-sm" data-target="#delete" data-toggle="modal" style="margin-top:10px;"><i class="fa fa-minus" ></i> </button>
	        			<a v-bind:href="url+'/admin/media/download/'+m.name" class="btn btn-warning btn-sm" style="margin-top:10px;" ><i class="fa fa-download" ></i> </a>
	        		</div>
	        	</div>
	        </div>
	    </div>
	</div>
	<!-- MODAL ADD MEDIA -->
		<div class="modal fade" id="create">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add media</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="form-create" action="{{ route('media-create') }}" class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="send">
                            {{ csrf_field() }}

                                <!-- File Button --> 
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="filebutton">File</label>
                                  <div class="col-md-10">
                                    <input id="filebutton" name="file" class="input-file" type="file">
                                  </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group">
                                  <div class="col-md-12 text-center">
                                    <button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                            </form>
                            <div class="progress text-center" style="margin-top:20px;">
							  <div class="progress-bar" role="progressbar" aria-valuenow="0"
							  aria-valuemin="0" aria-valuemax="100">
							  
							  </div>
							</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DELETE -->
            <div class="modal fade" id="delete">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Delete: @{{ media.name }}</h4>
                        </div>
                        <div class="modal-body text-center">
                            <button type="button" class="btn btn-primary" @click="onDelete(media)"><i class="fa fa-floppy-o"></i> YES</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                        </div>
                    </div>
                </div>
            </div>

</div>
@endsection

@section('js_body')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/media.js')}}"></script>
@endsection
