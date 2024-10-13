@extends('buyer::layouts.master')
@section('title',"FAQ")
@section('content')

<div class="container-fluid profileBox mt-4">
   <div class="container">        
     <h4 class="display-5 heading text-left text-white mt-4">
       FAQ
    </h4>
 </div>
</div>

<div class="container">
   <div class="mt-5 mb-2">
      <div class="accordion" id="accordionExample">
         @foreach($faqList as $k=>$li)
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
@endsection
@section('js')
<script type="text/javascript">
   $(document).ready(function(){
      $(".ac_mose button").click(function() {
       $(this).parent('.ac_mose').toggleClass('selected').siblings().removeClass('selected');
    });
   });
</script>
@endsection
