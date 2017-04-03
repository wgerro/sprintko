@extends('admin.index')

@section('css')
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
@endsection

@section('content')
<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
				  <li class="breadcrumb-item "><a href="{{ route('posts') }}"><span class="label label-default">Posts</span></a></li>
                  <li class="breadcrumb-item active"><span class="label label-success">Edit</span></li>
			</ol>
            <div style="margin-top:15px;">
                <div >
                    <a href="{{ route('contents') }}" class="btn btn-primary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> RETURN</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
        	{{ $page->name }}
        </div>
        <div class="panel-body">
	        <form class="form-horizontal" method="POST" action="{{ route('contents-page-edit-file') }}">
	        	{{ csrf_field() }}
	        	{{ method_field('PUT') }}
	        	@foreach($page->contents as $content)
		        	<div class="col-md-6 col-xs-12 col-sm-12">
			        	<div class="text-center">
			        		<span class="label label-primary" style="font-size: 15px;"> 
			        			{{ $content->content->name }}
			        		</span>
			        	</div>
			        	<div style="margin-top: 20px;">
			        		<!-- Textarea -->
							<div class="form-group">
							  <div class="col-md-12">                     
							    <textarea class="form-control" id="textarea{{ $content->id }}" name="content[{{ $content->file }}]">
							    	{!! Storage::get('pages/'.$content->file) !!}
							    </textarea>
							  </div>
							</div>
			        	</div>
		        	</div>
	        	@endforeach
	        	<div class="form-group">
        			<div class="col-sm-12 text-center">
        				<button type="submit" class="btn btn-info">
        				<i class="fa fa-floppy-o"></i> SAVE
        				</button>
        			</div>
	        	</div>
	        </form>
        </div>
    </div>
</div>
@endsection

@section('js_body')
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>

	<script type="text/javascript">
		var config = {};
			config.minHeight = 200;
			config.maxHeight = null;
		@foreach($page->contents as $content)
			$('#textarea{{ $content->id }}').summernote(config);
		@endforeach
	</script>
@endsection