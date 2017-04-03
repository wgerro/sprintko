<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Administrator</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/ko.css') }}" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:300,400,600,700,300italic,400italic,600italic' rel='stylesheet' type='text/css'>
    <meta name="robots" content="noindex, nofollow">
    @yield('css')
    @yield('js_head')
  </head>
  <body>
      <!-- Header -->
      @include('admin.header')
      <div id="wrapper">
      <!-- Sidebar -->
        @include('admin.sidebar')
      <!-- Content Wrapper. Contains page content -->
        <div id="content-ko" class="container-fluid">
                 
            @yield('content')
          
        </div>
        
      </div>
    <div id="footer" class="text-center col-xs-12">
        Copyright &copy; <?php echo date("Y"); ?> sprintKO | All rights reserved.
    </div>
      
      <!--<script src="{{ elixir('js/app.js') }}"></script>-->
      <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>    
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>    
      <script src="{{asset('js/ko.js')}}"></script>
      @yield('js_body')
    
  </body>
</html>