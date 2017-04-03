@foreach($posts as $key=>$post)
	<div class="col-xs-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="blog">
				    <div class="col-xs-12 col-md-4 col-sm-6 blog-image">
				        <div class="row">
				            <a href="{{url('article/'.$post['slug'])}}"><img class="img-gerro" src="{{ asset('storage/posts/'.$post['image']) }}" alt=""></a>
				        </div>
				    </div>
				    <div class="col-xs-12 col-md-8 col-sm-6 blog-text">
				        <b><p class="blog-text-p-title"><a href="{{url('article/'.$post['slug'])}}">{{ $post['subject'] }}</a></p></b>
				        <p class="blog-text-p-info">
				            <span style="font-size: 10px;" class="label label-default"> {{ $post['created_at'] }}</span>
				            @if($checkApi) 
				            	<span style="font-size: 10px;" class="label label-danger"><i class="fa fa-comments"></i> 
				            		@if($global->api == 'facebook')
										<fb:comments-count href="{{url('article/'.$post['slug'])}}"></fb:comments-count>
									@elseif($global->api = 'disqus')
										<span class="disqus-comment-count" data-disqus-identifier="{{ $post['id'] }}">0</span>
									@endif
				            	</span>
				            @else
				            	<span style="font-size: 10px;" class="label label-danger"><i class="fa fa-comments"></i> 
				            		{{ $comments->where('post_id',$post['id'])->count() }}
				            	</span>
				            @endif
				            @foreach($post['category'] as $key=>$category) 
				            	<span style="font-size: 10px;" class="label label-primary"> {{$category}}</span>
				            @endforeach 
				        </p>
				        <p class="blog-text-p-desc">{!! str_replace(['<div>','</div>'],'',str_limit(Storage::get('posts/'.$post['description']),280,'...')) !!}</p>
				        <a href="{{url('article/'.$post['slug'])}}" class="btn btn-default btn-sm pull-right" >More</a>
				    </div>

			</div>
		</div>
	</div>
@endforeach

<!-- paginate -->
@if(!empty($paginator))
	@if($prevent_paginate != 'none')
	<a href="{{url($prevent_paginate)}}" class="btn btn-danger"><</a>
	@else
	<a class="btn btn-danger disabled"><</a>
	@endif
	
	@foreach($numbers_paginate as $key=>$r)
		<a href="{{url($r['slug'])}}" class="btn btn-danger @if($r['number'] == $actual) disabled @endif">{{ $r['number'] }}</a>
	@endforeach

	@if($next_paginate != 'none')
	<a href="{{url($next_paginate)}}" class="btn btn-danger">></a>
	@else
	<a class="btn btn-danger disabled">></a>
	@endif
@endif