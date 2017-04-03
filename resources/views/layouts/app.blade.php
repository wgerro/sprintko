<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link href='http://fonts.googleapis.com/css?family=Arimo&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <meta name="robots" content="noindex, nofollow">
    <style type="text/css">
        body{
            background: #2A2A2A;
            font-family: 'Arimo', sans-serif;
        }
        .login-form{
            margin-top: 50px;

        }
        .panel{
            border-radius:0px;
            border-top-right-radius: 20px;
            border-bottom-left-radius: 20px;
        }
        .panel-heading{
            border-color:white !important;
            background: black !important;
            text-align: center;
        }
        .input-group-addon{
            width: 40px;
            background: white;
            border-radius: 0px;
            color:black;
        }
        .form-control{
            border-radius: 0px;
        }
        .btn{
            border-radius: 0px;
        }
        .info{
            color:#BEBEBE;
            font-size:13px;
        }
    </style>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <div class="info col-xs-12 text-center">
    Copyright &copy; sprintKO {{ date('Y') }} <br>
    All rights reserved
    </div>
    <!-- Scripts -->
</body>
</html>
