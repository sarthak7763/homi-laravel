<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    @php $favicon=getFavicon(); @endphp
  <!-- Favicon icon -->
  <link rel="icon" href="{{asset('storage'.@$favicon)}}" type="image/x-icon">
    <title>@yield('title','Offercity - CMS PAGE')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="_token" content="{{ csrf_token() }}">
 
    <!-- CSS start -->
 	<link href="{{ asset('assets_front/css/bootstrap.min.css')}}" rel="stylesheet">
   <link href="{{ asset('assets_front/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_front/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_front/css/responsive.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
 <style>
   .about_us > * {
    color: #000;
}

.about_us h1 {
    font-size: 36px;
    text-transform: uppercase;
    letter-spacing: .35px;
}

.about_us p {
    font-size: 16px;
    line-height: 26px;
    color: #444141;
    font-weight: 300;
}

.about_us  h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

h3 {
    font-size: 19px;
}
 </style>  
</head>
<body>
  <section class="about_us">
<div class="container">
<div class="row pt-2 headDiv">  
<div class="container">
   <div class="mt-2 mb-2">
      <h1 class="text-center mb-3 h3 mt-3">{{ @$page->page_name }}</h1>
      <div class="mt-2 mb-2 mb-3">
       {!! @$page->page_description !!}
      </div>
    </div>
</div>

</div>
</div>
</section>
 
</body>
</html>
