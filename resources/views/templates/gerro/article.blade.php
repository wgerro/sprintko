@extends($template.'index')

@section('head')
	<title>{{ $article->subject }}</title>
    <meta name="description" content="{{ strip_tags(str_limit(Storage::get('posts/'.$article->description),250)) }}" /> 
    <meta name="keywords" content="" /> 
    <meta property="og:title" content="{{ $article->subject }}"/> 
    <meta property="og:url" content="{{ url('/article/'.$article->slug) }}"/> 
    <meta property="og:site_name" content="{{ strip_tags(str_limit(Storage::get('posts/'.$article->description),250)) }}"/> 
    <meta property="og:description" content="{{ strip_tags(str_limit(Storage::get('posts/'.$article->description),250)) }}"/> 
    <meta property="og:image" content="{{ asset('storage/posts/'.$article->image) }}"> 
    <meta name="robots" content="index, follow" >
@endsection

@section('css')
	<style>
	    .fb-comments, .fb-comments iframe[style], .fb-comments span {
		   width: 100% !important;
		}
    </style>
@endsection

@section('content')
@if($checkApi)
	@if($global->api == 'disqus')
				<script>
                var disqus_config = function () {
                this.page.url = "{{ url('article/'.$article->slug) }}";  
                this.page.identifier = "{{ $article->id }}"; 
                };

                (function() { 
                var d = document, s = d.createElement('script');
                s.src = '//cmsgerro.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
                })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    @endif
@endif
<section id="content" class="container">
	<div class="row">
		<div class="col-xs-12 col-md-8 col-sm-12 ">
			<!-- POST WITH COMMENTS -->
			<div class="post-with-comments col-xs-12 col-md-12 col-sm-12">
			    <div class="row">
			        <div class="image col-xs-12 col-md-12 col-sm-12">
			            <div class="row">
			                <img class="img-responsive" src="{{ asset('storage/posts/'.$article->image) }}">
			            </div>
			        </div>
			        <div class="info col-xs-12 col-md-12 col-sm-12">
			            <h3> {{ $article->subject }}  </h3>
			            <div class="icons">
			                <span style="font-size: 10px;" class="label label-default"> {{ $article->created_at }} </span> 
			                <span style="font-size: 10px;" class="label label-danger">
				                <i class="fa fa-comments"></i>
				                @if($checkApi)
									@if($global->api == 'facebook')
										<fb:comments-count href="{{url('article/'.$article->slug)}}"></fb:comments-count>
									@elseif($global->api == 'disqus')
										<span class="disqus-comment-count" data-disqus-identifier="{{ $article->id }}">0</span>
									@endif
								@else
									{{ $comments->where('post_id',$article->id)->count() }}
								@endif
			                </span>
			                @foreach($article->post_category as $key=>$article_category)
			                	<span style="font-size: 10px;" class="label label-primary"> {{ $article_category->category->name }}</span> 
			                @endforeach
			            </div>
			            <p>{!! Storage::get('posts/'.$article->description) !!}</p>
			        </div>
			        @if($checkApi)
			        	<div class="comments col-xs-12 col-md-12 col-sm-12">
				        	<div class="row">
				        		@if($global->api == 'facebook')
									<div style="background: white;" class="fb-comments col-xs-12" data-href="{{url('/article/'.$article->slug)}}" data-numposts="5"></div>
								@elseif($global->api == 'disqus')
									   <div style="background: white; padding:10px;"  id="disqus_thread"></div>
								@endif
				        	</div>
			        	</div>
			        @else
				        <div class="comments col-xs-12 col-md-12 col-sm-12 ">
				            <div class="row ">
				                @foreach($comments as $comment)
				                    <div style="background: white;">
				                        <div class="info-comments">
				                            <span style="font-size: 12px;" class="label label-danger"> {{ $comment->created_at }} </span> 
				                            <span style="font-size: 12px;" class="label label-default"><i class="fa fa-user"></i> {{ is_null($comment->user) ? $comment->nickname : $comment->user->name }} </span> 
				                            <span style="font-size: 12px;" class="label label-primary"> {{ $comment->subject }}</span> 
				                            
				                        </div>
				                        <div class="desc-comments">
				                            {{ $comment->description }}
				                        </div>
				                    </div>
				                @endforeach

				                <div class="form-comments">
				                	<h1 class="text-center">Add comment</h1>
				                        <form class="form-horizontal" method="POST" action="{{ route('add-comment') }}">
				                        	{{ csrf_field() }}
											<input type="hidden" name="post_id" value="{{ $article->id }}">
											@if(!Auth::check())
												<!-- Text input-->
												<div class="form-group">
												  <label class="col-md-4 control-label" for="textinput">Firstname and Lastname</label>  
												  <div class="col-md-7 col-xs-12">
												  <input id="textinput" name="nickname" type="text" placeholder="firstname and lastname" class="form-control input-md">
												  </div>
												</div>
											@endif

				                            <!-- Text input-->
				                            <div class="form-group">
				                              <label class="col-md-4 control-label" for="textinput">Subject</label>  
				                              <div class="col-md-7">
				                              <input id="textinput" name="subject" type="text" placeholder="subject" class="form-control input-md">
				                              </div>
				                            </div>

				                            <!-- Textarea -->
				                            <div class="form-group">
				                              <label class="col-md-4 control-label" for="textarea">Description</label>
				                              <div class="col-md-7">                     
				                                <textarea class="form-control" id="textarea" name="description"></textarea>
				                              </div>
				                            </div>

				                            <!-- Button -->
				                            <div class="form-group">
				                              <div class="col-md-12 text-center">
				                                <button id="singlebutton" name="singlebutton" class="btn btn-default"><i class="fa fa-plus"></i> Add comment</button>
				                              </div>
				                            </div>

				                        </form>
				                </div>
				            </div>
				        </div>
			        @endif
			    </div>
			</div>

			<!-- END POST WITH COMMENTS -->
		</div>
		<div class="col-xs-12 col-md-4 col-sm-12">
    		<div class="widgets">
    			@if($global->article_widgets)
					@foreach($widgets as $widget)
						@include($template.'widgets.'.$widget->file)
					@endforeach
				@endif
    		</div>
    	</div>
	</div>
</section>
@endsection


