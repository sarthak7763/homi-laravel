<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    @php $favicon=getFavicon(); @endphp
  <!-- Favicon icon -->
  <link rel="icon" href="{{asset('storage'.@$favicon)}}" type="image/x-icon">
    <title>@yield('title','Offercity - Faqs')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="_token" content="{{ csrf_token() }}">
 
    <!-- CSS start -->
 	<link href="{{ asset('assets_front/css/bootstrap.min.css')}}" rel="stylesheet">
   <link href="{{ asset('assets_front/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_front/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_front/css/responsive.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
   
</head>
<body>
<div class="container">
<div class="row pt-2 headDiv">  

<div class="container">
   <div class="mt-5 mb-2">
      <div class="accordion" id="accordionExample">
         @foreach($page as $k=>$li)
         <div class="ac_mose @if($k==0) selected @endif">
            <button class="button" type="button" data-toggle="collapse" data-target="#col{{$k}}" aria-expanded="true" aria-controls="collapse{{$k}}">
               {{$li->question}}
               <i class="fa fa-angle-down"></i>
            </button>
            <div id="col{{$k}}" class="collapse @if($k==0) show @endif" aria-labelledby="heading{{$k}}" data-parent="#accordionExample">
               <div class="card-body">
                  {!! $li->answer !!}
               </div>
            </div>
         </div>
         @endforeach         
      </div>
   </div>
</div>    

</div></div>
  <script src="{{ asset('assets_front/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/jquery-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/slick.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/intlTelInput.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets_front/js/script.js')}}"></script>
    <script src="{{ asset('assets_front/timer/jquery.plugin.js')}}"></script>
    <script src="{{ asset('assets_front/timer/jquery.countdown.js')}}"></script>

 <!-- Masking js -->
    <script src="{{ asset('assets_admin/assets/form-masking\inputmask.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\jquery.inputmask.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\autoNumeric.js')}}"></script>
    <script src="{{ asset('assets_admin/assets/form-masking\form-mask.js')}}"></script>


<script type="text/javascript" src="{{ asset('assets_admin/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<!-- Select 2 js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/select2/js/select2.full.min.js')}}"></script>
<!-- Multiselect js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js')}}">

</body>
</html>
