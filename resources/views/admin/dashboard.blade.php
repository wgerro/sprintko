@extends('admin.index')


@section('content')
<div id="app">
    <div class="col-xs-6 col-md-4  col-sm-6 box-ko">
        <span class="col-xs-12 col-md-6 box-ko-logo ko-blue-dark text-center">
            {{ date('d-m-Y',time()+7200) }}
        </span>
        <div class="col-xs-12 col-md-6 box-ko-title box-ko-info text-center">
            @{{ countDay }}
        </div>
    </div>

    <div class="col-xs-6 col-md-4  col-sm-6 box-ko">
        <span class="col-xs-12 col-md-6 box-ko-logo ko-green-dark text-center">
            {{ date('m-Y',time()+7200) }}
        </span>
        <div class="col-xs-12 col-md-6 box-ko-title box-ko-info text-center">
            @{{ countMonth }}
        </div>
    </div>

    <div class="col-xs-6 col-md-4  col-sm-6 box-ko">
        <span class="col-xs-12 col-md-6 box-ko-logo text-center" style="background: #E5A426;">
            {{ date('Y',time()+7200) }}
        </span>
        <div class="col-xs-12 col-md-6 box-ko-title box-ko-info text-center">
            @{{ countYear }}
        </div>
    </div>
    
    <div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
        
            <div class="panel panel-default panel-ko">
                <div class="panel-heading panel-ko-heading">
                    <p style="font-size:20px;">Welcome in sprintKO ! <i style="font-size:15px;">by Krystian Oziembała</i></p>
                </div>
                <div class="panel-body">
                    <a style="margin-top:5px;" href="{{ route('pages-create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add page</a>
                    <a style="margin-top:5px;" href="{{ route('category') }}" class="btn btn-info"><i class="fa fa-plus"></i> Add category</a>
                    <a style="margin-top:5px;" href="{{ route('posts-create') }}" class="btn btn-warning"><i class="fa fa-plus"></i> Add post</a>
                    <a style="margin-top:5px;" href="{{ route('media-single') }}" class="btn btn-danger"><i class="fa fa-plus"></i> Add gallerie one</a>
                    <a style="margin-top:5px;" href="{{ route('media-albums') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add gallerie with albums</a>
                    <a style="margin-top:5px;" href="{{ route('general') }}" class="btn btn-success"><i class="fa fa-cogs"></i> Settings</a>
                </div>
            </div>
            <!-- pudelka bez wypelnione kolorem-->
        
        <!-- end pudelka -->
    

    </div>

    
    
    
    <!-- end pudelka -->
    
    <div class="col-xs-12 col-md-6 col-sm-6 panel-ko-fluid">
        
            <div class="panel panel-default panel-ko">
                <div class="panel-heading panel-ko-heading text-center">
                    Counter recent months {{ date('Y', time() + 7200) }}    
                </div>
                <div class="panel-body">
                    <canvas id="myChart" width="400" height="250"></canvas>
                </div>
            </div>
        
    </div>

    <div class="col-xs-12 col-md-6 col-sm-6 panel-ko-fluid">
        
            <div class="panel panel-default panel-ko">
                <div class="panel-heading panel-ko-heading text-center">
                    Counter recent years {{ date('Y', time() + 7200) }}    
                </div>
                <div class="panel-body">
                    <canvas id="myChart2" width="400" height="250"></canvas>
                </div>
            </div>
        
    </div>
</div>
@endsection

@section('js_body')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/dashboard.js')}}"></script>
@endsection