@extends($template.'index')

@section('head')
	<title>Search</title>
    <meta name="description" content="" /> 
    <meta name="keywords" content="" /> 
@endsection

@section('content')
<section id="content" class="container">
	<div class="row">
		<div class="col-xs-12 col-md-8 col-sm-12 ">
				@if(count($posts) > 0)
					@include($template.'modules.articles')
				@endif
				@if(count($albums) > 0)
					@include($template.'modules.albums')
				@endif
				@if(count($albums) == 0 && count($posts) == 0)
					<div class="panel panel-primary text-center" style="background: transparent;color:white; ">
						<div class="panel-body">
							<h3 class="panel-title">NOTHING FOUND !</h3>
						</div>
					</div>
				@endif
		</div>

		<div class="col-xs-12 col-md-4 col-sm-12">
    		<div class="widgets">
    			@if($global->search_widgets)
					@foreach($widgets as $widget)
						@include($template.'widgets.'.$widget->file)
					@endforeach
				@endif
    		</div>
    	</div>
	</div>
</section>
@endsection


