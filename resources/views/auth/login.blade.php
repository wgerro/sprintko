@extends('layouts.app')

@section('title')
Login | sprintKO
@endsection

@section('content')
<div class="container login-form">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
        <img src="{{ asset('nowe_logo_p.png') }}" style="height: 100px;">
            <div class="panel panel-default" style="margin-top: 50px; background: #9A1313; border:0px;">
                <div class="panel-body" >
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}"> 
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" >

                            <div class="col-xs-12">
                                <div class="input-group col-xs-12 col-sm-4 col-sm-offset-4 col-md-10 col-md-offset-1">
                                  <span class="input-group-addon"><i class='fa fa-user'></i></span>
                                  <input id="email" type="text" name="name" class="form-control"  value="{{ old('name') }}" placeholder="login or email" type="text" required autofocus>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block" style="color:white;">
                                        <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> </strong> {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                           
                                <div class="input-group col-xs-12 col-sm-4 col-sm-offset-4 col-md-10 col-md-offset-1">
                                  <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                  <input id="password" type="password" name="password" class="form-control" placeholder="password" type="text" required autofocus>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> </strong> {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">

                         <a class="btn btn-link" href="{{ url('/password/reset') }}" style="color:#D6D6D6">
                                    Forgot your password?
                                </a>

                                </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-sign-in"></i> Sign in
                                </button>

                               
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
