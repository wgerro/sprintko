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
	<div class="col-xs-12 col-md-5 col-sm-12 panel-ko-fluid" >
	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	<div>
	                <button type="button" class="btn btn-primary" data-target="#add-content" data-toggle="modal"><i class="fa fa-plus" ></i> Add content</button>
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
	        		<table class="table table-hover">
	        			<thead>
	        				<tr>
	        					<th>#</th>
	        					<th>Name</th>
	        					<th>Action</th>
	        				</tr>
	        			</thead>
	        			<tbody>
		        			<tr class="ukryj">
				            	<td colspan="5" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
				            </tr>
	        				<tr class="tabela" v-for="content in contents" track-by="$index">
	        					<td>@{{ $index + 1 }}</td>
	        					<td>@{{ content.name }}</td>
	        					<td>
	        						<!-- edit -->
	        						<button @click="show(content, $index)" type="button" class="btn btn-sm btn-success" data-target="#edit-content" data-toggle="modal"><i class="fa fa-pencil" ></i> </button>
	        						<!-- delete -->
	        						<button @click="show(content, $index)" type="button" class="btn btn-sm btn-danger" data-target="#delete-content" data-toggle="modal"><i class="fa fa-times" ></i> </button>
	        					</td>
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        </div>
	    </div>
	</div>

	<div class="col-xs-12 col-md-7 col-sm-12 panel-ko-fluid" >
	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	Pages
	        </div>
	        <div class="panel-body">
	        	
	        	<div  class="alert alert-success text-center erorrs" v-if="status_p_c == 'is'" style="background: #1B9C01; color:white;">
	        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        		<strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success!</strong> @{{ status_desc_p_c }}
	        	</div>
	        	<div  class="alert alert-danger text-center erorrs" v-if="status_p_c == 'not'" style="background: #CB0000; color:white; ">
	        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        		<strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Warning!</strong> @{{ status_desc_p_c }}
	        	</div>

	        	<div class="table-responsive">
	        		<table class="table table-hover">
	        			<thead>
	        				<tr>
	        					<th>#</th>
	        					<th>Page</th>
	        					<th>Content</th>
	        					<th>Action</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<tr class="ukryj">
				            	<td colspan="5" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
				            </tr>
	        				<tr class="tabela" v-for="page in pages" track-by="$index">
	        					<td>@{{ $index + 1 }}</td>
	        					<td>@{{ page.name }}</td>
	        					<td>
	        						<span v-if="page.contents.length == 0">
	        							<span class="label label-danger">none</span>
	        						</span>
	        						<span v-if="page.contents.length > 0">
		        						<span v-for="p_c in page.contents">
		        							<span v-for="content in contents" v-if="content.id == p_c.content_id">
	        									<span class="label label-primary" >@{{ content.name }} </span><br>
	        								</span>
	        							</span>
	        						</span>
	        					</td>
	        					<td  >
	        						<!-- edit -->
	        						<button v-if="contents.length != 0" @click="showSecond(page, $index)" type="button" class="btn btn-sm btn-success" data-target="#edit-page-content" data-toggle="modal"><i class="fa fa-pencil" ></i> </button>
	        						<!-- edit file contents -->
	        						<a v-if="page.contents.length != 0" href="{{ url('admin/contents/page-contents/view') }}@{{ '/'+page.id }}" class="btn btn-sm btn-info"><i class="fa fa-file-text-o"></i></a>
	        					</td>
	        					
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        </div>
	    </div>
	</div>

	<!-- MODAL ADD CONTENT -->
	<div class="modal fade" id="add-content">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Add content</h4>
				</div>
				<div class="modal-body">
					<form id="form-create" class="form-horizontal" method="POST" action="{{ route('contents-create') }}" v-on:submit.prevent="add">
       					{{ csrf_field() }}
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-2 control-label" for="textinput">Name</label>  
						  <div class="col-md-10">
						  <input id="textinput" name="name" type="text" placeholder="name" class="form-control input-md" >
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

	<!-- MODAL EDIT CONTENT -->
	<div class="modal fade" id="edit-content">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit content - @{{ content.name }}</h4>
				</div>
				<div class="modal-body">
					<form id="form-edit" class="form-horizontal" method="POST" action="{{ route('contents') }}@{{'/edit/'+ content.id }}" v-on:submit.prevent="edit" >
       					{{ csrf_field() }}
       					{{ method_field('PUT') }}
       					<input type="hidden" name="id" :value="content.id">
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-2 control-label" for="textinput">Name</label>  
						  <div class="col-md-10">
						  <input id="textinput" name="name" type="text" placeholder="name" class="form-control input-md" :value="content.name">
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

	<!-- MODAL DELETE CONTENT -->
	<div class="modal fade" id="delete-content">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete content - @{{ content.name }}</h4>
				</div>
				<div class="modal-body text-center">
					<button type="button" class="btn btn-success" @click="onDelete(content)">YES</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL ADD CONTENT AND PAGE -->
	<div class="modal fade" id="edit-page-content">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit: @{{ page.name }}  </h4>

				</div>
				<div class="modal-body">
					<form id="form-edit-p-c" class="form-horizontal" method="POST" action="{{ route('contents-page-edit') }}" v-on:submit.prevent="edit_p_c">
       					{{ csrf_field() }}
						<!-- Text input-->
						<input type="hidden" name="page_id" :value="page.id">

							<div class="checkbox text-center"  v-for="content in contents" >
								<label >
									<input type="checkbox" name="contents[]" :value="content.id" :checked="checkContent(content.id)">
									@{{ content.name }}
								</label>

								<br>
							</div>
						<!-- Button -->
						<div class="form-group">
						  <div class="col-md-12 text-center" style="margin-top:30px;">
						    <button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
						    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js_body')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/contents.js')}}"></script>
@endsection