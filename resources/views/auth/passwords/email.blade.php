@extends('layouts.app')

@section('title')
Email | Reset password
@endsection

<!-- Main Content -->
@section('content')
<div class="container login-form">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
        <img src="{{ asset('nowe_logo_p.png') }}" style="height: 100px;">
        <h3 style="color:#F3F3F3"> Reset password </h3>
            <div class="panel panel-default" style="margin-top:50px;">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success" style="background: #0E7400; color:white;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
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
