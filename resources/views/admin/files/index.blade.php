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
	
<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" id="app">
    <div class="panel panel-default panel-ko">
        <div class="panel-heading panel-ko-heading">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
				  <li class="breadcrumb-item active"><span class="label label-success">Media with albums</span></li>
			</ol>
            <div>
            <a href="{{ route('media-albums') }}" class="btn btn-primary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> RETURN</a>
                <a class="btn btn-warning" data-toggle="modal" href='#create'><i class="fa fa-plus"></i> Add @if($option == 'images') image @elseif($option == 'musics') audio @elseif($option == 'videos') video @endif</a>
            </div>
        </div>
        <div class="panel-body">
            <div  class="alert alert-success text-center erorrs" v-if="status == 'is'" style="background: #1B9C01; color:white;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success!</strong> @{{ status_desc }}
            </div>
            <div  class="alert alert-danger text-center erorrs" v-if="status == 'not'" style="background: #CB0000; color:white; ">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Warning!</strong> @{{ status_desc }}
            </div>

            <!-- COMPONENT PAGES -->
            <div class="table-responsive">
            
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>file</th>
                            <th>Active</th>
                            <th>Position</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr id="ukryj">
                        <td colspan="7" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
                    </tr>
                    <input type="hidden" name="gallery_id" value="{{ $id }}" v-model="gallery_id">
                    <input type="hidden" name="option" value="{{ $option }}" v-model="option">
                        <input type="hidden" name="url" value="{{ url('/') }}" v-model="url">
                        <input type="hidden" name="url_pages" value="{{ route('files',['id'=>$id, 'option'=>$option ]) }}" v-model="url_files">
                        <tr class="tabela" v-for="file in files" track-by="$index">
                            <td>@{{ $index + 1}}</td>
                            <td>@{{ file.name }}</td>
                            <td>
                                @if($option == 'images')
                                    <img v-bind:src="url + '/' + file.url" style="height:100px;">
                                @elseif($option == 'musics')
                                    <audio id="nr@{{file.id}}" preload="none" controls :src="url + '/' + file.url"></audio>
                                @elseif($option == 'videos')
                                <span v-if="file.url.indexOf('youtube') > 0">
                                    <iframe width="200" height="115" :src="file.url" frameborder="0" allowfullscreen></iframe>
                                </span>
                                <span v-else>
                                    <video preload="none" controls :src="url + '/' + file.url"></video>
                                </span>
                                @elseif($option == 'documents')
                                    <a href="{{ url('/') }}@{{file.url}}"><i class="fa fa-file-text fa-4x"></i></a>
                                @endif
                            </td>
                            <td>
                                <span class="label label-success" v-if="file.active == 1"> <i class="fa fa-check" aria-hidden="true"></i> </span>
                                <span class="label label-danger" v-if="file.active == 0" > <i class="fa fa-times" aria-hidden="true"></i></span>
                            </td>
                            <td>
                                @{{ file.position }}
                            </td>
                            <td>
                                <a @click="show(file, $index)" class="btn btn-success" data-toggle="modal" href='#edit'><i class="fa fa-pencil"></i></a>
                                <a  @click="show(file, $index)" class="btn btn-danger" data-toggle="modal" href='#delete'><i class="fa fa-minus"></i></a>
                            </td>
                        </tr>                                                
                    </tbody>                             
                </table>
            </div>  
            
            <!-- ADD -->
            
            <div class="modal fade" id="create">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add @if($option == 'images') image @elseif($option == 'musics') audio @elseif($option == 'videos') video @endif</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="form-create" action="{{ route('files-create',['id'=>$id, 'option'=>$option]) }}" class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="add">
                            {{ csrf_field() }}
                            <!-- Text input-->
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Name</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="name" type="text" placeholder="name" class="form-control input-md">
                                  </div>
                                </div>

                                <!-- File Button --> 
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="filebutton">file</label>
                                  <div class="col-md-10">
                                    <input id="filebutton" name="files[]" multiple class="input-file" type="file" >
                                  </div>
                                </div>
                                @if($option == 'videos')
                                <div class="form-group">
                                    <label class="col-md-4 control-label">
                                    OR</label>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Youtube link</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="link" type="text" placeholder="http://" class="form-control input-md">
                                  </div>
                                </div>
                                @else
                                    <input type="hidden" name="link" value="">
                                @endif
                                <!-- Select Basic -->
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="selectbasic">Active</label>
                                  <div class="col-md-10">
                                    <select id="selectbasic" name="active" class="form-control">
                                      <option value="0" {{ (old('active')==0)?'selected':'' }}>NO</option>
                                      <option value="1" {{ (old('active')==1)?'selected':'' }}>YES</option>
                                    </select>
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

                            <!-- progress -->
                            <div class="progress text-center" style="margin-top:20px;">
                              <div class="progress-bar" role="progressbar" aria-valuenow="0"
                              aria-valuemin="0" aria-valuemax="100">
                              
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- EDIT -->
            <div class="modal fade" id="edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edit: @{{ file.id }}</h4>
                        </div>
                        <div class="modal-body" >
                             <form method="POST" id="form-edit" action="{{url('/admin/media-albums/files/edit/')}}@{{'/'+file.id}}" class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="edit">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <!-- Text input-->
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Name</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="name" type="text" placeholder="name" class="form-control input-md" value="@{{ file.name }}">
                                  </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="selectbasic">Active</label>
                                  <div class="col-md-10">
                                    <select id="selectbasic" name="active" class="form-control" >
                                      <option :value="0" v-bind:selected="file.active == false">NO</option>
                                      <option :value="1" v-bind:selected="file.active == true">YES</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Position</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="position" type="text" placeholder="name" class="form-control input-md" value="@{{ file.position }}">
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
                            <h4 class="modal-title">Delete: @{{ file.name }}</h4>
                        </div>
                        <div class="modal-body text-center">
                            <button type="button" class="btn btn-primary" @click="onDelete(file)"><i class="fa fa-floppy-o"></i> YES</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                        </div>
                    </div>
                </div>
            </div>






        </div>


    </div>
</div>
@endsection

@section('js_body')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/files.js')}}"></script>
@endsection