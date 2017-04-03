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
				  <li class="breadcrumb-item active"><span class="label label-success">Templates</span></li>
			</ol>
            <div>
                <button type="button" class="btn btn-primary" data-target="#create" data-toggle="modal"><i class="fa fa-plus" ></i> Add template</button>
            </div>
        </div>
      </div>
    </div>

  <div class="col-xs-12 col-md-4 col-sm-4 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
        <div class="panel-body">
        <input type="hidden" v-model="id_template" value="{{$id}}">
        Template is actual : <span class="label label-primary" style="font-size:15px;" v-for="template in templates" v-if="template.id == id_template">@{{ template.name }}</span>
        <button type="button" class="btn btn-success btn-xs" data-target="#edit" data-toggle="modal"><i class="fa fa-pencil" ></i></button>
        </div>
      </div>
    </div>

  <div class="col-xs-12 col-md-8 col-sm-8 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
        Templates
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

        	<div class="table-responsive">
		        <table class="table table-hover" >
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th>Name</th>
		                    <th>Folder</th>
		                    <th></th>
		                </tr>
		            </thead>
		            <tbody >
                <tr id="ukryj">
                        <td colspan="4" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
                    </tr>
		            <input type="hidden" name="url" value="{{ url('/') }}" v-model="url">
		            <input type="hidden" name="url_template" value="{{ route('templates') }}">
		                <tr class="tabela"  v-for="template in templates" track-by="$index" >
		                    <td>@{{ $index + 1}}</td>
		                    <td>@{{ template.name }}</td>
		                    <td>@{{ template.folder }}</td>
		                    <td>
		                        <button v-if="template.id != 1" @click="show(template,$index)" type="button" class="btn btn-danger" data-target="#delete" data-toggle="modal"><i class="fa fa-minus" ></i></button>
		                    </td>
		                </tr>                                                      
		            </tbody>                             
		        </table>
		    </div>
       	</div>

       	<div class="modal fade" id="create">
       		<div class="modal-dialog">
       			<div class="modal-content">
       				<div class="modal-header">
       					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       					<h4 class="modal-title">Add template</h4>
       				</div>
       				<div class="modal-body">
       					<form method="POST" id="form-create" action="{{ route('templates-create') }}" class="form-horizontal" v-on:submit.prevent="add">
       					{{ csrf_field() }}
							<!-- File Button --> 
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="filebutton">File (only *.zip)</label>
                                <div class="col-md-9">
                                    <input id="filebutton" name="file" class="input-file" type="file" required>
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
       	<div class="modal fade" id="edit">
       		<div class="modal-dialog">
       			<div class="modal-content">
       				<div class="modal-header">
       					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       					<h4 class="modal-title">Change template</h4>
       				</div>
       				<div class="modal-body">
       				
       					<form id="form-edit" class="form-horizontal" method="POST" action="{{ route('templates-edit') }}" v-on:submit.prevent="edit">
       					{{ csrf_field() }}
       					{{ method_field('PUT') }}
							<!-- Select Basic -->
							<div class="form-group ">
							  <label class="col-md-2 control-label" for="selectbasic">Template</label>
							  <div class="col-md-10">
							    <select id="selectbasic" name="id" class="form-control" >
							      <option v-for="template in templates" v-bind:value="template.id" selected="@{{(template.id == id_template)? true : false }}">@{{ template.name }}</option>
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
       	<div class="modal fade" id="delete">
       		<div class="modal-dialog">
       			<div class="modal-content">
       				<div class="modal-header">
       					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       					<h4 class="modal-title">Delete template - @{{ template.name }}</h4>
       				</div>
       				<div class="modal-body">
       					<button type="button" class="btn btn-success" @click="onDelete(template.id,template)">YES</button>
       					<button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
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
<script src="{{asset('js/vue/template.js')}}"></script>
@endsection