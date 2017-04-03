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
				  <li class="breadcrumb-item active"><span class="label label-success">Widgets</span></li>
			</ol>
            <div>
                <a class="btn btn-primary" data-toggle="modal" href='#create'><i class="fa fa-plus"></i> Add widget</a>
            </div>
        </div>
        <div class="panel-body">
            <div :class="alert" class="alert alert-success text-center erorrs" v-if="status == 'is'" style="background: #1B9C01; color:white; ">
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
                            <th>Active</th>
                            <th>Position</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr id="ukryj" >
                        <td colspan="6" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
                    </tr>
                        <input type="hidden" name="url" value="{{ url('/') }}" v-model="url">
                        <input type="hidden" name="url_widgets" value="{{ route('widgets') }}" v-model="url_widgets">
                        <tr class="tabela" v-for="widget in widgets" track-by="$index">
                            <td>@{{ $index + 1}}</td>
                            <td>@{{ widget.name }}</td>
                            <td>@{{ widget.file }}</td>
                            <td>
                                <span class="label label-success" v-if="widget.active"> <i class="fa fa-check" aria-hidden="true"></i> </span>
                                <span class="label label-danger" v-else > <i class="fa fa-times" aria-hidden="true"></i></span>
                            </td>
                            <td>@{{ widget.position }}</td>
                            <td>
                                <a  @click="show(widget, $index)" class="btn btn-success" data-toggle="modal" href='#edit'><i class="fa fa-pencil"></i></a>
                                <a v-if="widget.id > 4"  @click="show(widget, $index)" class="btn btn-danger" data-toggle="modal" href='#delete'><i class="fa fa-minus"></i></a>
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
                            <h4 class="modal-title">Add widget</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="form-create" action="{{ route('widgets-create') }}" class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="add">
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
                                  <label class="col-md-2 control-label" for="filebutton">File (only *.blade.php)</label>
                                  <div class="col-md-10">
                                    <input id="filebutton" name="file" class="input-file" type="file" required>
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


            <!-- EDIT -->
            <div class="modal fade" id="edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edit: @{{ widget.name }}</h4>
                        </div>
                        <div class="modal-body" >
                             <form method="POST" id="form-edit" action="{{ url('admin/widgets/edit') }}@{{'/'+widget.id}}" class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="edit">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <!-- Text input-->
                                <div class="form-group" v-if="widget.id > 4">
                                  <label class="col-md-2 control-label" for="textinput">Name</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="name" type="text" placeholder="name" class="form-control input-md" value="@{{ widget.name }}">
                                  </div>
                                </div>
                                <!-- Select Basic -->
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="selectbasic">Active</label>
                                  <div class="col-md-10">
                                    <select id="selectbasic" name="active" class="form-control" >
                                      <option value="0" v-bind:selected="widget.active == false">NO</option>
                                      <option value="1" v-bind:selected="widget.active == true">YES</option>
                                    </select>
                                  </div>
                                </div>
                                
                                <!-- File Button --> 
                                <div class="form-group" v-if="widget.id > 4">
                                  <label class="col-md-2 control-label" for="filebutton">File (only *.blade.php)</label>
                                  <div class="col-md-10">
                                    <input id="filebutton" name="file" class="input-file" type="file">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="textinput">Position</label>  
                                  <div class="col-md-10">
                                  <input  id="textinput" name="position" type="text" placeholder="name" class="form-control input-md" v-bind:value="widget.position" v-model="edit_position">
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
                            <h4 class="modal-title">Delete: @{{ widget.name }}</h4>
                        </div>
                        <div class="modal-body text-center">
                            <button type="button" class="btn btn-primary" @click="onDelete(widget)"><i class="fa fa-floppy-o"></i> YES</button>
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
<script src="{{asset('js/vue/widgets.js')}}"></script>
@endsection