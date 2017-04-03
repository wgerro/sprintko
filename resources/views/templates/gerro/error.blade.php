@extends($template.'index')

@section('head')
	<title>{{ $error_code }}</title>
@endsection

@section('content')
<section id="content" class="container">
	<div class="row">
		<div class="col-xs-12 col-md-8 col-sm-12 ">
			<div class="panel panel-primary text-center" style="background: transparent;color:white; ">
				<div class="panel-body">
					<h3 class="panel-title">404 ! PAGE NOT FOUND !</h3>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-4 col-sm-12">
    		<div class="widgets">
    			@if($global->error_widgets)
					@foreach($widgets as $widget)
						@include($template.'widgets.'.$widget->file)
					@endforeach
				@endif
    		</div>
    	</div>
	</div>
</section>
@endsection