<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1 , user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        @yield('head')
        <!-- font awesome --> 
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('css')
        @yield('js_head')
        <script type="text/javascript"> var url = '{{ url("/policy-cookies") }}'; </script>
        <script type="text/javascript" src="{{ asset('js/cookies.js') }}"> </script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
      @if($checkApi)
        <!-- FACEBOOK API -->
        @if($global->api == 'facebook')
          <div id="fb-root"></div>
          <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.8";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));</script>
        @endif
      @endif

      @include($template.'header')

      @yield('content')

      @include($template.'footer')

      <!-- DISQUS COMMENTS -->
      @if($global->api == 'disqus')
        <script id="dsq-count-scr" src="//cmsgerro.disqus.com/count.js" async></script>
      @endif
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

      @yield('js_body')
      <script type="text/javascript">
          var szerokosc = $(window).width();
          if(szerokosc > 767)
          {
            $('.dropdown').on('show.bs.dropdown', function() {
              $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
              $('.icon-dropdown').addClass('fa-angle-down');
            });
            $('.dropdown').on('hide.bs.dropdown', function() {
              $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
              $('.icon-dropdown').removeClass('fa-angle-down');
            });
          }
          else{
            $('.dropdown').on('show.bs.dropdown', function() {
              $('.icon-dropdown').addClass('fa-angle-down');
            });
            $('.dropdown').on('hide.bs.dropdown', function() {
              $('.icon-dropdown').removeClass('fa-angle-down');
            });
          }
      </script>
  </body>
</html>

