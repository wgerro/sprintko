<div class="col-md-12 col-sm-6 col-xs-12 info-widgets">
    <div class="row">
        <!-- KATEGORIE -->
        <div class="col-xs-12 col-md-12 col-sm-12 " >
            <div class="row">
                <p>{{ $widget->name}}</p>
                <p class="linia"></p>
            </div>
        </div>
        <div class=" col-xs-12 col-md-12 col-sm-12 category category-info" >
            <div class="row">
                @foreach($category as $cat)
                    <a href="{{ url('category/'.$cat->slug) }}" class="btn btn-primary">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
        <!-- END KATEGORIE -->
    </div>
</div>