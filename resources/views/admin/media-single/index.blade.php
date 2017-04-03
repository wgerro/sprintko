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
				  <li class="breadcrumb-item active"><span class="label label-success">Media single</span></li>
			</ol>
            <div>
                <a class="btn btn-primary" data-toggle="modal" href='#create'><i class="fa fa-plus"></i> Add files</a>
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
                            <th>File</th>
                            <th>Type</th>
                            <th>Active</th>
                            <th>Category</th>
                            <th>Position</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr id="ukryj">
                        <td colspan="7" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
                    </tr>
                        <input type="hidden" name="url" value="{{ url('/') }}" v-model="url">
                        <input type="hidden" name="url_pages" value="{{ route('media-single') }}" v-model="url_media_singles">
                        <tr class="tabela" v-for="media_single in media_singles" track-by="$index">
                            <td>@{{ $index + 1 }}</td>
                            <td>@{{ media_single.name }}</td>
                            <td>
                                <span v-if="media_single.option == 'image'">
                                  <img v-bind:src="media_single.url" style="height:100px;">
                                </span>
                                <span v-if="media_single.option == 'audio'">
                                  <audio v-bind:src="media_single.url" preload="none" controls "></audio>
                                </span>
                                <span v-if="media_single.option == 'video'">
                                  <span v-if="media_single.url.indexOf('youtube') > 0">
                                      <iframe width="200" height="115" :src="media_single.url" frameborder="0" allowfullscreen></iframe>
                                  </span>
                                  <span v-else>
                                    <video v-bind:src="media_single.url" ></video>
                                  </span>
                                </span>
                                <span v-if="media_single.option == 'document'">
                                  plik
                                </span>
                            </td>
                            <td>@{{ media_single.type }}</td>
                            <td>
                                <span class="label label-success" v-if="media_single.active == 1"> <i class="fa fa-check" aria-hidden="true"></i> </span>
                                <span class="label label-danger" v-if="media_single.active == 0" > <i class="fa fa-times" aria-hidden="true"></i></span>
                            </td>
                            <td>
                              <span v-if="media_single.category == null"> <span class="label label-danger"> none </span> </span>
                              <span v-if="media_single.category != null"> <span class="label label-primary"> @{{ media_single.category.name }} </span> </span>
                            </td>
                            <td>
                                @{{ media_single.position }}
                            </td>
                            <td>
                                <a @click="show(media_single, $index)" class="btn btn-success" data-toggle="modal" href='#edit'><i class="fa fa-pencil"></i></a>
                                <a  @click="show(media_single, $index)" class="btn btn-danger" data-toggle="modal" href='#delete'><i class="fa fa-minus"></i></a>
                            </td>
                        </tr>                                                
                    </tbody>                             
                </table>
            </div>
            <!-- paginate -->
            <div class="col-xs-12 text-center" v-if="media_singles.length > 0">
                <button type="button" class="btn btn-warning @{{ !check_prev_page ? 'disabled':'' }}" @click="getMediaSingle(prev_page_url)"><</button>

                <button type="button" class="btn btn-warning @{{ !check_next_page ? 'disabled':'' }}" @click="getMediaSingle(next_page_url)">></button>
            </div>  
            
            <!-- ADD -->
            
            <div class="modal fade" id="create">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add media_singles</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="form-create" action="{{ route('media-single-create') }}" class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="add">
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
                                    <label class="col-md-2 control-label" for="filebutton">File</label>
                                    <div class="col-md-10">
                                      <input id="filebutton" name="files[]" multiple class="input-file" type="file" >
                                    </div>
                                  </div>

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

                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Type</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="type" type="text" placeholder="type" class="form-control input-md">
                                  </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group ">
                                  <label class="col-md-2 control-label" for="selectbasic">Category</label>
                                  <div class="col-md-10">
                                    <select id="selectbasic" name="category_id" class="form-control">
                                            <option value="null"> none </option>
                                        @foreach($category as $cat)
                                            <option value="{{$cat->id}}" >{{ $cat->name }}</option>
                                        @endforeach
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
                            <h4 class="modal-title">Edit: @{{ media_single.name }}</h4>
                        </div>
                        <div class="modal-body" >
                             <form method="POST" id="form-edit" action="{{ url('admin/media-single/edit') }}@{{'/'+media_single.id}}" class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="edit">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <!-- Text input-->
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Name</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="name" type="text" placeholder="name" class="form-control input-md" value="@{{ media_single.name }}">
                                  </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="selectbasic">Active</label>
                                  <div class="col-md-10">
                                    <select id="selectbasic" name="active" class="form-control" >
                                      <option :value="0" v-bind:selected="media_single.active == false">NO</option>
                                      <option :value="1" v-bind:selected="media_single.active == true">YES</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Position</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="position" type="text" placeholder="name" class="form-control input-md" value="@{{ media_single.position }}">
                                  </div>
                                </div>

                                <span v-if="media_single.url.indexOf('youtube') > 0">
                                  <div class="form-group">
                                    <label class="col-md-2 control-label" for="textinput">Youtube link</label>  
                                    <div class="col-md-10">
                                    <input  id="textinput" name="link" type="text" placeholder="http://" class="form-control input-md" :value="@{{ media_single.url }}">
                                    </div>
                                  </div>
                                </span>

                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Type</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="type" type="text" placeholder="type" class="form-control input-md" value="@{{ media_single.type }}">
                                  </div>
                                </div>

                                <span v-if="media_single.category != null">
                                  <!-- Select Basic -->
                                  <div class="form-group " >
                                    <label class="col-md-2 control-label" for="selectbasic">Category</label>
                                    <div class="col-md-10">
                                      <select id="selectbasic" name="category_id_2" class="form-control" v-model="edit_category">
                                        
                                              <option value="null" >none</option>
                                          @foreach($category as $cat)
                                              <option v-bind:value="{{$cat->id}}" v-bind:selected="media_single.category.id == {{$cat->id}}">{{ $cat->name }}</option>
                                          @endforeach
                                        
                                        
                                      </select>
                                    </div>
                                  </div>
                                </span>

                                <span v-if="media_single.category == null">
                                  <!-- Select Basic -->
                                  <div class="form-group " >
                                    <label class="col-md-2 control-label" for="selectbasic">Category</label>
                                    <div class="col-md-10">
                                      <select id="selectbasic" name="category_id_2" class="form-control" v-model="edit_category">
                                            <option value="null" selected>none</option>
                                        @foreach($category as $cat)
                                            <option v-bind:value="{{$cat->id}}" >{{ $cat->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                </span>
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
                            <h4 class="modal-title">Delete: @{{ media_single.name }} @{{ media_single.id }}</h4>
                        </div>
                        <div class="modal-body text-center">
                            <button type="button" class="btn btn-primary" @click="onDelete(media_single)"><i class="fa fa-floppy-o"></i> YES</button>
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
<script src="{{asset('js/vue/media-single.js')}}"></script>
@endsection