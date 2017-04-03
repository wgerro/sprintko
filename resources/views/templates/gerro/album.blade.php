@extends($template.'index')

@section('head')
	<title>{{ $albums->name }}</title>
    <meta name="description" content="" /> 
    <meta name="keywords" content="" /> 
    <meta property="og:title" content=""/> 
    <meta property="og:url" content=""/> 
    <meta property="og:site_name" content=""/> 
    <meta property="og:description" content=""/> 
    <meta property="og:image" content=""> 
    <meta name="robots" content="index, follow" >
@endsection

@section('css')
<link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">
@endsection

@section('content')
<section id="content" class="container">
	<div class="row">
		<div class="col-xs-12 col-md-8 col-sm-12 ">
			<!-- MEDIA ALBUMS -->
			<div class="media-albums col-xs-12 col-md-12 col-sm-12">
			    <div class="row text-center">
			        <h1 class="text-center">Media Albums</h1>
			        @foreach($albums->files->where('option','images') as $gallery)
			            <div class="col-md-4 col-sm-4 col-xs-6">
			                <div class=" media-albums-image">
			                    <a data-lightbox="image" data-title="{{ $gallery->name }}" href="{{ asset($gallery->url) }}">
			                        <img src="{{ asset($gallery->url) }}" alt="Image">
			                        <p class="text-center"> 
			                            {{ $gallery->name }}
			                        </p>
			                    </a>
			                </div>
			            </div>
			        @endforeach
			    </div>
			</div>
			<!-- END MEDIA ALBUMS -->
		</div>
		<div class="col-xs-12 col-md-4 col-sm-12">
    		<div class="widgets">
    			@if($global->gallery_widgets)
					@foreach($widgets as $widget)
						@include($template.'widgets.'.$widget->file)
					@endforeach
				@endif
    		</div>
    	</div>
	</div>
</section>
@endsection

@section('js_body')
<script type="text/javascript" src="{{ asset('js/lightbox.js')}}"></script>
@endsection


