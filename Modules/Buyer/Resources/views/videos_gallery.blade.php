@extends('buyer::layouts.master')
@section('title', 'Offercity-Property Video Gallery')
@section('css')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"> -->
<link rel="stylesheet" href="{{asset('assets_front/fancybox/jquery.fancybox.min.css')}}">

@endsection
@section('content')
<div class="mainDiv videoGallery">    

  <div class="container-fluid profileBox mt-4">
    <div class="container ">  
      <div class="row">
        <div class="col col-md-6"> 
          <h4 class="display-5 heading text-left text-white mt-4">
          Video Gallery</h4><small class="text-white"> {{ @$propertyInfo->title }} </small> 
        </div>
        <div class="col col-md-6 text-right">       
          <a class="btn bg-white btn-sm mt-4" title="Go Back" href="{{route('buyer-property-detail',@$propertyInfo->slug)}}"><i class="fa fa-angle-left font-weight-light"></i> Back to Property</a>      
        </div>
      </div>
    </div>
  </div>  

  <div class="container mt-4 pt-4">
    <div class="row headimg">
      @if(!empty($videoList) && $videoList->count())
      @foreach($videoList as $key => $li)
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-image pt-0">
            <a href="{{$li->attachment}}" data-fancybox="gallery" data-caption="">
              <video style="width:100%; height:100%;" loop="true" muted="">
                <source src="{{@$li->attachment}}" type="video/mp4">
                </video>                
              </a>
            </div>
          </div>
        </div>
        @endforeach
        @else
        There are no image.
        @endif
      </div>

      {{--<div class="text-center mt-4 pt-4">        
        <a class="clickLink" href="{{route('buyer-property-detail',@$propertyInfo->slug)}}">  {{ @$propertyInfo->title }} </a>
      </div>--}}

    </div>


  </div>
  @endsection
  @section('js')
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
 -->
  <script src="{{asset('assets_front/fancybox/jquery.min.js')}}"></script>
<script src="{{asset('assets_front/fancybox/jquery.fancybox.min.js')}}"></script>


  <script type="text/javascript">
  // Fancybox Configuration
  $('[data-fancybox="gallery"]').fancybox({
    buttons: [
    "slideShow",
    "thumbs",
    "zoom",
    "fullScreen",
    "share",
    "close"
    ],
    loop: false,
    protect: true
  });

</script>
@endsection
