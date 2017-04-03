<div id="left-ko">
    <div class="col-xs-12" id="left-ko-user">
        <div class="row">
            <div class="text-center">
                <img class="img-circle profilowe" src="{{asset('logo.png')}}">
                <div style="color:white;margin-top:5px;margin-bottom: 5px;">
                    {{ Auth::user()->name }}
                </div>
            </div>
            <div class="text-center" style="margin-top:10px;">
                <form method="POST" action="{{url('logout')}}">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-sign-out"></i></button>
                    <a href="{{url('/')}}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-link"></i></a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="title_menu">
                MENU
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <ul class="lista ">
                <li class="lista_li"><a class="lista_a" href="{{ route('dashboard') }}"><i class="fa fa-coffee" aria-hidden="true"></i> <span style="margin-left:10px;">Dashboard</span> </a></li>
                <li class="lista_li"><a class="lista_a" href="{{ route('pages') }}"><i class="fa fa-bars" aria-hidden="true"></i><span style="margin-left:10px;"> Pages</span> </a></li>
                <li class="lista_li"><a class="lista_a" href="{{ route('contents') }}"><i class="fa fa-file-text-o" aria-hidden="true"></i><span style="margin-left:10px;"> Contents</span> </a></li>
                <li class="lista_li"><a class="lista_a" href="{{ route('category') }}"><i class="fa fa-list-ul" aria-hidden="true"></i><span style="margin-left:10px;"> Category</span> </a></li>
                <li class="lista_li"><a class="lista_a ko-dropdown1" ><i class="fa fa-rocket" aria-hidden="true"></i> <span style="margin-left:10px;">Modules </span> <i class="ko-iko1 fa fa-angle-left " style="margin-left:20px;" aria-hidden="true"></i></a>
                    <ul class="lista_li_open1">
                        <li class="lista_li_open_li"><a class="lista_li_open_a" href="{{ route('posts') }}"> Posts</a></li>
                        <li class="lista_li_open_li"><a class="lista_li_open_a" href="{{ route('comments') }}"> Comments</a></li>
                        <li class="lista_li_open_li"><a class="lista_li_open_a" href="{{ route('media-albums') }}">Media albums</a></li>
                        <li class="lista_li_open_li"><a class="lista_li_open_a" href="{{ route('media-single') }}">Media single</a></li>
                        <li class="lista_li_open_li"><a class="lista_li_open_a" href="{{ route('cookies') }}">Policy cookies</a></li>
                    </ul>
                </li>
                <li class="lista_li"><a class="lista_a" href="{{ route('widgets') }}"><i class="fa fa-ellipsis-h" aria-hidden="true"></i><span style="margin-left:10px;"> Widgets</span> </a></li>
                <li class="lista_li"><a class="lista_a" href="{{ route('templates') }}"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span style="margin-left:10px;"> Templates</span> </a></li>
                <li class="lista_li"><a class="lista_a ko-dropdown2" ><i class="fa fa-cogs" aria-hidden="true"></i> <span style="margin-left:10px;">Settings </span> <i class="ko-iko2 fa fa-angle-left " style="margin-left:20px;" aria-hidden="true"></i></a>
                    <ul class="lista_li_open2">
                        <li class="lista_li_open_li"><a class="lista_li_open_a" href="{{ route('general') }}"> General</a></li>
                        <li class="lista_li_open_li"><a class="lista_li_open_a" href="{{ route('mails') }}">Mails</a></li>
                    </ul>
                </li>
                <li class="lista_li"><a class="lista_a" href="{{ route('editor') }}"><i class="fa fa-file-code-o" aria-hidden="true"></i><span style="margin-left:10px;"> Editor HTML</span> </a></li>
                <li class="lista_li"><a class="lista_a" href="{{ route('media') }}"><i class="fa fa-cloud-download" aria-hidden="true"></i><span style="margin-left:10px;"> Media </span> </a></li>
            </ul>
        </div>
    </div>
</div>