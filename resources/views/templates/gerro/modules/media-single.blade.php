<!-- MEDIA SINGLE -->
<div class="media-single col-xs-12 col-md-12 col-sm-12">
    <div class="row text-center">
        <h1 class="text-center">Media Single</h1>
        @foreach($media_single->where('option','image') as $media)
            <div class="col-md-4 col-sm-4 col-xs-6">
                <div class=" media-single-image" >
                    <a href="{{ url($media->url) }}" data-lightbox="image" data-title="{{ $media->name }}">
                        <img src="{{ asset($media->url) }}" alt="{{ $media->name }}">
                        <p class="text-center"> 
                            {{ $media->name }}
                        </p>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- END MEDIA SINGLE -->