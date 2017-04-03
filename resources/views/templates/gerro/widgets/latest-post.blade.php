<div class="col-md-12 col-sm-6 col-xs-12 info-widgets">
    <div class="row">
		<!-- 5 OSTATNICH WIADOMOSCI -->
		<div class="col-xs-12 col-md-12 col-sm-12">
		    <div class="row">
		        <p>{{ $widget->name }}</p>
		        <p class="linia"></p>
		    </div>
		</div>
		@foreach($latest_posts as $l_post)
			<div class=" col-xs-12 col-md-12 col-sm-12 " >
			    <div class="row">
			        <div class="newsy">
			            <div class="col-xs-4 col-md-4 col-sm-4 newsy-image">
			                <div class="row">
			                    <img class="img-gerro" src="{{ asset('storage/posts/'.$l_post['image']) }}" alt="" >
			                </div>
			            </div>
			            <div class="col-xs-8 col-md-8 col-sm-8 newsy-title" >
			                <div class="row">
			                    <a href="{{ url('article/'.$l_post['slug']) }}">{{ $l_post['subject'] }}</a>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		@endforeach
		<!-- END 5 OSTATNICH WIADOMOSCI -->
	</div>
</div>