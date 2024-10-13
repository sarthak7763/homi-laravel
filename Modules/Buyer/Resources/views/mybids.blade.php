@extends('buyer::layouts.master')
@section('title', 'Offercity-My Bids')
@section('css')
<style type="text/css">
  .error_input{border: 1px solid red !important;}
  .setBox {width: 110px;height: 38px;}
  .disabled_offer_time { display: none !important; }
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
            <a class="nav-link active" href="{{route('buyer-bids')}}" role="tab">My Bids</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-fav-property')}}" role="tab">Favorite Property</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-profile')}}" role="tab">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-change-password')}}" role="tab">Settings</a>
          </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
          {{--<div class="tab-pane show active" id="MyBids" role="tabpanel">--}}
           {{--@if(@$myBid->count() > 0)--}}
          
          <div class="row">
            <div class="col-md-12 text-right">
              <form class="wonSection">
                <div class="form-group">
                  <select class="form-control d-inline-block" id="bid_status_select">
                    <option value="Active">Active</option>
                    <option value="Awarded">Awarded</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Closed">Closed</option>
                   <!--<option value="Cancelled">Cancelled</option>-->
                    <option value="Blocked">Blocked</option>
                  </select>
                </div>
              </form>
            </div>
          </div>
         
          <ul class="tabPane border-0" id="data-wrapper">
         {{-- @foreach(@$myBid as $li)
            <li>
              <div class="d-flex align-items-center justify-content-between">
                <div class="leftImg">
                  <img class="userBox" src="{{@$li->BidPropertyInfo->image}}" />
                </div>
                <div class="midDtl">
                  <div class="imgDetails w-100">
                    <p class="m-0">{{@$li->BidPropertyInfo->title}}</p>
                    <div class="priceBx">
                      <span class="float-left mainPrice">${{@$li->BidPropertyInfo->base_price}}</span>     
                    </div>
                    <div class="addressBox">
                      <i class="heartIcon">
                        <img src="{{$li->BidPropertyInfo->property_pic}}"></i>  
                        {{@$li->BidPropertyInfo->location}}
                    </div>
                    <div class="accomodation">
                      <div class="row">
                        <div class="col-sm d-flex align-items-center">
                          <i class="heartIcon"><img src="{{asset('assets_front/images/icons/home.svg')}}"></i>
                          <p class="aco_left">Built <span class="d-block">{{@$li->BidPropertyInfo->year_from}}-{{@$li->BidPropertyInfo->year_to}}</span></p>
                        </div>
                        <div class="col-sm d-flex align-items-center">
                            <i class="heartIcon"><img src="{{asset('assets_front/images/icons/area.svg')}}"></i>
                            <p class="aco_left">Sq. Ft <span class="d-block">{{@$li->BidPropertyInfo->property_size}}</span></p>
                        </div>
                        <div class="col-sm d-flex align-items-center">
                            <i class="heartIcon"><img src="{{asset('assets_front/images/icons/bathroom.svg')}}"></i>
                            <p class="aco_left">Bathroom <span class="d-block">{{@$li->BidPropertyInfo->no_of_bathroom}}</span></p>
                        </div>
                        <div class="col-sm d-flex align-items-center">
                            <i class="heartIcon"><img src="{{asset('assets_front/images/icons/bedroom.svg')}}"></i>
                            <p class="aco_left">Bedroom <span class="d-block">{{@$li->BidPropertyInfo->no_of_bedroom}}</span></p>
                        </div>
                        <a href="{{route('buyer-property-detail',@$li->BidPropertyInfo->slug)}}" class="seeDetails">See Details</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="rightPrice">
                    <div class="priceDetails">
                        <h3 class="bidPriceLabel">${{@$li->bid_price}}</h3>                        
                        <input type="text" 
                          placeholder="Enter Bid Price" 
                          style="display: none" maxlength="12" 
                          name="bid_price" maxlength="12" 
                          class="inputTextBidPrice only_number form-control setBox">
                        <p class="bidPriceP">Your Bid Price</p>
                    </div>
                    <button class="changeLink text-primary changeBidPricebtn">Change?</button>
                    <button class="changeLink text-primary saveBidPricebtn" data-id="{{$li->id}}" style="display: none">Save Price</button>
                    
                    <button class="changeLink text-danger cancelBidPricebtn" data-id="{{$li->id}}" style="display: none"> Cancel</button>
                </div>
              </div>
            </li>
               
          @endforeach--}}
          
          </ul>
           {{-- @else
            <div><h4>Hey {{Auth::user()->name}},</h4> 
            <p>Welcome to Offercity.</p>
            <p>You don't have any active bids on a property.</p>
           </div>

          @endif--}}
         <div class="text-center m-3">
            <button class="btn btn-primary" id="load-more" style="display: none"  data-paginate="2">Load More</button>
            <button class="btn btn-primary" id="load-more-status" style="display: none" data-paginateawarded="2" style="display: none;">Load More</button>
            

            <div class="invisible message_nodata">No More Bids</div>
        </div>
       {{-- </div>--}}

      </div>
    </div>
  </div>            
</div>

@endsection
@section('js')

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
 
<script>

var ENDPOINT = "{{ route('buyer-bids') }}";
var paginate = 1;
loadMoreData(paginate);
$('#load-more').click(function() {
    var page = $(this).data('paginate');
    loadMoreData(page);

    $(this).data('paginate', page+1);
});
// run function when user click load more button
function loadMoreData(paginate) {
   $.ajax({
       url: ENDPOINT + "?page=" + paginate,
        type: 'get',
        datatype: 'json',
        beforeSend: function() {
            $('#load-more').text('Loading...');
        }
    })
    .done(function(datas) {
       if(datas.status==0) {
            $('.invisible').removeClass('invisible');
             $(".message_nodata").html("No More Bids");
            $('#load-more').hide();
            return;
           }else if(datas.status==2){
              $('#load-more').text('Load More');
              $('#load-more').hide();
              $('.invisible').removeClass('invisible');
              $(".message_nodata").html('<div><h4>Hey {{Auth::user()->name}},</h4><p>Welcome to Offercity.</p><p>You don&rsquo;t have any active bids on a property.</p></div>');

         } else {
          if(datas.count_bid>8){
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

var AwardedURL = "{{ route('buyer-bids-status-wise') }}";
var paginateAwarded = 1;

        $('#load-more-status').click(function() {
            var pages = $(this).data('paginateawarded');
             var bid_status=$("#bid_status_select option:selected").val();
            loadMoreAwarded(pages,bid_status);
            $(this).data('paginateawarded', pages+1);
        });


        function loadMoreAwarded(paginateAwarded,bid_status) {
           $('#load-more').hide();
            $('#load-more-status').hide();
            $.ajax({
               url: AwardedURL + "?page=" + paginateAwarded,
                type: 'get',
                datatype: 'json',
                data: {bid_status:bid_status},
                beforeSend: function() {
                    $('#load-more-status').text('Loading...');
                }
            })
            .done(function(datas) {
              console.log(datas);
                if(datas.status==0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-status').hide();
                     $(".message_nodata").html("No More Bids");
                    return;
                  }else if(datas.status==2){
                    $('#load-more-status').text('Load More');
                    $('#load-more-status').hide();
                    $('.invisible').removeClass('invisible');
                    $(".message_nodata").html('<div><h4>Hey {{Auth::user()->name}},</h4><p>Welcome to Offercity.</p><p>You don&rsquo;t have any '+bid_status+' Bids on a property.</p></div>');

                  } else {
                    if(datas.count_bid > 8){
                      $('#load-more-status').show();
                      $('#load-more-status').text('Load More');
                    }
                   
                    $(".message_nodata").html("");
                    $("#data-wrapper").append(datas.bid_list);
                    //$("#data-wrapper").append(data);
                  }
            })
               .fail(function(jqXHR, ajaxOptions, thrownError) {
                  alert('Something went wrong.');
               });
        }

   $(document).ready(function(){
   
    $("#bid_status_select").change(function(){
     $("#data-wrapper").html("");
       // $("#processing").show();
        
        var bid_status = $(this).val();
      
        if(bid_status != '')
        {
            loadMoreAwarded(paginateAwarded,bid_status); 
          // $.ajax({
          //   type: 'POST',
          //   dataType: "json",
          //   url: "{{route('buyer-bids-status-wise')}}",
          //   data: {_token: "{{ csrf_token() }}",bid_status:bid_status},
          //   beforeSend: function(){
          //     $("#loading").show();
          //   },
          //   success: function(response){
          //      $("#data-wrapper").html("");
          //      $("#data-wrapper").append(response.bid_list);
          //   },
          //   complete: function(){
          //     $("#loading").hide();
          //   },
          // });
        }
        
    });
    
  });      
 

//infinteLoadMore(page);

// $(window).scroll(function () {
//   if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
//     ++page;
//     infinteLoadMore(page);
//   }
// });

// function infinteLoadMore(page){
//   $.ajax({
//   //  url: ENDPOINT + "?page=" + page,
//      type: 'POST',
//             dataType: "json",
//             url: "{{route('buyer-bids-status-wise')}}",
//             data: {_token: "{{ csrf_token() }}",bid_status:bid_status},
//             beforeSend: function(){
//               $("#loading").show();
//             },
//             success: function(response){
//                $("#data-wrapper").html("");
//                $("#data-wrapper").append(response.bid_list);
//             },
//             complete: function(){
//               $("#loading").hide();
//             },
//     // beforeSend: function () {
//     //     $('.auto-load').show();
//     //     //$("#loading").show();
//     // }
//   })
  // .done(function (response) {
    
  //     if (response.length == 0) {
  //       //$("#data-wrapper").html("djfshk");
  //         $('.auto-load').html("No More Bids found");
  //         return;
  //     }
  //     $('.auto-load').hide();
  //     $("#data-wrapper").append(response);
  // })
  // .fail(function (jqXHR, ajaxOptions, thrownError) {
  //     console.log('Server error occured');
  // });
//}

function loadjs(file) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = file;
    script.onload = function(){
        // alert("Script is ready!"); 
        // console.log(test.defult_id);
    };
    document.body.appendChild(script);
 }


 $(document).on('click','.changeBidPricebtn', function(){

  loadjs("{{asset('assets_admin/assets/form-masking/inputmask.js')}}");
  loadjs("{{asset('assets_admin/assets/form-masking/jquery.inputmask.js')}} ");
  loadjs("{{asset('assets_admin/assets/form-masking/autoNumeric.js')}}");
  loadjs("{{asset('assets_admin/assets/form-masking/form-mask.js')}}");

    $(this).closest('.rightPrice').find('.inputTextBidPrice').val("");
    $(this).closest('.rightPrice').find('.inputTextBidPrice').show();
    $(this).closest('.rightPrice').find('.bidPriceLabel').hide();
    $(this).closest('.rightPrice').find('.bidPriceP').hide();
    $(this).closest('.rightPrice').find('.changeBidPricebtn').hide();
    $(this).closest('.rightPrice').find('.saveBidPricebtn').show();
    $(this).closest('.rightPrice').find('.cancelBidPricebtn').show();

     $(".only_number").on('keyup keydown blur', function (event) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
  });

// Ensures that it is a number and stops the key press
$('.only_number').keydown(function(event) {
    if (!(!event.shiftKey //Disallow: any Shift+digit combination
            && !(event.keyCode < 48 || event.keyCode > 57) //Disallow: everything but digits
            || !(event.keyCode < 96 || event.keyCode > 105) //Allow: numeric pad digits
            || event.keyCode == 46 // Allow: delete
            || event.keyCode == 8  // Allow: backspace
            || event.keyCode == 9  // Allow: tab
            || event.keyCode == 27 // Allow: escape
            || (event.keyCode == 65 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+A
            || (event.keyCode == 67 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+C
            //Uncommenting the next line allows Ctrl+V usage, but requires additional code from you to disallow pasting non-numeric symbols
            //|| (event.keyCode == 86 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+Vpasting 
            || (event.keyCode >= 35 && event.keyCode <= 39) // Allow: Home, End
            )) {
        event.preventDefault();
    }
});
});

 


 $(document).on('click','.cancelBidPricebtn', function(){

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
 
var url="{{route('buyer-bid-price-update')}}";
 $(document).on('click','.saveBidPricebtn', function(){

    var bid_price=  $(this).closest('.rightPrice').find('.inputTextBidPrice').val();
    
    //console.log($(this));
    var bid_id = $(this).data('id');
    if(bid_price != ""){
      $(this).closest('.rightPrice').find('.inputTextBidPrice').removeClass('error_input');
      $.ajax({
        type: "POST",
        url: url,
        data: {_token: "{{ csrf_token() }}",bid_price:bid_price,bid_id:bid_id},
        dataType: "json",
        context:this,
        beforeSend: function(){
          $("#loading").show();
        },
        success: function (data){
         
          if(data.status=="success"){
             $(this).closest('.rightPrice').find('.inputTextBidPrice').hide();
            $(this).closest('.rightPrice').find('.bidPriceLabel').show();
            $(this).closest('.rightPrice').find('.changeBidPricebtn').show();
            $(this).closest('.rightPrice').find('.saveBidPricebtn').hide();
            $(this).closest('.rightPrice').find('.bidPriceP').show();
            $(this).closest('.rightPrice').find('.cancelBidPricebtn').hide();
            $(this).closest('.rightPrice').find(".bidPriceLabel").text(bid_price);
             toastr.success("Bid Price updated successfully");
          }
          else if(data.status=="Awarded"){
              toastr.error("Awarded bid price cannot update.");
            }else if(data.status=="Closed"){
               toastr.error("Closed bid price cannot update.");
            }else if(data.status=="Blocked"){
              toastr.error("Your bid has been blocked. you cannot place bid on this property.");    
            }
            else if(data.status=="error_sold"){
              toastr.error("Error! Property disabled.Cannot place bid on it.");
            }
            else{
             toastr.error(data.message);
             
            }
       
        },
        complete: function(){
          $("#loading").hide();
        },
      })
    }else{
     $(this).closest('.rightPrice').find('.inputTextBidPrice').addClass('error_input');
    }
});


</script>
@endsection
