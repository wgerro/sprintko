@if($albums->count())
    <!-- MEDIA ALBUMS !-->
    <div class="media-albums col-xs-12 col-md-12 col-sm-12">
        <div class="row text-center">
            <h1 class="text-center">Media Albums</h1>
            @foreach($albums as $gallery)
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class=" media-albums-image">
                        <a href="{{ url('/albums/'.$gallery->slug) }}">
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
@endif