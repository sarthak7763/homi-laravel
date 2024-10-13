@extends('buyer::layouts.master')
@section('title', 'Offercity-Property Detail')
@section('css')
<style type="text/css">
    .mtSpace{margin-bottom: 37px;}  
    .error_input{border: 1px solid red !important;}
</style>
@endsection
@section('content')
{{-- <div class="row mt-4 pt-2">
    <div class="col-md-12">
        <div class="alert alert-success altSucs mb-0">Congrats! Seller has accepted your offer for $4595 high bid amount</div>
    </div>
</div>--}}

<div class="container">
    <div class="row mt-4 headimg">
        <div class="col-md-7 pr-0 imgLeft">
            <div class="imgBlock" onclick="openLightbox();toSlide(0)">
                <img src="{{@$propertyInfo->image}}" class="img-fluid w-100 heightVH" /></div>
                @if(@$propertyInfo->escrow_status != "Active")
                <a href="#" class="allImages pending">{{ @$propertyInfo->escrow_status}}</a>
                @endif
                

                <!--  <button onclick="openLightbox();toSlide(0)" class="allImages"><img src="{{asset('assets_front/images/icons/image.svg')}}" /> All images</button> -->
                <a href="{{ route('buyer-property-gallery-show',@$propertyInfo->id) }}"  class="allImages"><img src="{{asset('assets_front/images/icons/image.svg')}}" /> All Images</a>

            </div>
            @if(@$galleryList->count() > 0)
            <div class="col-md-5 pl-0 pr-0 imgRight text-left">
                <div class="img01">
                    <div class="row m-0">
                        @foreach(@$galleryList as $k=>$gli)
                        @if(@$k>=2)   
                        <div class="col-sm-6 col-xs-6 pr-0"><img src="{{@$gli->attachment}}" onclick="openLightbox();toSlide({{$k+1}})" class="img-fluid mb-0 img-responsive"/></div>
                        @else
                        <div class="col-sm-6 col-xs-6 pr-0"><img src="{{@$gli->attachment}}" onclick="openLightbox();toSlide({{$k+1}})" class="img-fluid img-responsive"/></div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="yellowBG w-100">
     <div class="container">
        <div class="row">

            <div class="col-md-7">
              @if(isset($propertyOffer) && !empty($propertyOffer))
              {{--  @if(!isset($mybid) && empty($mybid))--}}
              <form class="needs-validation valiSec" novalidate>
                <div class="form-row">
                    <input type="text" class="form-control autonumber inputTextBidPriceSave"  id="validationTooltip01" maxlength="12" data-a-sign="$"  data-v-min="0" data-v-max="999999999999" placeholder="Submit highest and best offer." required>
                    <button class="btn btn-primary" id="submitBidPrice"  data-property_id="{{@$propertyInfo->id}}" data-offer_id="{{@$propertyOffer->id}}" type="button">Place Offer</button>
                    <div class="valid-tooltip er_message transparent">Enter your offer Amount</div>
                </div>
            </form>
            {{-- @endif--}}
            @endif
        </div>

        <div class="col-md-5 text-right">
            <div class="timer">
                <div class="label d-flex justify-content-end">
                 <span class="offermessage"></span>
                 <div id="defaultCountdown" data-enddate="{{@$propertyOffer->date_end}}" data-endtime="{{@$propertyOffer->time_end}}"></div>
             </div>
         </div>
     </div>
 </div>
</div>  
</div>

<div class="container topPad">
    <div class="row">
        <div class="col-md-7">
            <div class="head">
                @if(@$propertyInfo->base_price != "")
                @php $price=moneyFormat(@$propertyInfo->base_price); @endphp

                <h2>

                {{@$price}}</h2>
                @endif
                @if(@$propertyInfo->title != "")
                <p>{{@$propertyInfo->title}}</p>
                @endif

                <i class="faHeart">
                  <input class="form-check-input" type="checkbox" id="favPropertyCheckBox" data-propertyid="{{@$propertyInfo->id}}" data-favid="{{@$favProperty->id}}" @if(@$favProperty) checked="checked" @endif>
                  <label class="form-check-label" for="favPropertyCheckBox"></label>                            
                </i>


          </div>
          @if(@$propertyInfo->count() > 0)
          <ul class="amenity">
            @if(@$propertyInfo->year_from != "")
            <li>
                <i class="heartIcon float-left"><img width="42" src="{{asset('assets_front/images/icons/home.svg')}}"></i>
                <p class="float-left">Built <span class="d-block">
                    {{@$propertyInfo->year_from}} 
                </span></p>
            </li>
            @endif
            @if(@$propertyInfo->property_size != "")
            <li>
                <i class="heartIcon float-left"><img width="48" src="{{asset('assets_front/images/icons/area.svg')}}"></i>
                <p class="float-left">Sq Ft <span class="d-block">
                     @php $property_size=numberPlaceFormat(@$propertyInfo->property_size); @endphp

                     {{@$property_size}}</span></p>
            </li>
            @endif
            @if(@$propertyInfo->no_of_bathroom != "")
            <li>
                <i class="heartIcon float-left"><img width="48" src="{{asset('assets_front/images/icons/bathroom.svg')}}"></i>
                <p class="float-left">Bathroom <span class="d-block">{{@$propertyInfo->no_of_bathroom}}</span></p>
            </li>
            @endif
            @if(@$propertyInfo->no_of_bedroom!="")
            <li>
                <i class="heartIcon float-left"><img width="48" src="{{asset('assets_front/images/icons/bedroom.svg')}}"></i>
                <p class="float-left">Bedroom <span class="d-block">{{@$propertyInfo->no_of_bedroom}}</span></p>
            </li>
            @endif
        </ul>
        @endif
        <div class="row">
            @if(@$propertyOffer->date_end!="")
            <div class="col-md-6">
                <div class="ofrDue">
                    <i class="heartIcon float-left"><img src="{{asset('assets_front/images/icons/watch.svg')}}"></i>
                    <p class="float-left">Offers Due 
                        <span class="d-block">
                         {{ @$propertyOffer->date_end ? date('m-d-Y', strtotime(@$propertyOffer->date_end)).",". date('g:i A', strtotime(@$propertyOffer->time_end))  : "" }}
                     </span>
                 </p>
             </div>
         </div>
         @endif
        
         <div class="col-md-6">
            <div class="ofrDue">
                <i class="heartIcon float-left"><img src="{{asset('assets_front/images/icons/calender.png')}}"></i>
                {{--<p class="float-left">Close of Escrow <span class="d-block" id="close_of_escrow_status" data-property_id="{{@$propertyInfo->id}}">{{@$propertyInfo->escrow_status}}</span>
                    Est. COE<span class="d-block">
                       {{ @$propertyInfo->emd_coe ? date('m-d-Y', strtotime(@$propertyInfo->emd_coe))  : "" }}</span></p> --}} 

                       <p class="float-left"> Est. COE <span class="d-block"> {{ @$propertyInfo->emd_coe ? date('m-d-Y', strtotime(@$propertyInfo->emd_coe))  : "" }}</span></p>

                   </div>
               </div>
              
           </div>

           <div class="row">
            <div class="col-md-12 pt-1">
                <button href="#" class="btn btn-primary myBids w-100 mt-3" id="seeMyBidButton" data-toggle="modal" data-target="#mybid" data-bidpriceval="" @if(!@$mybid) style="display: none" @endif>See My Bid</button>
            </div>
        </div>

    </div>

    <div class="col-md-5">
        @if(@$adminInfo->count()>0)
        <div class="userProfile">
            <i class="user d-inline-block w-100 text-center"><img src="{{$adminInfo->profile_pic}}"></i>
            <p class="px-3">Questions? Connect with your dedicated Investor Advisor.</p>
            <ul>
                @if(@$adminInfo->name !="")
                <li class="px-3">
                    <span class="fst">Name</span>
                    <span class="lst">{{@$adminInfo->name}}</span>  
                </li>
                @endif
                @if(@$adminInfo->email !="")
                <li class="px-3">
                    <span class="fst">Email</span>
                    <span class="lst">{{@$adminInfo->email}}</span>
                </li>
                @endif
                @if(@$adminInfo->mobile_no !="")
                <li class="px-3">
                    <span class="fst">Phone</span>
                    <span class="lst">
                    @php $mobile_num=getMobileFormat(@$adminInfo->mobile_no);@endphp
                    {{@$mobile_num}}</span>
                </li>
                @endif
            </ul>
        </div>
        @endif
        @if(@$document->count()>0)
        <div class="docs">
            <ul>
                @foreach(@$document as $k=>$li)
                <li>
                    <a href="{{@$li->attachment}}" target="_blank"><i><img src="/assets_front/images/icons/disclosures.svg"></i>
                        <span>{{$li->name}}</span></a>
                    </li>
                    {{--<li>
                        <a href=""><i><img src="{{asset('assets_front/images/icons/prelim.svg')}}"></i>
                            <span>Prelim Title</span></a>
                        </li>
                        <li>
                            <a href=""><i><img src="{{asset('assets_front/images/icons/report.png')}}"></i>
                                <span>Report</span></a>
                            </li>
                            <li>
                                <a href=""><i><img src="{{asset('assets_front/images/icons/solar.svg')}}"></i>
                                    <span>Solar Contract</span></a>
                                </li>--}}
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                @if(@$propertyInfo->description!="")
                <div class="row">
                    <div class="col-md-12">
                        <div id="isOver" class="overView">
                            <h2>Overview</h2>
                            {!! @$propertyInfo->description !!}
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div  @if(@$video->attachment!="") class="col-md-6" @else class="col-md-12" @endif>
                        <div class="seeMap">
                            <h2><a href="https://www.google.com/maps/search/?api=1&query={{@$propertyInfo->latitude}},{{@$propertyInfo->longitude}}" target="_blank">See on Map</a></h2>
                            <div class="map-main">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>

                    @if(@$video->attachment!="")
                    <div class="col-md-6">
                        <div class="seeVideo">
                            <h2><a href="{{route('buyer-property-video-gallery',@$propertyInfo->id)}}">Video or 3D Tour</a></h2>
                            <video style="width:100%; height:310px;" controls loop="true"  autostart="false">
                                <source src="{{@$video->attachment}}" type="video/mp4">
                                </video>                        
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
                <!-- MYBID -->
                <div class="modal fade mybid" id="mybid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">          
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="{{asset('assets_front/images/icons/close.svg')}}" class="img-fluid" />
                        </button>          
                        <div class="modal-body p-0">
                            <div class="mybid_modal d-flex">
                                <div class="imgarea">
                                    <img src="{{$propertyInfo->image}}" class="img-fluid h-100" />
                                </div>
                                <div class="contArea">
                                    <div class="head">
                                        <h2>

                                        {{@$price}}</h2>
                                        <p>{{@$propertyInfo->location}}</p>                            
                                    </div>
                                    <div class="amount d-flex justify-content-between">
                                        <div class="box1">
                                            <h4>EMD Amount</h4>
                                            <p> {{ @$propertyInfo->emd_amount ? moneyFormat(@$propertyInfo->emd_amount) : "" }}</p>
                                        </div>
                                        <div class="box1">
                                            <h4>EMD Due</h4>
                                            <p>   {{ @$propertyInfo->emd_due ? @$propertyInfo->emd_due : "" }}
                                            </p>
                                        </div>
                                        <div class="box1">
                                            <h4>Est. COE</h4>
                                            <p> {{ @$propertyInfo->emd_coe ? date('m-d-Y', strtotime(@$propertyInfo->emd_coe)) : "" }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ofrAra d-flex align-items-center justify-content-between px-3 priceDIv">
                                        <p class="bidPriceP">Your Offer</p>
                                        @php $bid_price=moneyFormat(@$mybid->bid_price); @endphp

                                        <p class="bidPriceLabel">{{@$bid_price}}</p>



                                        <input 
                                        type="text" 
                                        placeholder="Enter Bid Price" 
                                        style="display: none" 
                                        maxlength="12" 
                                        name="bid_price" 
                                        class="inputTextBidPrice autonumber form-control" data-a-sign="$"  data-v-min="0" data-v-max="999999999999">
                                       
                                    </div>
                                     <span class="show_error_message"></span>
                                    @if(@$propertyOffer && (@$mybid->bid_status == "Active" || @$mybid->bid_status == "Rejected"))
                                    @if($propertyInfo->escrow_status=="Active")
                                    <small class="d-block mt-2 text-right pr-3">
                                        <button class="text-primary text-decoration-underline cursor-pointer border-0 bg-transparent changeBidPricebtn"><u>Change Offer</u></button>
                                    </small>  
                                    <div class="px-3"  id="updateBidPriceModalBtn">
                                        <button class="btn btn-primary myBids d-block mt-2 w-100 saveBidPricebtn" type="button" data-id="{{@$mybid->id}}">Submit Offer</button>
                                    </div>
                                    @endif

                                    @endif   
                                </div>
                            </div>
                        </div>          
                    </div>
                </div>
            </div>

        <!--MY OFFER BEFORE PLACED BID MODAL -->
        <!-- -->
        <div class="modal hide fade" style="z-index: 10000000 !important;" id="terms_popup_model" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-side modal-bottom-right modal-notify modal-info  modal-lg" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading font-weight-bold">Terms and Conditions</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body" id="tc_content">
                      {!! @$terms_conditions->page_description !!} 
                  </div>
              </div>
          </div>
      </div>

      <!--/.Content-->

      <!-- --> 
      <!-- -->
<div class="modal hide fade" id="BidOfferPopUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-side modal-bottom-right modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <p class="heading font-weight-bold">Place Offer</p>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
          </button>
      </div>

      <!--Body-->
      <div class="modal-body">

        <div class="row">
          <div class="col-md-4">
             <img src="{{$propertyInfo->image}}" class="img-fluid img-thumbnail mb-3 img-100"  class="img-fluid" alt="Property Image" width="150px" height="150px">
         </div>
         <div class="col-md-8">
            <h3>{{moneyFormat($propertyInfo->base_price)}}</h3>
            <p class="nowrap-none">{{$propertyInfo->location}}</p>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">     
        <p class="font-weight-normal">Offer Amount</p>
        <div class="offer_popup_bid_price_value">
            <input type="text" class="autonumber form-control bg_light" data-a-sign="$"  data-v-min="0" data-v-max="999999999999" name="bid_price" id="offer_popup_bid_price_input_value">
        </div>
        <div class="er_message" style="display: none"></div>
        </div>
    </div>
    <hr>
    <div class="row mb-2">
        <div class="col-md-4 font-weight-normal textleft">EMD Amount</div>
        <div class="col-md-4 textright">{{ @$propertyInfo->emd_amount ? moneyFormat(@$propertyInfo->emd_amount) : "" }}</div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4 font-weight-normal textleft">EMD&nbsp;Amount&nbsp;Due</div>
        <div class="col-md-8 textright text_nowrap">{{ @$propertyInfo->emd_due ? @$propertyInfo->emd_due : "" }}</div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4 font-weight-normal textleft">Estimated COE</div>
        <div class="col-md-4 textright">{{ @$propertyInfo->emd_coe ? date('m-d-Y', strtotime(@$propertyInfo->emd_coe)) : "" }}</div>
    </div> 
    <hr>
    <div class="row mb-2">
        <div class="col-md-12">

        </div>
    </div>

    <input type="checkbox" name="check_terms" id="check_terms" value="terms_checked"> 
    <span class="checkTerm">Check here to indicate that you have read and agree to the 
        <span class="TndC" data-toggle="modal" href="#terms_popup_model">terms and conditions</span>.
    </span>
    <div class="er_message_terms text-danger" style="display: none">Please select terms and conditions.</div>

    </div>
    <button type="button" class="btn infoButton" id="submit_add_bid_popup"  data-property_id="{{@$propertyInfo->id}}" data-offer_id="{{@$propertyOffer->id}}">Submit Offer</button>
    </div>
    </div>
</div>

<!--/.Content-->

<!-- -->
<!-- GALLERY MODEL -->
<div class="pertyBox modal fade" id="Lightbox" role="dialog">
    <div class="modal-dialog modal-dialog-centered">        
        <div class="modal-content">
            <span class="close pointer" onclick="closeLightbox()">
                <img src="https://realestate.ezxdemo.com/assets_front/images/icons/close.svg" class="img-fluid">
            </span>
            @foreach(@$allgalleryList as $k=>$gli)
            <div class="slide" id="image-{{$k}}">
                <img class="thumbnail img-responsive" class="image-slide" src="{{$gli->attachment}}">
            </div>
            @endforeach
            <a class="previous" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
 function moneyFormat(num){
  var price=parseFloat(num);
  return price.toLocaleString('en-US');
}

    let slideIndex = 1;
    showSlide(slideIndex);
    function openLightbox() {
      document.getElementById('Lightbox').style.display = 'block';  
      document.getElementById('Lightbox').style.opacity = '1';    
  };    
  function closeLightbox() {
      document.getElementById('Lightbox').style.display = 'none';  
  };    
  function changeSlide(n) {
      showSlide(slideIndex += n);  
  };    
  function toSlide(n) {
      showSlide(slideIndex = n);
  };

  function showSlide(n) {
      const slides = document.getElementsByClassName('slide');
  //let modalPreviews = document.getElementsByClassName('modal-preview');
  if (n > slides.length) {
    slideIndex = 1;    
};

if (n < 1) {
    slideIndex = slides.length;    
};    
for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
    $(slides[i]).fadeOut("fast");
};      
  // for (let i = 0; i < modalPreviews.length; i++) {
  //   modalPreviews[i].className = modalPreviews[i].className.replace('active', '');
  // };
  $(slides[slideIndex - 1]).fadeIn("slow");
  slides[slideIndex - 1].style.display = 'block';
  //modalPreviews[slideIndex - 1].className += 'active';  
};

$('#seeMyBidButton').on('click', function() {
    $(".inputTextBidPrice").hide();
    $(".bidPriceLabel").show();
    $(".changeBidPricebtn").show();
    $(".saveBidPricebtn").hide();
    $(".bidPriceP").show();
    $(".show_error_message").html("");
    $(".priceDIv").removeClass('mtSpace');
});

</script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    var geocoder;
    var map;
    var address = "{{$propertyInfo->location}}";
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: {lat: -34.397, lng: 150.644}
      });
        geocoder = new google.maps.Geocoder();
        codeAddress(geocoder, map);
    }
    function codeAddress(geocoder, map) {
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === 'OK') {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
              });
            } else {
               // alert('Geocode was not successful for the following reason: ' + status);
           }
       });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap"></script>
<script type="text/javascript">

    $(".changeBidPricebtn").click(function(){
        $(".inputTextBidPrice").val("");
        $(".inputTextBidPrice").show();
        $(".bidPriceLabel").hide();
        $(".bidPriceP").hide();
        $(".changeBidPricebtn").hide();
        $(".saveBidPricebtn").show();
        $(".updateBidPriceModalBtn").show();
        $('.saveBidPricebtn').attr('enabled',true);
        $('.saveBidPricebtn').attr('disabled',false);



        $(".priceDIv").addClass("mtSpace");
    });

    var url="{{route('buyer-bid-price-update')}}";

    $(".saveBidPricebtn").click(function() {

        var bid_price =  $(this).parent().siblings('.priceDIv').find('.inputTextBidPrice').val();
        var bid_price_length =   $(this).parent().siblings('.priceDIv').find('.inputTextBidPrice').val().length;

        var bid_id = $(this).data('id');
        if(bid_price_length != 0){
           $('.saveBidPricebtn').attr('disabled',false);
           $('.inputTextBidPrice').removeClass('error_input');
           $.ajax({
            type: "POST",
            url: url,
            data: {_token: "{{ csrf_token() }}",bid_price:bid_price,bid_id:bid_id},
            dataType: "json",
            context:this,
            beforeSend: function(){


                $("#loading").show();
                $('.saveBidPricebtn').attr('disabled',true);
                $(".updateBidPriceModalBtn").hide();
                $('.saveBidPricebtn').text("Saving...");


         },
         success: function (data){

            toastr.options =
            {
                "closeButton" : false,
                "progressBar" : false,
                "showDuration": "3000",
                "hideDuration": "3000",
                "timeOut": "3000"

            }
            if(data.status=="Awarded"){
                $(".inputTextBidPrice").hide();
                $(".bidPriceLabel").show();
                $(".changeBidPricebtn").show();
                $(".saveBidPricebtn").hide();
                $(".bidPriceP").show();
                $(".priceDIv").removeClass('mtSpace');
                toastr.error("Awarded bid price cannot update.");
            } else if(data.status=="Blocked"){
                $(".inputTextBidPrice").hide();
                $(".bidPriceLabel").show();
                $(".changeBidPricebtn").show();
                $(".saveBidPricebtn").hide();
                $(".bidPriceP").show();
                $(".priceDIv").removeClass('mtSpace');
                toastr.error("Your bid has been blocked. you cannot place bid on this property.");

            }else if(data.status=="Closed"){
                $(".inputTextBidPrice").hide();
                $(".bidPriceLabel").show();
                $(".changeBidPricebtn").show();
                $(".saveBidPricebtn").hide();
                $(".bidPriceP").show();
                $(".priceDIv").removeClass('mtSpace');
                toastr.error("Closed bid price cannot update.");

            }else if(data.status=="success"){

                $(".inputTextBidPrice").hide();
                $(".bidPriceLabel").show();
                $(".changeBidPricebtn").show();
                $(".saveBidPricebtn").hide();
                $(".bidPriceLabel").text(bid_price);
                $(".bidPriceP").show();
                $(".priceDIv").removeClass('mtSpace');
                toastr.success("Bid Price updated successfully");

            }else if(data.status=="error_sold"){

            $(".inputTextBidPrice").hide();
            $(".bidPriceLabel").show();
            $(".changeBidPricebtn").show();
            $(".saveBidPricebtn").hide();
            $(".bidPriceP").show();
            $(".priceDIv").removeClass('mtSpace');
            toastr.error("Cannot place bid on it.");
            $('.show_error_message').html("Cannot place bid on it.");
            $('.show_error_message').addClass('text-danger');
            $('.priceDIv').removeClass('mtSpace');
         }
         else{
            toastr.error(data.message); 
            $('.show_error_message').html(data.message);
            $('.show_error_message').addClass('text-danger');
            $('.priceDIv').removeClass('mtSpace');
        }

    },
    complete: function(){
        $(".updateBidPriceModalBtn").show();
        $('.saveBidPricebtn').attr('disabled',false);
        $('.saveBidPricebtn').text("Submit Offer");

        $("#loading").hide();

   }
})
       }else{
        $('.inputTextBidPrice').addClass('error_input');
       // $('.saveBidPricebtn').attr('disabled',true);

   }
});

    $('.inputTextBidPrice').focus(function() {
     $(this).closest('.rightPrice').find('.inputTextBidPrice').removeClass('error_input'); 
       $('.show_error_message').html('');   
 });





    function convertDateForIos(date) {
        var arr = date.split(/[- :]/);
        date = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
        return date;
    }

function changeTimezone(date, ianatz) {
  var invdate = new Date(date.toLocaleString('en-US', {
    timeZone: ianatz
  }));
  var diff = date.getTime() - invdate.getTime();
  
  return new Date(date.getTime() - diff); 
}

$( document ).ready(function() {
    var date = $("#defaultCountdown").data("enddate");
    var time = $("#defaultCountdown").data("endtime");
    var property_id= $("#close_of_escrow_status").data('property_id');

    if(date!=""  && time !=""){

    // dios=convertDateForIos(date+' '+time);
    //alert(dios);

    // var d = new Date(date+' '+time);
    var here=new Date();
    var current_time = changeTimezone(here, "America/New_York");

   
    var dateSplit = date.split("-");
    var timeSplit = time.split(":");

    var d = new Date(dateSplit[0], parseInt(dateSplit[1], 10) - 1, dateSplit[2],timeSplit[0],timeSplit[1]);
    //var d = changeTimezone(there, "America/New_York");
        //var time_instance = new Date(timeSplit[0], timeSplit[1]);
    //value = new Date('2010-06-21'.replace(/-/g, "/"));


// console.log("current time "+current_time);
// console.log("end_time "+d);
// console.log("current time "+Date.parse(current_time));
// console.log("end_time "+Date.parse(d));

    if(Date.parse(current_time) > Date.parse(d)){
         $('.offermessage').html('<b class="text-primary lh-normal">Offer Time <br>has Expired.</b>');
         $('#submitBidPrice').addClass('hidden');
         $('#submitBidPrice').attr('disabled',true);
         $('#submitBidPrice').css("opacity", "1");

         $('.pending').show();
        var property_id= $("#close_of_escrow_status").data('property_id');
        //  $.ajax({
        //     type: "POST",
        //     url: '{{-- {{route("buyer-set-close-of-escrow-status-pending")}} --}}',
        //     data: {_token: "{{ csrf_token() }}",property_id:property_id,escrow_status:"Pending"},
        //     dataType: "json",
        //     context:this,
        //     beforeSend: function(){
        //       $("#loading").show();
        //     },
        //     success: function (response){
        //         if(response.status=="success"){
        //             $("#close_of_escrow_status").text("Pending");
        //         }
        //     },
        //     complete: function(){
        //         $("#loading").hide();
        //     }
        // })
    }else{
        $('#submitBidPrice').prop("disabled", false);

        $('.offermessage').html('<b class="offermessage">Offers Due in </b>');
        // $.ajax({
        //     type: "POST",
        //     url: '{{route("buyer-set-close-of-escrow-status-pending")}}',
        //     data: {_token: "{{ csrf_token() }}",property_id:property_id,escrow_status:"Active"},
        //     dataType: "json",
        //     context:this,
        //     beforeSend: function(){
        //       $("#loading").show();
        //     },
        //     success: function (response){
        //         if(response.status=="success"){
        //         $("#close_of_escrow_status").text("Active");
        //         } 
        //     },
        //     complete: function(){
        //         $("#loading").hide();
        //     }
        // })
    }
    var month=d.getMonth() + 1; // Month    [mm]    (1 - 12)
    var date= d.getDate();      // Day      [dd]    (1 - 31)
    var year=d.getFullYear();   // Year     [yyyy]
    $('#defaultCountdown').countdown({until: d});  

}

document.getElementById('isOver').focus();
});

// $( document ).ready(function() {
//     var date = $("#defaultCountdown").data("enddate");
//     var time = $("#defaultCountdown").data("endtime");
//     var property_id= $("#close_of_escrow_status").data('property_id');
//     if(date!=""  && time !=""){

//     var d = new Date(date+' '+time);
//     var current_time=new Date();




//     if(Date.parse(current_time) > Date.parse(d)){
//        $('.offermessage').html('<b class="text-primary lh-normal">Offer Time <br>has Expired.</b>');
//        $('#submitBidPrice').addClass('hidden');
//        $('.pending').show();

//         $.ajax({
//         type: "POST",
//         url: '{{route("buyer-set-close-of-escrow-status-pending")}}',
//         data: {_token: "{{ csrf_token() }}",property_id:property_id,escrow_status:"Pending"},
//         dataType: "json",
//         context:this,
//         beforeSend: function(){
//           $("#loading").show();
//         },
//         success: function (response){
//             if(response.status=="success"){
//                 $("#close_of_escrow_status").text("Pending");
//             }
//         },
//         complete: function(){
//             $("#loading").hide();
//         }
//       })



//     }else{
//         $('.offermessage').html('<b class="offermessage">Offers Due in </b>');
//         $.ajax({
//         type: "POST",
//         url: '{{route("buyer-set-close-of-escrow-status-pending")}}',
//         data: {_token: "{{ csrf_token() }}",property_id:property_id,escrow_status:"Active"},
//         dataType: "json",
//         context:this,
//         beforeSend: function(){
//           $("#loading").show();
//         },
//         success: function (response){
//             if(response.status=="success"){
//                  $("#close_of_escrow_status").text("Active");
//             } 
//         },
//         complete: function(){
//             $("#loading").hide();
//         }
//       })

//     }
//     var month=d.getMonth() + 1; // Month    [mm]    (1 - 12)
//     var date= d.getDate();      // Day      [dd]    (1 - 31)
//     var year=d.getFullYear();   // Year     [yyyy]
//     $('#defaultCountdown').countdown({until: d});  

//     }

//     document.getElementById('isOver').focus();
// });


$("#check_terms").change(function() {
    if(this.checked) {
        $('.er_message_terms').hide(); 

    }
});

$('#offer_popup_bid_price_input_value').keyup(function() { 
    $('.er_message').html("");
    var price_bidd=$(this).val();
    $("#submit_add_bid_popup").removeAttr("disabled");
    $("#inputTextBidPriceSave").val(price_bidd);
});

//SAVE BID OFFER
var urlSave="{{route('buyer-bid-price-save')}}";
$("#submit_add_bid_popup").click(function() {


   $('.er_message_terms').hide(); 
   var bid_price =$("#offer_popup_bid_price_input_value").val();
   var propertyID = $(this).data('property_id');
   var offerID = $(this).data('offer_id');
   if ($('#check_terms').is(':checked')) {
       $('.er_message_terms').hide(); 
       $.ajax({
          type: "POST",
          url: urlSave,
          data: {_token: "{{ csrf_token() }}",bid_price:bid_price,property_id:propertyID,offer_id:offerID},
          dataType: "json",
          beforeSend: function(){
            $("#loading").show();
            $("#submit_add_bid_popup").text("Offer Saving...");
            $("#submit_add_bid_popup").attr('disabled','true');

            $(".updateBidPriceModalBtn").hide();

        },
        success: function (data){
            console.log(data.status);
            if(data.status == "bid_found"){
                toastr.options =
                {
                    "closeButton" : false,
                    "progressBar" : false,
                    "showDuration": "2000",
                    "hideDuration": "2000",
                    "timeOut": "2000",
                }
                toastr.error("Bid already added for this property offer");
                $('.er_message').html('<span class="text-danger">You have already placed a bid on this property</span>');
                $('.er_message').show();
                $("#submit_add_bid_popup").text("Offer Not Saved");
                $("#submit_add_bid_popup").attr('disabled','true');

            }else if(data.status == "error"){
              toastr.options =
              {
                "closeButton" : false,
                "progressBar" : false,
                "showDuration": "2000",
                "hideDuration": "2000",
                "timeOut": "2000",
            }
            toastr.error(data.result);
            $('.er_message').html('<span class="text-primary">'+data.result+'</span>');
            $('.er_message').show();

            $("#submit_add_bid_popup").text("Submit Offer");
            $("#submit_add_bid_popup").attr('disabled','true');


        }
        else{

            $('#seeMyBidButton').css('display','block');
            $('.inputTextBidPriceSave').val("");
            $('.bidPriceLabel').text(bid_price);
            $('.saveBidPricebtn').attr('data-id',data.result.id);


            $('.er_message').html('<p class="text-primary">your bid for '+moneyFormat(data.result.bid_price)+' has submitted successfully</p>');
            $('.er_message').show(); 
            toastr.options =
            {
                "closeButton" : false,
                "progressBar" : false,
                "showDuration": "2000",
                "hideDuration": "2000",
                "timeOut": "2000"
            }

            toastr.success('your bid for $'+moneyFormat(data.result.bid_price)+' has submitted successfully');
            $("#submit_add_bid_popup").text("Offer Saved");
            $("#submit_add_bid_popup").prop('disabled','false');
            $('#BidOfferPopUp').modal("hide"); 
             setTimeout(function() 
              {
                location.reload();  //Refresh page
              }, 2000);




        }

    },   
    complete: function(){
        $("#loading").hide();


              // $(".updateBidPriceModalBtn").show();
          }      
      })
   }else{
    $('.er_message_terms').show(); 
}

});



var urlExistBid="{{route('buyer-check-bid-exist')}}";
$("#submitBidPrice").click(function() {
 $("#submit_add_bid_popup").prop("disabled", false);
 $('.er_message').html(''); 
 var bid_price=$(".inputTextBidPriceSave").val();
     //$("#BidOfferPopUp #wall-post").val($("#linkURL").val());
    //$(".offer_popup_bid_price_value").html(bid_price);
    $("#offer_popup_bid_price_input_value").val(bid_price);
    //inputTextBidPrice
    var propertyID = $(this).data('property_id');
    var offerID = $(this).data('offer_id');
    if(offerID != ""){
        if(bid_price != ""){

            $.ajax({
              type: "POST",
              url: urlExistBid,
              data: {_token: "{{ csrf_token() }}",bid_price:bid_price,property_id:propertyID,offer_id:offerID},
              dataType: "json",
              beforeSend: function(){
                $("#loading").show();


            },
            success: function (data){
                console.log(data.status);
                if(data.status == "bid_found"){
                    toastr.options =
                    {
                        "closeButton" : false,
                        "progressBar" : false,
                        "showDuration": "2000",
                        "hideDuration": "2000",
                        "timeOut": "2000",
                    }
                    toastr.error("Bid already added for this property offer");
                    $('.er_message').html('You have already placed a bid on this property');
                    $('.er_message').show();
                }else if(data.status == "property_sold"){
                    toastr.options =
                    {
                        "closeButton" : false,
                        "progressBar" : false,
                        "showDuration": "2000",
                        "hideDuration": "2000",
                        "timeOut": "2000",
                    }
                    toastr.error("Property Sold");
                    $('.er_message').html('Property Sold');
                    $('.er_message').show();
                }
                else if(data.status == "property_removed"){
                    toastr.options =
                    {
                        "closeButton" : false,
                        "progressBar" : false,
                        "showDuration": "2000",
                        "hideDuration": "2000",
                        "timeOut": "2000",
                    }
                    toastr.error("Property Removed By Offercity");
                    $('.er_message').html('Property Removed By Offercity');
                    $('.er_message').show();
                }
                else if(data.status == "property_deactivated"){
                    toastr.options =
                    {
                        "closeButton" : false,
                        "progressBar" : false,
                        "showDuration": "2000",
                        "hideDuration": "2000",
                        "timeOut": "2000",
                    }
                    toastr.error("Property deactivated by offercity");
                    $('.er_message').html('Property deactivated by offercity');
                    $('.er_message').show();
                }
                else {
                  $('#BidOfferPopUp').modal("toggle"); 
              }


          },   
          complete: function(){
            $("#loading").hide();
                  // $(".updateBidPriceModalBtn").show();
              }      
          })
        }else{
            $('#seeMyBidButton').css('display','block');
            $('.inputTextBidPriceSave').val("");
            $('.er_message').show();
            $('.er_message').html('Enter your offer Amount'); 
        }

    }else{
       toastr.options =
       {
        "closeButton" : false,
        "progressBar" : false,
        "showDuration": "2000",
        "hideDuration": "2000",
        "timeOut": "2000"

    }
    toastr.error("No offers available for this property now. contact admin for more details");  
    $('.er_message').html('No offers available for this property now. contact admin for more details');
    $('.er_message').show();
}

});


$("#favPropertyCheckBox").change(function(){
           //var value = $(this).val();
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
         data: {property_id:property_id,fav_id:fav_id,status:status,_token: "{{ csrf_token() }}"}, 
         beforeSend: function(){
            $("#loading").show();
        },
        success: function(msg){
            if(msg.status =='success'){
                if(msg.result!=""){

                    $('#favPropertyCheckBox').attr('data-favid',msg.result);

                }
                toastr.options =
                {
                    "closeButton" : false,
                    "progressBar" : false,
                    "showDuration": "2000",
                    "hideDuration": "2000",
                    "timeOut": "2000"

                }
                toastr.success("Property "+str+" Favorite property");
            } 
            else{

              toastr.error("Something went wrong");
          }
      },
      complete: function(){
        $("#loading").hide();
    }
}); 
    }); 


</script>
@endsection
