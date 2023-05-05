@extends('buyer::layouts.master')
@section('title', 'Offercity-Favourite Property')
@section('css')
<style type="text/css">
  .error_input
  {
    border: 1px solid red !important;
  }
</style>
@endsection
@section('content')
@include('buyer::includes.profile_header')
<!-- tabs -->        
<div class="container">
  <div class="row mt-5">
    <div class="col-md-12 tabsPenal">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-bids')}}" role="tab">My Bids</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{route('buyer-fav-property')}}" role="tab">Favorite Property</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-profile')}}"  role="tab">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-change-password')}}" role="tab">Settings</a>
          </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        {{-- <div class="tab-pane fade" id="FavProperty" role="tabpanel">   --}} 
         <div class="fav_Property" id="data-wrapper">
          {{-- LOAD AJAX PROPERTY LIST HERE--}} 
          </div>
        {{-- </div>--}}

      
        <!-- Data Loader -->
        <div class="text-center m-3">
            <button class="btn btn-primary" id="load-more" style="display: none" data-paginate="2">Load More</button>
          

            <div class="invisible message_nodata">No More Favorite Property</div>
        </div>
        <!-- END Data Loader -->
      </div>
    </div>
  </div>            
</div>

@endsection
@section('js')
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
var ENDPOINTS = "{{ url('/buyer/fav-property') }}";
var paginates = 1;

loadMoreData(paginates);
$('#load-more').click(function() {
    var page = $(this).data('paginates');
    loadMoreData(page);

    $(this).data('paginate', page+1);
});


     toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "2000",
            "hideDuration": "2000",
            "timeOut": "100",
            "extendedTimeOut": "100",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          };
          

function loadMoreData(paginate) {
    $.ajax({
        url: ENDPOINTS + "?page=" + paginate,
        type: 'get',
        datatype: 'json',
        beforeSend: function() {
            $('#load-more').text('Loading...');
        }
    })
    .done(function(datas) {
       if(datas.status==0) {
            $('.invisible').removeClass('invisible');
             $(".message_nodata").html("No More Favorite Property");
            $('#load-more').hide();
            return;
           }else if(datas.status==2){
              $('#load-more').text('Load More');
              $('#load-more').hide();
              $('.invisible').removeClass('invisible');
              $(".message_nodata").html('<div class="mt-5"><h4>Hey {{Auth::user()->name}},</h4><p>Welcome to Offercity.</p><p>You don&rsquo;t have any favorite property.</p></div>');

         } else {
          if(datas.fav_count>8){
            $('#load-more').show();
             $('#load-more').text('Load More');
          }
            
            $(".message_nodata").html("");
           $("#data-wrapper").append(datas.bid_list);
          }
    })
       .fail(function(jqXHR, ajaxOptions, thrownError) {
          alert('Something went wrong.');
       });
}



//------------MANAGE BID PRICE----------//
$(".changeBidPricebtn").click(function(){
    $(this).closest('.rightPrice').find('.inputTextBidPrice').val("");
    $(this).closest('.rightPrice').find('.inputTextBidPrice').show();
    $(this).closest('.rightPrice').find('.bidPriceLabel').hide();
    $(this).closest('.rightPrice').find('.bidPriceP').hide();
    $(this).closest('.rightPrice').find('.changeBidPricebtn').hide();
    $(this).closest('.rightPrice').find('.saveBidPricebtn').show();
    $(this).closest('.rightPrice').find('.cancelBidPricebtn').show();
});

$(".cancelBidPricebtn").click(function(){
    $(this).closest('.rightPrice').find('.inputTextBidPrice').removeClass('error_input');
    $(this).closest('.rightPrice').find('.inputTextBidPrice').val("");
    $(this).closest('.rightPrice').find('.inputTextBidPrice').hide();
    $(this).closest('.rightPrice').find('.bidPriceLabel').show();
    $(this).closest('.rightPrice').find('.bidPriceP').show();
    $(this).closest('.rightPrice').find('.changeBidPricebtn').show();
    $(this).closest('.rightPrice').find('.saveBidPricebtn').hide();
    $(this).closest('.rightPrice').find('.cancelBidPricebtn').hide();
});

$('.inputTextBidPrice').focus(function() {
   $(this).closest('.rightPrice').find('.inputTextBidPrice').removeClass('error_input');   
});


$(document).ready(function() {
  $(".fav_Property").on("change", ":checkbox",  function() {
    var str="";
    var property_id = $(this).attr("data-propertyid"); 
    var fav_id = $(this).attr("data-favid"); 
    if($(this).is(":checked")){
      var url ='{{route("buyer-property-add-to-favourite")}}';     
      str="added to";
      status="check";
    }else{
      var url='{{route("buyer-property-remove-from-favourite")}}';
      str="remove from";
      status="uncheck";       
    }
    $.ajax({
      type: "POST",
      url: url,
      context:this,
      data: {property_id:property_id,fav_id:fav_id,status:status,_token: "{{ csrf_token() }}"},      
        success: function(msg){
                   if(msg.status =='success'){
                        if(msg.result!=""){
                           $(this).attr('data-favid',msg.result);
                        }
                         toastr.success("Property "+str+" Favorite property");
                    } 
                    else{
                          toastr.error("Something went wrong");
                    }
                }
            }); 
    });    
});
 
</script>
@endsection
