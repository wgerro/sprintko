@extends('admin.index')

@section('css')
<style type="text/css">
	.fade-enter-active, .fade-leave-active {
	  transition: opacity .5s
	}
	.fade-enter, .fade-leave-active {
	  opacity: 0;
	}
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
.pokaz-view{
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
					  <li class="breadcrumb-item active"><span class="label label-success">Editor HTML</span></li>
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
	<div class="col-xs-12 col-md-4 col-sm-12 panel-ko-fluid" >
	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	MODULES
	        </div>
	        <div class="panel-body">
	        	<div class="table-responsive">
	        		<table class="table table-hover">
	        			<thead>
	        				<tr>
	        					<th>#</th>
	        					<th>Name</th>
	        					<th></th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<tr class="ukryj">
		                        <td colspan="3" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
		                    </tr>
	        				<tr v-for="editor in editors.modules" track-by="$index">
	        					<td>@{{ $index + 1 }}</td>
	        					<td>@{{ editor.name }}</td>
	        					<td>
	        						<button @click="show_file(editor,'modules')" class="btn btn-success kliknij"><i class="fa fa-pencil"></i></button>
	        					</td>
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        </div>
	    </div>

	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	WIDGETS
	        </div>
	        <div class="panel-body">
	        	<div class="table-responsive">
	        		<table class="table table-hover">
	        			<thead>
	        				<tr>
	        					<th>#</th>
	        					<th>Name</th>
	        					<th></th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<tr class="ukryj">
		                        <td colspan="3" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
		                    </tr>
	        				<tr v-for="editor in editors.widgets">
	        					<td>@{{ $index + 1 }}</td>
	        					<td>@{{ editor.name }}</td>
	        					<td>
	        						<button @click="show_file(editor,'widgets')" class="btn btn-success kliknij"><i class="fa fa-pencil"></i></button>
	        					</td>
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        </div>
	    </div>

	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	GENERAL
	        </div>
	        <div class="panel-body">
	        	<div class="table-responsive">
	        		<table class="table table-hover">
	        			<thead>
	        				<tr>
	        					<th>#</th>
	        					<th>Name</th>
	        					<th></th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<tr class="ukryj">
		                        <td colspan="3" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
		                    </tr>
	        				<tr v-for="editor in editors.general">
	        					<td>@{{ $index + 1 }}</td>
	        					<td>@{{ editor.name }}</td>
	        					<td>
	        						<button @click="show_file(editor,'general')" class="btn btn-success kliknij"><i class="fa fa-pencil"></i></button>
	        					</td>
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        </div>
	    </div>

	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	CSS
	        </div>
	        <div class="panel-body">
	        	<div class="table-responsive">
	        		<table class="table table-hover">
	        			<thead>
	        				<tr>
	        					<th>#</th>
	        					<th>Name</th>
	        					<th></th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<tr class="ukryj">
		                        <td colspan="3" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
		                    </tr>
	        				<tr v-for="editor in editors.css">
	        					<td>@{{ $index + 1 }}</td>
	        					<td>@{{ editor.name }}</td>
	        					<td>
	        						<button @click="show_file(editor,'css')" class="btn btn-success kliknij"><i class="fa fa-pencil"></i></button>
	        					</td>
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        </div>
	    </div>

	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	JS
	        </div>
	        <div class="panel-body">
	        	<div class="table-responsive">
	        		<table class="table table-hover">
	        			<thead>
	        				<tr>
	        					<th>#</th>
	        					<th>Name</th>
	        					<th></th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<tr class="ukryj">
		                        <td colspan="3" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
		                    </tr>
	        				<tr v-for="editor in editors.js">
	        					<td>@{{ $index + 1 }}</td>
	        					<td>@{{ editor.name }}</td>
	        					<td>
	        						<button @click="show_file(editor,'js')" class="btn btn-success kliknij"><i class="fa fa-pencil"></i></button>
	        					</td>
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        </div>
	    </div>
	    
	</div>
	<div class="col-xs-12 col-md-8 col-sm-12 panel-ko-fluid wyswietlenie-pliku" >
	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
	        	File: <span class="label label-primary ">@{{ editor.name }}</span>
	        </div>
	        <div class="panel-body file-view" v-show="file_view" transition="fade" style="display: none;">
	        
	        	<form method="POST" id="form-send" action="{{ route('editor-save') }}" class="form-horizontal" v-on:submit.prevent="send">
       			{{ csrf_field() }}
       				<!-- Button -->
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button id="singlebutton" name="singlebutton" class="btn btn-warning"><i class="fa fa-floppy-o"></i> SAVE</button>
						</div>
					</div>

       				<input type="hidden" name="file" value="@{{ editor.file }}">
					<!-- Textarea -->
					<div class="form-group">
						<div class="col-md-12">                     
							<textarea class="form-control" id="content" name="text_file" style="height: 100vh; background: #DEDEDE;">@{{ file.content }}</textarea>
						</div>
					</div>

					
				</form>
	        </div>
	    </div>
	</div>


</div>
@endsection

@section('js_body')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/editor.js')}}"></script>
@endsection
