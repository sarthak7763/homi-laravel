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



    <div class="wrapper h-100">
         
        <!--HEADER START -->
        @include('buyer::includes.header')
        <!--HEADER END -->

         <!--SIDEBAR START -->
         @include('buyer::includes.sidebar')
        <!--SIDEBAR END -->
      
        <!-- Main-body start -->
        @yield('content')
        <!-- Main-body end -->
        @include('buyer::includes.footer')
    </div>
    <!-- Script start -->
    

    
@toastr_js
@toastr_render
    @yield('js')
</body>
</html>