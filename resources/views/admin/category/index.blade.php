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
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
				  <li class="breadcrumb-item active"><span class="label label-success">Category</span></li>
			</ol>
            <div>
                <button type="button" class="btn btn-primary" data-target="#create" data-toggle="modal"><i class="fa fa-plus" ></i> Add category</button>
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

        	<div class="table-responsive">
		        <table class="table table-hover" >
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th>Name</th>
		                    <th>Slug</th>
		                    <th>Description</th>
		                    <th></th>
		                </tr>
		            </thead>
		            <tbody >
		            <tr id="ukryj">
		            	<td colspan="5" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
		            </tr>
		            <input type="hidden" name="url" value="{{ url('/') }}" v-model="url">
		            <input type="hidden" name="url_category" value="{{ route('category') }}" v-model="url_category">
		            
		                <tr class="tabela" v-for="cat in category" track-by="$index" >
		                    <td>@{{ $index + 1}}</td>
		                    <td>@{{ cat.name }}</td>
		                    <td>@{{ url + '/category/' + cat.slug }}</td>
		                    <td>@{{ cat.description }}</td>
		                    <td>
		                    
		                        <button @click="show(cat.id,cat.name,cat.description,cat,$index)" type="button" class="btn btn-success" data-target="#edit" data-toggle="modal"><i class="fa fa-pencil"  ></i></button>
		                        <button @click="show(cat.id, cat.name, cat.description, cat,$index)" type="button" class="btn btn-danger" data-target="#delete" data-toggle="modal"><i class="fa fa-minus" ></i></button>
		                    </td>
		                </tr>                                                      
		            </tbody>                             
		        </table>
		        
		    </div>
		    <!-- paginate -->
		    <div class="col-xs-12 text-center" v-if="category.length > 0">
                <button type="button" class="btn btn-warning @{{ !check_prev_page ? 'disabled':'' }}" @click="getCategory(prev_page_url)"><</button>

                <button type="button" class="btn btn-warning @{{ !check_next_page ? 'disabled':'' }}" @click="getCategory(next_page_url)">></button>
            </div>
       	</div>

       	<div class="modal fade" id="create">
       		<div class="modal-dialog">
       			<div class="modal-content">
       				<div class="modal-header">
       					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       					<h4 class="modal-title">Add category</h4>
       				</div>
       				<div class="modal-body">
       					<form method="POST" id="form-create" action="{{ route('category-create') }}" class="form-horizontal" v-on:submit.prevent="add">
       					{{ csrf_field() }}
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textinput">Name</label>  
							  <div class="col-md-10">
							  <input v-model="create_name" id="textinput" name="name" type="text" placeholder="name" class="form-control input-md" required>
							  </div>
							</div>

							<!-- Textarea -->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textarea">Description</label>
							  <div class="col-md-10">                     
							    <textarea v-model="create_description" class="form-control" id="textarea" name="description"></textarea>
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
       					<h4 class="modal-title">Edit category - "  @{{ name }}  "</h4>
       				</div>
       				<div class="modal-body">
       				
       					<form id="form-edit" class="form-horizontal" method="POST" action="{{route('category')}}@{{'/edit/'+id_category}}" v-on:submit.prevent="edit">
       					{{ csrf_field() }}
       					{{ method_field('PUT') }}
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textinput">Name</label>  
							  <div class="col-md-10">
							  <input v-model="edit_name" id="textinput" name="name" type="text" placeholder="name" class="form-control input-md" v-bind:value="name">
							  </div>
							</div>

							<!-- Textarea -->
							<div class="form-group">
							  <label class="col-md-2 control-label" for="textarea">Description</label>
							  <div class="col-md-10">                     
							    <textarea v-model="edit_description" class="form-control" id="textarea" name="description">@{{ description }}</textarea>
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
       					<h4 class="modal-title">Delete category - @{{ name }}</h4>
       				</div>
       				<div class="modal-body text-center">
       					<button type="button" class="btn btn-success" @click="onDelete(id_category,cat)">YES</button>
       					<button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
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
<script src="{{asset('js/vue/category.js')}}"></script>
@endsection