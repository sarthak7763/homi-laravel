<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    @php $favicon=getFavicon(); @endphp
  <!-- Favicon icon -->
  <link rel="icon" href="{{asset('storage'.@$favicon)}}" type="image/x-icon">
    <title>@yield('title','Homi Panel')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="_token" content="{{ csrf_token() }}">
 
    <!-- CSS start -->
    @include('buyer::includes.css')
     @toastr_css

  
    <!-- CSS end -->
    @yield('css')
</head>
<body>

<div id="loading" style="display: none;background-color:#0405067a; position:fixed;z-index:1000;top: 0px;left: 0px;height:100%;width:100%;">
    <img src="{{asset('assets_admin/loader.gif')}}" style="height: 125px;">
</div>

<div id="loaderDiv" style="background-color:#0405067a; position:fixed;z-index:99999999;top: 0px;left: 0px;height:100%;width:100%;">
    <img src="{{asset('assets_admin/loader.gif')}}" style="height: 125px;">
</div>

    <div class="wrapper h-100">
         
        <!--HEADER START -->
        @include('buyer::includes.header')
        <!--HEADER END -->
      
        <!-- Main-body start -->
        @yield('content')
        <!-- Main-body end -->
        @include('buyer::includes.footer')
    </div>
    <!-- Script start -->
    @include('buyer::includes.script')
    
@toastr_js
@toastr_render
    @yield('js')
</body>
</html>