<!doctype html>
<html lang="en">
<head>

   <title>@yield('title',"Offercity")</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link rel="icon" href="{{url('/')}}/assets_front/images/favicon.png" type="image/x-icon">

  <meta name="_token" content="{{ csrf_token() }}">
    @include('buyer::auth.auth_includes.authcss')
    @toastr_css
     @yield('css')

</head>
<body>

  <div class="wrapper h-100">
        <div class="container-fluid mx-0 bgFull h-100">
            @yield('content')
        </div>        
    </div>

@include('buyer::auth.auth_includes.authscript')  
@toastr_js
@toastr_render
@yield('js')

</body>
</html> 