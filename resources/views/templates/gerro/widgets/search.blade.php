<div class="col-md-12 col-sm-6 col-xs-12 info-widgets">
    <div class="row">
        <!-- SEARCH -->
        <div class="col-xs-12 col-md-12 col-sm-12" >
            <div class="row">
                <p>{{ $widget->name}}</p>
                <p class="linia"></p>
            </div>
        </div>
        <div class=" col-xs-12 col-md-12 col-sm-12 socials" >
            <div class="row">
                <form class="form-horizontal" action="{{ route('search') }}" method="GET" role="form">
                	{{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-md-10 col-xs-10 col-sm-10">
                            <input type="text" name="search" class="form-control" placeholder="Search">
                        </div>
                        <div class="col-md-2 col-xs-2 col-sm-2">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- END SEARCH -->
    </div>
</div>