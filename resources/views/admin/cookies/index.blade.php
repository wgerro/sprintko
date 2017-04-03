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
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
@endsection

@section('content')
<div id="app">
	<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
	    <div class="panel panel-default panel-ko" >
	        <div class="panel-heading panel-ko-heading">
				<ol class="breadcrumb">
					  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
					  <li class="breadcrumb-item active"><span class="label label-success">Policy cookies</span></li>
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
	        <div class="panel-body" >
	        
	        	<form method="POST" id="form-edit" action="{{ route('cookies-update') }}" class="form-horizontal" v-on:submit.prevent="edit">
       			{{ csrf_field() }}
       			{{ method_field('PUT') }}
       				<!-- Button -->
					<div class="form-group">
						<div class="col-md-12">
							<button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
						</div>
					</div>

					<!-- Textarea -->
					<div class="form-group">
						<div class="col-md-12">                     
							<textarea class="form-control" id="content" name="content" >
								{!! $content !!}
							</textarea>
						</div>
					</div>

					
				</form>
	        </div>
	    </div>
	</div>

</div>
@endsection

@section('js_body')
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/cookies.js')}}"></script>
@endsection
