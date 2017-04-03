@extends($template.'index')

@section('head')
	<title>{{ $page->title }}</title>
    <meta name="description" content="{{ $page->description }}" /> 
    <meta name="keywords" content="{{ $page->keywords }}" /> 
    <meta property="og:title" content="{{ $page->title }}"/> 
    <meta property="og:url" content="{{ url('/') }}"/> 
    <meta property="og:site_name" content="{{ $page->description }}"/> 
    <meta property="og:description" content="{{ $page->description }}"/> 
    <meta property="og:image" content=""> 
    <meta name="robots" {!! $page->robots ? 'content="index, follow"' : 'content="noindex, nofollow"' !!} >
@endsection

@section('css')
<link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">
@endsection

@section('content')

@if(Request::path() == '/')
<section id="articles">
    <div class="container">
        <div class="row">
        	@if(count($latest_posts) > 0)
        		<?php $check = false; ?>
	        	@foreach($latest_posts as $key=>$post)
	        		@if($key < 5)
		        		@if($key == 0)
			            <div class="col-xs-12 col-sm-12 col-md-6" style="padding-top:17px;">
			            	<div class="article-big">
			            		<a href="{{url('article/'.$post->slug)}}">
					                <img src="{{ asset('storage/posts/'.$post->image) }}">
					                <div class="caption">
			                            <p>{{ $post->subject }}</p>
			                            <i>{{ date('H:i, d-m-Y', strtotime($post->created_at) ) }}</i>
			                        </div>
			                    </a>
		                    </div>
			            </div>
			            @else
			            	@if(!$check)
			            		<div class="col-xs-12 col-sm-12 col-md-6 article-small"> <!-- start article small -->
			            	@endif
				            	<div class="col-md-6 col-xs-6 col-sm-6" style="padding-top:17px;" >
				            		<div class="box-small" >
					            		<a href="{{url('article/'.$post['slug'])}}">
					                        <img class="img-responsive" src="{{ asset('storage/posts/'.$post->image) }}" alt="">
					                        <div class="caption">
		                                        <p>{{ $post->subject }} </p>
		                                    </div>
					                    </a>
					                </div>
			            		</div>
			            	<?php $check = true; ?>
			            @endif
			        @endif
		        @endforeach

							@if(!$check)
			            		<div class="col-xs-12 col-sm-12 col-md-6 article-small"> <!-- start article small -->
			            	@endif
		        @if((5-count($latest_posts)) != 0)
		        	
				        @foreach( range(1, 5-count($latest_posts)) as $key=>$for)
			                <div class="col-md-6 col-xs-6 col-sm-6" style="padding-top:17px;" >
			                	<div class="box-small">
				                    <a href="#">
				                        <img class="img-responsive" src="https://dummyimage.com/220x180/000/fff" alt="">
				                        <div class="caption">
	                                        <p># {{ $key }} </p>
	                                    </div>
				                    </a>
				                </div>
			                </div>
				        @endforeach
				    
		        @endif
		        @if(!$check)
			        </div> <!-- end article small -->
			    @endif
		    @else
		    	<div class="col-xs-12 col-sm-12 col-md-6 ">
		    			<div class="article-big">
		                	<img src="https://dummyimage.com/220x180/000/fff">
		                </div>
		            </div>
		            <div class="col-xs-12 col-sm-12 col-md-6 article-small">
		                <div class="col-md-6 col-xs-6 col-sm-6 ">
			                <div class="box-small" >
			                    <a href="#">
			                        <img class="img-responsive" src="https://dummyimage.com/220x180/000/fff" alt="">
			                    </a>
			                </div>
		                </div>
		                <div class="col-md-6 col-xs-6 col-sm-6 ">
		                	<div class="box-small" >
			                    <a href="#">
			                        <img class="img-responsive" src="https://dummyimage.com/220x180/000/fff" alt="">
			                    </a>
			                </div>
		                </div>
		                <div class="col-md-6 col-xs-6 col-sm-6 box-small-res" style="padding-top: 17px;">
		                	<div class="box-small" >
			                    <a href="#">
			                        <img class="img-responsive" src="https://dummyimage.com/220x180/000/fff" alt="">
			                    </a>
			                </div>
		                </div>
		                <div class="col-md-6 col-xs-6 col-sm-6 box-small-res" style="padding-top: 17px;">
		                	<div class="box-small" >
			                    <a href="#">
			                        <img class="img-responsive" src="https://dummyimage.com/220x180/000/fff" alt="">
			                    </a>
			                </div>
		                </div>
		            </div>
		    @endif
        </div>
    </div>
</section>

@endif

<section id="content" class="container">
	<div class="row">
		<div class="col-xs-12 col-md-8 col-sm-12 ">

			<!-- CONTENT -->
            <div class="content-info col-xs-12 col-md-12 col-sm-12" style="color:white; margin-bottom: 20px;">
                <!-- wyswietlenie contentu :D -->
				@if($contents->where('content.name', 'content-1')->count())
					{!! Storage::get('pages/'.$contents->where('content.name', 'content-1')->first()->file) !!}
				@endif
            </div>

			<!-- Moduły -->
			@foreach($page->module as $module)
				@if($module->module == 1)
					@include($template.'modules.articles')
				@elseif($module->module == 2)
					@include($template.'modules.albums')
				@elseif($module->module == 3)
					@include($template.'modules.media-single')
				@elseif($module->module == 4)
					@include($template.'modules.cookies')
				@elseif($module->module == 5)
					@include($template.'modules.form-contact')
				@endif 
			@endforeach
			
		</div>
		<div class="col-xs-12 col-md-4 col-sm-12">
    		<div class="widgets">
    			@if($page->is_widgets)
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