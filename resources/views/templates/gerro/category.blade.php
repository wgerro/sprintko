@extends($template.'index')

@section('head')
	<title>{{ $category_first->name }}</title>
    <meta name="description" content="{{ $category_first->description }}" /> 
    <meta name="keywords" content="" /> 
    <meta property="og:title" content=""/> 
    <meta property="og:url" content=""/> 
    <meta property="og:site_name" content=""/> 
    <meta property="og:description" content=""/> 
    <meta property="og:image" content=""> 
@endsection

@section('content')
<section id="content" class="container">
	<div class="row">
		<div class="col-xs-12 col-md-8 col-sm-12 ">
				<!-- posts -->
				@include($template.'modules.articles')
				<!-- albums -->
				@include($template.'modules.albums')
				<!-- paginate -->
				@if($paginator)
					@if($prevent_paginate != 'none')
					<a href="{{url('category/'.$prevent_paginate)}}" class="btn btn-danger"><</a>
					@else
					<a class="btn btn-danger disabled"><</a>
					@endif
					
					@foreach($numbers_paginate as $key=>$r)
						<a href="{{url('category/'.$r['slug'])}}" class="btn btn-danger @if($r['number'] == $actual) disabled @endif">{{ $r['number'] }}</a>
					@endforeach

					@if($next_paginate != 'none')
					<a href="{{url('category/'.$next_paginate)}}" class="btn btn-danger">></a>
					@else
					<a class="btn btn-danger disabled">></a>
					@endif
				@endif
		</div>
		<div class="col-xs-12 col-md-4 col-sm-12">
    		<div class="widgets">
    			@if($global->category_widgets)
					@foreach($widgets as $widget)
						@include($template.'widgets.'.$widget->file)
					@endforeach
				@endif
    		</div>
    	</div>
	</div>
</section>
@endsection