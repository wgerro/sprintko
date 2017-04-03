<header>
    <div class="box-1 container-fluid text-center">
        <div class="row">
            <a href="{{ url('/') }}"><img src="{{ url($pageLogo) }}"></a>
        </div>
    </div>
    <nav class="navbar navbar-default box-2" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar" style="background-color:white;"></span>
                    <span class="icon-bar" style="background-color:white;"></span>
                    <span class="icon-bar" style="background-color:white;"></span>
                </button>
            </div>
    
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-left">
                	@foreach($menus as $menu)

                        <!-- sprawdzanie czy istnieje submenu -->
                        @if($submenus->where('page_sub_id', $menu->id)->count() > 0)

                            <li class="dropdown">
                                <a href="{{ url('/'.$menu->slug) }}" class="dropdown-toggle" data-toggle="dropdown"> {{ $menu->name }} <i class="fa icon-dropdown fa-angle-left" aria-hidden="true" style="margin-left: 10px;"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($submenus->where('page_sub_id', $menu->id) as $submenu)
                                        <li>
                                            <a href="{{ url('/'.$submenu->page_submenu->slug) }}">{{ $submenu->page_submenu->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @elseif(is_null($menu->sub))
                            <li><a href="{{ url('/'.$menu->slug) }}"> {{ $menu->name }} </a> </li>
                        @endif


                    @endforeach
                </ul>
            </div><!-- /.navbar-collapse -->


        </div>
    </nav>
</header>