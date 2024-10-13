<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Offer City-Search Property</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  @php $favicon=getFavicon(); @endphp
  <!-- Favicon icon -->
  <link rel="icon" href="{{asset('storage'.$favicon)}}" type="image/x-icon">
  @include('buyer::includes.css')
  <link href="{{ asset('assets_front/popup/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('assets_front/popup/css/responsive.css')}}" rel="stylesheet">
  <style type="text/css">
    #map {
      position: static !important;
    }
  </style>
  @toastr_css  
</head>
<body>

<div id="loaderDiv" style="background-color:#0405067a;  position:fixed;z-index:99999999;top: 0px;left: 0px;height:100%;width:100%;">
  <img src="{{asset('assets_admin/loader.gif')}}" style="height: 125px;">
</div>

@php $pic=getProfilePic(); @endphp

  <div class="wrapper h-100 overflow-hidden">
      <div class="container-fluid h-100 mx-0">
          <div class="row h-100">

                <div class="" id="toggler"><i><img class="mt-2" src="{{asset('assets_front/images/icons/aroRight.svg')}}" width="15" /></i>
                </div>
                <div class="leftSearch" id="contentDIV">

                  <div class="col-md-12 resultSearchPropertyMainDiv bg-white">
                    <div class="headBar row">
                      <div class="col-md-6">
                         <a href="{{route('buyer-search-property')}}"><img class="mt-2" src="{{asset('storage'.getLogo())}}" width="148" /></a>
                      </div>
                      <div class="col-md-6 text-right mt-2">
                        <a href="#" class="userCricle text-center text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{@$pic}}" class="userCricle"></a>
                        <div class="dropdown-menu dropdown-menu-right">
                          <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('buyer-profile')}}">My Profile</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{route('buyer-search-property')}}">Marketplace</a></li>
                            
                                <li class="nav-item">
                                  <a class="nav-link" href="{{route('buyer-faq-page')}}">FAQ’s</a>
                                </li>
                           
                            <li class="nav-item"><a class="nav-link" href="{{route('buyer-contact-us')}}">Contact Us</a></li>
                             
                            @auth
                            <li class="nav-item">
                               <a class="nav-link logoutBtnA" href="{{ route('buyer_logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       <i class="feather icon-log-out"></i>  {{ __('Logout') }}
                 
                                    <form id="logout-form" action="{{ route('buyer_logout') }}" method="POST" class="d-none"> @csrf </form>
                              </a>
                            </li>
                            @else
                            @endif
                          </ul>
                        </div>
                      </div>
                    </div>
                   
                    <div class="row filterBar justify-content-between">
                  	  	
                      	<p class="m-0 results text-dark countResult"> </p>
                      
                      <div class="ftr" id="sortPropertyOrder">
                        <label class="float-left fltText">Filter</label>    
                        <select class="form-control form-control-lg sortProperty" name="sort_property" >
                          <option value="ASC">Low to High</option>
                          <option value="DESC">High to Low</option>
                        </select>
                      </div>
                    </div>
                     <div class="no_property" style="display: none"><img src="{{asset('no_image/no-property.svg')}}"></div>
                    <ul id="scroll" class="p-search-list searchResultList"></ul>
                  </div>
                </div>
                <div id="mapDIV" class="col px-0 position-relative colfull leftspace">
                 {{--<div class="img-full">--}}
                     <div id="map"></div>
                  {{--</div>--}}
                  <div class="dd_section">
                      <div class="dropdown float-left">
                         <div class="search-div-location" style="display: none;">
                         <input type="text" id="pac-input" class="from-control" >
                         <label class="close-input-location"><i class="fa fa-times"></i></label>
                         </div>
                        <button class="btn transparent dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Select City
                        </button>
                        
                        <div class="dropdown-menu scrollBar statecitylistbox" aria-labelledby="dropdownMenuButton" onclick="event.stopPropagation();">
                        {{-- @foreach($stateList as $key=>$sli)
                          <h2>{{$sli->getPropertyState->name}}</h2>
                        @php $cityList=getPropertyCityList($sli->state) @endphp
                          @foreach($cityList as $key=>$cli)
                          <div class="custom-control custom-checkbox citycheckbox">
                            <input type="checkbox" class="custom-control-input citycheckinput" data-city_id="{{$cli->city}}" data-cityname="{{$cli->getPropertyCity->name}}" id="check{{$sli->state}}{{$cli->city}}">
                            <label class="custom-control-label" for="check{{$sli->state}}{{$cli->city}}">{{$cli->getPropertyCity->name}} </label>
                          </div>
                          @endforeach
                           
                        @endforeach --}}
                        @foreach($stateList as $key=>$sli)
                          <h2>{{$sli->stateName}}</h2>
                        @php $cityList=getPropertyCityList($sli->stateID) @endphp
                       
                          @foreach($cityList as $key=>$cli)
                            @if($cli->city==$sli->cityID)
                              <div class="custom-control custom-checkbox citycheckbox">
                              <input type="checkbox" class="custom-control-input citycheckinput" data-city_id="{{$cli->city}}" data-cityname="{{$cli->getPropertyCity->name}}" id="check{{$sli->stateID}}{{$cli->city}}">
                              <label class="custom-control-label" for="check{{$sli->stateID}}{{$cli->city}}">{{$cli->getPropertyCity->name}} ({{$sli->count_property}})</label>
                            </div>
                            @endif
                          
                          @endforeach
                           
                        @endforeach 
                        </div>
                       </div> 
                        <!-- search icon -->
                        <img class="searchIcon float-left" src="{{asset('assets_front/images/icons/search.svg')}}" />
                          
                        <div class="dropdown float-right">
                        <!-- active dropdown -->
                        <button class="btn transparent dropdown-toggle toggleBTN SelectedStatusBtn" type="button" id="dropdownMenuLink" 
                          data-toggle="dropdown" 
                          aria-haspopup="true" 
                          aria-expanded="false">Active</button>
                        <div class="dropdown-menu dropdown-small checkPropertyStatusDiv" aria-labelledby="dropdownMenuLink" onclick="event.stopPropagation();">
                            <div class="custom-control custom-checkbox statuscheckbox">
                              <input type="checkbox" class="custom-control-input checkboxPropertyStatus" data-status="Active" id="activeProperty">
                              <label class="custom-control-label" for="activeProperty">Active</label>
                            </div>
                            <div class="custom-control custom-checkbox statuscheckbox">
                              <input type="checkbox" class="custom-control-input checkboxPropertyStatus" data-status="Pending" id="pendingProperty">
                              <label class="custom-control-label" for="pendingProperty">Pending</label>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>        
  </div>
 <div class="popup-model modal fade" data-backdrop="static" data-keyboard="false" id="popupIntrestedCity" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="hart-img">
          <img src="{{asset('assets_front/images/brand-logo/logo.png')}}" alt="Offercity">
        </div>
        <h2>OOPS!</h2>
        <p>No Properties Available According to Your Interested Cities. </p>
        <p>You Can See Some Other Properties By Check City From Dropdown.</p>
      </div>
      <div class="modal-btn">
        <button type="button" class="btn-block popup_close_btn" data-dismiss="modal">Click to Continue...</button>
      </div>
    </div>
  </div>
</div>

@include('buyer::includes.script')
@toastr_js
@toastr_render
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{env('GOOGLE_API_KEY')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/jquery.nicescroll.min.js')}}"></script>
<script> 

// function thousep2(num) {
//   var n=parseFloat(num);
//     if(typeof n === 'number'){
//         n += '';
//         var x = n.split('.');
//         var x1 = x[0];
//         var x2 = x.length > 1 ? '.' + x[1] : '';
//         var rgx = /(\d+)(\d{3})/;
//         while (rgx.test(x1)) {
//             x1 = x1.replace(rgx, '$1' + ',' + '$2');
//         }
//         return x1 + x2;
//     } else {
//         return n;
//     }
// }


$('.popup_close_btn').on('click',function(){
  localStorage.setItem('interested_city_status',1);
});
//ON PAGE LOAD MAP AND PROPERTY SHOW
var statusChecked="";

$(document).ready(function() {
  var k= localStorage.getItem('interested_city_status');
  if(k=='1'){
    $("#popupIntrestedCity").modal('hide');
  }else{
    $.ajax({
      type: "POST",
      url: "{{route('check-intrested-city-property-found')}}",
      dataType: "json",
      data: {_token: "{{ csrf_token() }}"},
      success: function (resp){
        if(resp.status == "not_found"){
            $("#popupIntrestedCity").modal('show');
      }else{
         $("#popupIntrestedCity").modal('hide');
        }
       
      }
    });  
  }
  

   $("#loaderDiv").fadeOut("slow");
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select"
        });



  var toggle  = document.getElementById("toggler");
  var content = document.getElementById("contentDIV");
  var mapDIV = document.getElementById("mapDIV");
  toggle.addEventListener("click", function(){
    content.classList.toggle("appear");
    mapDIV.classList.toggle("leftspace");
    toggle.classList.toggle("tglDIV");
  }, false);

  $("#scroll").niceScroll({
      cursorcolor: "#d3d3d3",
      background: "#ececec",
      cursorwidth: 10,
      horizrailenabled:false,
      cursorborder:"0",
      scrollspeed: '-20',
      cursorborderradius: "0",
      overflowy: true,
      railpadding: { top: 0, right: -25, left: 10, bottom: 0 }
  }).resize();
 
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "2000",
    "hideDuration": "2000",
    "timeOut": "1000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

  var sort_by_key=$('select[name=sort_property] option').filter(':selected').val();
  defaultLoad(sort_by_key);
});


// var lat=37.090240;
// var lng=-95.712891;


var lat=33.980530;
var lng=-117.377022;


var delay = 100;

const USA_BOUNDS = {
  north: 62.2270,
  south: 24.521208,
  west: -124.736342,
  east: -66.945392
};


var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          minZoom: 3,
          maxZoom: 15,
          center: new google.maps.LatLng(lat,lng),
          restriction: {
            latLngBounds: USA_BOUNDS,
            strictBounds: false,
          },
          mapTypeId: google.maps.MapTypeId.ROADMAP});

var markersArray = [];
//ON PAGE LOAD SHOW MAP AND DISPLAY PROPERTY OF LAST INSTERTED CITY FROM TABLE
var image = {
  url:"{{URL::asset('/assets_front/images/icons/map_area.png')}}",
  scaledSize: new google.maps.Size(40,40), // scaled size
};



//create empty LatLngBounds object
var bounds = new google.maps.LatLngBounds();



//CHECK LOCATION INSIDE GIVEN RADIOUS
// function arePointsNear(checkPoint, centerPoint) {
//     var sw = new google.maps.LatLng(centerPoint.lat() - 0.005, centerPoint.lng() - 0.005);
//     var ne = new google.maps.LatLng(centerPoint.lat() + 0.005, centerPoint.lng() + 0.005);
//     var bounds = new google.maps.LatLngBounds(sw, ne);
//     if (bounds.contains (checkPoint)){
//         return true;
//     }
//     return false;
// }

// function getDataByZoom(center_lat,center_long){
//   var city=[];
//   var status=[];
//   $('.countResult').html('');
//   $('.searchResultList').html("");
//   var active_str="";
//   var pending_str="";
//   var statusChecked="";
//   var center_long=parseFloat(center_long);
//   var center_lat=parseFloat(center_lat);
 
//   var sort_by_key = $('select[name=sort_property] option').filter(':selected').val();
//   //GET CHECKED STATUS
//   $(".checkboxPropertyStatus").each(function(){
//     var $this = $(this);
//     if($this.is(":checked")){
//       status.push($this.attr("data-status"));

//       statusChecked=$this.attr("data-status");
//     }
//   });
//   //GET CHECKED CITY
//   $(".citycheckinput").each(function(){
//     var $this = $(this);
//     if($this.is(":checked")){

//       city.push($this.attr("data-city_id"));
//     }
//   });

//   $.ajax({
//     type: "POST",
//     url: "{{route('buyer-get-distance-property')}}",
//     data: {_token: "{{ csrf_token() }}",city_id:city,status:status,sort_by:sort_by_key,center_lat:center_lat,center_long:center_long},
//     dataType: "json",
//     success: function (data){
     
//       if(data.result_count > 0){
//         $('.filterBar').removeClass('no_property_found');
//         $('.no_property').css('display','none');

//         lat=data.mapData[0][0];
//         lng=data.mapData[0][1];
//        //clear markers
//         clearOverlays();
//         //show markers and infowindow
//         markersInfoWindow(data.mapData);
//         //show proprty list sidebar
//         propertyListSidebar(data,statusChecked);
//       }else{
//         $('.countResult').html('');
//         $('.searchResultList').html("");
//         $('.searchResultList').empty();
//         $('#sortPropertyOrder').hide();
//         $('.filterBar').addClass('no_property_found');
//         $('.no_property').css('display','block');
//         //clear markers
//         clearOverlays(); 
//        // markers.setMap(null);
       
//       }
     
//       }
//     });

// }










//CLEAR MARKERS
function clearOverlays() {
  for (var i = 0; i < markersArray.length; i++ ) {
      markersArray[i].setMap(null);
    }
    markersArray = [];
} 
//ADD INFOWINDOW CONTENT FOR EACH MARKER
 var currWindow =false; 
function attachInfoWindow(marker, secretMessage) {
 
  var infowindow = new google.maps.InfoWindow({
    content: secretMessage,
  });

  marker.addListener("click", () => {
     if( currWindow ) {
           currWindow.close();
        }
          currWindow = infowindow;
    currWindow.open(marker.get("map"), marker);
    map.setZoom(12);
    map.setCenter(marker.getPosition());
  });

   // var letCenter="";
   // var lngCenter="";
   google.maps.event.addListener(map, 'click', function() {

   
    // console.log('marker',map.getCenter());
   
    //   letCenter=map.getCenter().lat();
    //   lngCenter=map.getCenter().lng();
      //getDataByZoom(letCenter,lngCenter);
  

    infowindow.close();
  });

}

//DISPLAY INFO into INFOWINDOW
function markersInfoWindow(loc){
  var i;
  for (i = 0; i < loc.length; i++){  
    markers = new google.maps.Marker({
      position: new google.maps.LatLng(loc[i][2], loc[i][1]),
      scaledSize: new google.maps.Size(2,2), // scaled size
      icon: image,
    });

    markersArray.push(markers);
           
    // To remove the marker from the map
    markers.setMap(map);
    //bounds.extend(markers.position);
    //map.fitBounds(bounds);
    //ADD INFOWINDOW ON CLICK MARKER
    var urlm = '{{ route("buyer-property-detail",":slug") }}';
    markerUrl = urlm.replace(':slug', loc[i][9]);

   
    var property_price=loc[i][5];
    var property_size=loc[i][11];

    var built_year="";
    var property_size="";
    var baths="";
    var beds="";
    //BUILT
    if(loc[i][6] !=""){
       built_year ='<div class="col-sm d-flex align-items-center"><i class="heartIcon float-left"><img src="/assets_front/images/icons/home.svg" /></i><p class="float-left">Built <span class="d-block">'+loc[i][6]+'</span></p></div>';

    }
    //PROPERTY SIZE
    if(loc[i][11] !=""){
       property_size='<div class="col-sm d-flex align-items-center"><i class="heartIcon float-left"><img src="/assets_front/images/icons/area.svg" /></i><p class="float-left">Sq. Ft <span class="d-block">'+loc[i][11]+'</span></p></div>';


    }
    if(loc[i][8] !=""){
       baths='<div class="col-sm d-flex align-items-center"><i class="heartIcon float-left"><img src="/assets_front/images/icons/bathroom.svg" /></i><p class="float-left">Bathroom<span class="d-block">'+loc[i][8]+'</span></p></div>';
    }
    if(loc[i][7] !=""){
       beds='<div class="col-sm d-flex align-items-center"><i class="heartIcon float-left"><img src="/assets_front/images/icons/bedroom.svg" /></i><p class="float-left">Bedroom<span class="d-block">'+loc[i][7]+'</span></p></div>';
    }

    var infoWindowData ='<a href="'+markerUrl+'"><div class="card" style="width: 18rem"><img src="'+loc[i][4]+'" class="card-img-top" /><div class="card-body"><p class="m-0">'+loc[i][3]+'</p><span style="cursor: pointer;">See details</span><div class="priceBx"><span class="mainPrice font-weight-bold">'+property_price+'</span></div><div class="row">'+built_year+''+property_size+'</div><div class="row mt-2">'+baths+''+beds+'</div></div></div></a>';

      attachInfoWindow(markers,infoWindowData);       
  }
}


function propertyListSidebar(data,statusChecked){

  var checked='';
  var tooltip='';
  //DISPLAY LEFT SIDEBAR PROPERTY LIST DATA
  $.each(data.result, function(k, v){
    var url = '{{ route("buyer-property-detail", ":slug") }}';
    url = url.replace(':slug', v.slug);

    if(v.fav==1){
      checked='checked="checked"';
    }else{
       checked='';
    }
    
      
    var property_price=moneyFormat(v.base_price);
    var property_size=moneyFormat(v.property_size);
    var year="";
    var baths="";
    var beds="";
    //BUILT
    if(v.year_from !="" && v.year_from !=null){
      year ='<div class="col-sm d-flex align-items-center"><i class="heartIcon float-left"><img src="/assets_front/images/icons/home.svg" /></i> <p class="float-left">Built <span class="d-block">'+v.year_from+'</span></p></div>';

    }
  
    if(v.no_of_bathroom !="" && v.no_of_bathroom !=null){
       baths='<div class="col-sm d-flex align-items-center"> <i class="heartIcon float-left"><img src="/assets_front/images/icons/bathroom.svg" /></i> <p class="float-left">Bathroom <span class="d-block">'+v.no_of_bathroom+'</span></p></div>';
    }
    if(v.no_of_bedroom !="" && v.no_of_bedroom !=null){
       beds='<div class="col-sm d-flex align-items-center"> <i class="heartIcon float-left"><img src="/assets_front/images/icons/bedroom.svg" /></i><p class="float-left">Bedroom <span class="d-block">'+v.no_of_bedroom+'</span></p> </div>';
    }

    $('.searchResultList').append('<li class="d-flex"><div class="imgBox mr-3"><img src="'+v.image+'" /></div><div class="imgDetails w-100"><p class="m-0">'+v.title+'</p><div class="priceBx"> <span class="float-left mainPrice">$'+property_price+'</span><span class="float-right"><i class="search_pro_heart"><input class="form-check-input favPropertyCheckBox" type="checkbox" id="checkboxfav'+k+'" data-propertyid="'+v.id+'" data-favid="'+v.fav_id+'" '+checked+'><label class="form-check-label" for="checkboxfav'+k+'"></label></i><a href="'+url+'" class="seeDetails">See Details</a></span></div><div class="addressBox"><i class="heartIcon" style="position:relative !important"><img src="/assets_front/images/icons/location.svg" /></i> '+v.location+'</div> <div class="accomodation"><div class="row">'+year+'<div class="col-sm d-flex align-items-center"> <i class="heartIcon float-left"><img src="/assets_front/images/icons/area.svg" /></i><p class="float-left">Sq. Ft <span class="d-block">'+property_size+'</span></p></div></div><div class="row mt-2">'+baths+''+beds+'</div></div></div></li>');
 

     });
    // var resultCity=[];
    // if(data.result_city.length > 0){
    // resultCity="in "+data.result_city;
    // }

    if(data.result_count > 1){
        if(data.property_counter.active > 0 && data.property_counter.pending > 0){

          tooltip="Showing Total "+data.result_count+" properties. "+data.property_counter.active+" Active and "+data.property_counter.pending+" pending Property in "+data.result_city;
          
          $('.countResult').html('<span class="fw-bold" title="'+tooltip+'">Showing '+data.result_count+' Property in '+data.result_city+'</span>');
        }
        else{
          if(data.property_counter.active == 0 && data.property_counter.pending > 0){
            tooltip="Showing Total "+data.result_count+" Property. "+data.property_counter.pending+" pending Property in "+data.result_city;
          }
          if(data.property_counter.pending == 0 && data.property_counter.active > 0){
              tooltip="Showing Total "+data.result_count+" Property. "+data.property_counter.active+" Active  Property in "+data.result_city;
          }
          
          $('.countResult').html('<span class="fw-bold" title="'+tooltip+'">Showing '+data.result_count+' properties in '+data.result_city+'</span>');
        }


     
    }else{
        if(data.property_counter.active == 0 && data.property_counter.pending > 0){
          tooltip="Showing "+data.property_counter.pending+" pending Property in "+data.result_city;
        }
        if(data.property_counter.pending == 0 && data.property_counter.active > 0){
          tooltip="Showing "+data.property_counter.active+" Active  Property in "+data.result_city;
        }
          
          
          $('.countResult').html('<span class="fw-bold" title="'+tooltip+'">Showing '+data.result_count+' Property in '+data.result_city+'</span>');
    }
   
  }

function defaultLoad(sort_by_key){
  $.ajax({
    type: "POST",
    url: "{{route('buyer-search-property-result')}}",
    data: {_token: "{{ csrf_token() }}",sort_by:sort_by_key},
    dataType: "json",
    beforeSend: function(){
      $("#loaderDiv").show();
    },
    success: function (data){

      //IF PROPERTY FOUND
      if(data.result_count > 0){
      	$('.filterBar').removeClass('no_property_found');
      	 $('.no_property').css('display','none');
        //SHOW CHECKBOX CHECKED AT FIRST TIME BY INTRESTED CITY SELECTED
        $.each(data.result_city, function (index, value) {
          $('.citycheckinput:input:checkbox').each(function() {
        if(value==$(this).data('cityname'))
           this.checked = true; });
          //$('input[name="test"][value="' + value.toString() + '"]').prop("checked", true);
        });

       
          $('.checkboxPropertyStatus:input:checkbox').each(function() {
            if($(this).data('status')=="Active"){
              this.checked = true;
              $('.SelectedStatusBtn').text("Active");
            }
            });
            
          //$('input[name="test"][value="' + value.toString() + '"]').prop("checked", true);
       




        //clear markers
        clearOverlays();
        //show markers and infowindow
        markersInfoWindow(data.mapData);
        //show proprty list sidebar
        propertyListSidebar(data,"Active");
      }else{
        //WHEN NO DATA FOUND DEFAULT LAT LONG SET FOR USA FOR MAP DISPLAY
        $('.searchResultList').empty();
        $('#sortPropertyOrder').hide();
        $('.filterBar').addClass('no_property_found');
        $('.no_property').css('display','block');
        
        //clear markers
        clearOverlays(); 
       // markers.setMap(null);
       
      }
    },
    complete: function(){
      $("#loaderDiv").hide();
    },
  });
}
//ON CHECK BOX CITY CHNAGE AJAX PROPERTY LIST SHOW AND MAP LOAD
$('.citycheckbox').on('change', function (e) {
  var city=[];
  var status=[];
  e.stopPropagation();
  $('.countResult').html('');
  $('.searchResultList').html('');
  //$('.statecitylistbox').parents('.dropdown').addClass('show');
  $('.statecitylistbox').addClass('show');
  var statusChecked="";
  var sort_by_key = $('select[name=sort_property] option').filter(':selected').val();
  //GET CHECKED STATUS
  $(".checkboxPropertyStatus").each(function(){
    var $this = $(this);
    if($this.is(":checked")){
      status.push($this.attr("data-status"));

      statusChecked=$this.attr("data-status");
    }
  });
  //GET CHECKED CITY
  $(".citycheckinput").each(function(){
    var $this = $(this);
    if($this.is(":checked")){

      city.push($this.attr("data-city_id"));
    }
  });

  $.ajax({
    type: "POST",
    url: "{{route('buyer-search-map-filter')}}",
    data: {_token: "{{ csrf_token() }}",city_id:city,status:status,sort_by:sort_by_key},
    dataType: "json",
    beforeSend: function(){
      $("#loaderDiv").show();
    },
    success: function (data){
     
      if(data.result_count > 0){
      	$('.filterBar').removeClass('no_property_found');
      	$('.no_property').css('display','none');

        lat=data.mapData[0][0];
        lng=data.mapData[0][1];
       //clear markers
        clearOverlays();
        //show markers and infowindow
        markersInfoWindow(data.mapData);
        //show proprty list sidebar
        propertyListSidebar(data,statusChecked);
      }else{
        $('.searchResultList').empty();
        $('#sortPropertyOrder').hide();
        $('.filterBar').addClass('no_property_found');
        $('.no_property').css('display','block');
        //clear markers
        clearOverlays(); 
       // markers.setMap(null);
       
      }
     
      },
    complete: function(){
      $("#loaderDiv").hide();
    },
    });
  });

//ON CHECK BOX STATUS CHANGE AJAX PROPERTY LIST SHOW AND MAP LOAD
$('.statuscheckbox').on('change', function (ev) {
  var status=[];
  var city=[];
  ev.stopPropagation();
  $('.countResult').html('');
  $('.searchResultList').html('');
 $('.checkPropertyStatusDiv').addClass('show');
  var active_str="";
  var pending_str="";
  var statusChecked="";
  var sort_by_key=$('select[name=sort_property] option').filter(':selected').val();
  //GET ARRAY OF CHECKED STATUS
  $(".checkboxPropertyStatus").each(function(){
    var $this = $(this);
    if($this.is(":checked")){
        var status_str=$this.attr('data-status');
      if($this.attr('data-status')=="Active"){
         active_str=$this.attr('data-status');
         statusChecked="Active";
      }
      else{
         pending_str=$this.attr('data-status');
         statusChecked="Pending";
      }

      if(active_str!="" && pending_str!=""){  
        $('.SelectedStatusBtn').text(active_str+"/"+pending_str);
         statusChecked="Active and Pending";
      }
      else{ 
        $('.SelectedStatusBtn').text(status_str);
     }
     
      status.push($this.attr("data-status"));
    }

    if(active_str=="" && pending_str==""){
      $('.SelectedStatusBtn').text("Status");
    }



  });
  //GET ARRAY OF CHECKED CITY
  $(".citycheckinput").each(function(){
    var $this = $(this);
    if($this.is(":checked")){
      city.push($this.attr("data-city_id"));
    }
  });

  $.ajax({
    type: "POST",
    url: "{{route('buyer-search-map-filter')}}",
    data: {_token: "{{ csrf_token() }}",city_id:city,status:status,sort_by:sort_by_key},
    dataType: "json",
    beforeSend: function(){
      $("#loaderDiv").show();
    },
    success: function (data){
      if(data.result_count > 0){
       	$('.filterBar').removeClass('no_property_found');
      	$('.no_property').css('display','none');


        lat=data.mapData[0][0];
        lng=data.mapData[0][1];
        //clear markers
        clearOverlays();
        //show markers and infowindow
        markersInfoWindow(data.mapData);
        //show proprty list sidebar
        propertyListSidebar(data,statusChecked);
      }else{
        $('.searchResultList').empty();
        $('#sortPropertyOrder').hide();
        $('.filterBar').addClass('no_property_found');
        $('.no_property').css('display','block');
       
         //clear markers
        clearOverlays(); 
       // markers.setMap(null);
        //WHEN NO DATA FOUND DEFAULT LAT LONG SET FOR USA FOR MAP DISPLAY
      }
    },
    complete: function(){
      $("#loaderDiv").hide();
    }
  });   
});

$('.sortProperty').change(function() {
  var status=[];
  var city=[];
  $('.countResult').html('');
  $('.searchResultList').html('');
  var statusChecked="";
  var active_str="";
  var pending_str="";

    var sort_by= this.value;
    //GET ARRAY OF CHECKED STATUS
    $(".checkboxPropertyStatus").each(function(){
      var $this = $(this);
      if($this.is(":checked")){

        var status_str=$this.attr('data-status');
        if($this.attr('data-status')=="Active"){
           active_str=$this.attr('data-status');
           statusChecked="Active";
        }
        else{
           pending_str=$this.attr('data-status');
           statusChecked="Pending";
        }

        if(active_str!="" && pending_str!=""){  
          $('.SelectedStatusBtn').text(active_str+"/"+pending_str);
           statusChecked="Active and Pending";
        }
        else{ 
          $('.SelectedStatusBtn').text(status_str);
        }
     

        status.push($this.attr("data-status"));
      }

      if(active_str=="" && pending_str==""){
        $('.SelectedStatusBtn').text("Status");
      }
    });
    //GET ARRAY OF CHECKED CITY
    $(".citycheckinput").each(function(){
      var $this = $(this);
      if($this.is(":checked")){
        city.push($this.attr("data-city_id"));
      }
    });

    var html_to_append="";
    
    $.ajax({
      	type: "POST",
      	url: "{{route('buyer-search-map-filter')}}",
      	data: {_token: "{{ csrf_token() }}",sort_by:sort_by,city_id:city,status:status},
      	dataType: "json",
        beforeSend: function(){
          $("#loaderDiv").show();
        },
      	success: function (data){
        	if(data.result_count > 0){
	        	$('.filterBar').removeClass('no_property_found');
	      		$('.no_property').css('display','none');

		        lat=data.mapData[0][0];
		        lng=data.mapData[0][1];
		        //clear markers
		        clearOverlays();
		        //show markers and infowindow
		        markersInfoWindow(data.mapData);
		        //show proprty list sidebar
	        	propertyListSidebar(data,statusChecked);
	      	}else{
	        	$('.searchResultList').empty();
	        	$('#sortPropertyOrder').hide();
	        	$('.filterBar').addClass('no_property_found');
	           	$('.no_property').css('display','block');
	         	
		        //clear markers
		        clearOverlays(); 
		       // markers.setMap(null);
	        	//WHEN NO DATA FOUND DEFAULT LAT LONG SET FOR USA FOR MAP DISPLAY
	      	}
      	},
        complete: function(){
          $("#loaderDiv").hide();
        }
    });
});



$('.searchIcon').click(function(){

  $('.countResult').html('');
 
  $('.searchResultList').html('');
  $('#dropdownMenuButton').hide();
  $('.search-div-location').show();
  var statusChecked="";
  var active_str="";
  var pending_str="";


  var city=[];
  var statusArr=[];
  var sort_by_key=$('select[name=sort_property] option').filter(':selected').val();
  
  //GET CHECKED STATUS
  $(".checkboxPropertyStatus").each(function(){
    var $this = $(this);
    if($this.is(":checked")){
      var status_str=$this.attr('data-status');
        if($this.attr('data-status')=="Active"){
           active_str=$this.attr('data-status');
           statusChecked="Active";
        }
        else{
           pending_str=$this.attr('data-status');
           statusChecked="Pending";
        }

        if(active_str!="" && pending_str!=""){  
          $('.SelectedStatusBtn').text(active_str+"/"+pending_str);
           statusChecked="Active and Pending";
        }
        else{ 
          $('.SelectedStatusBtn').text(status_str);
        }
     
     
      statusArr.push($this.attr("data-status"));
    }

    if(active_str=="" && pending_str==""){
        $('.SelectedStatusBtn').text("Status");
      }
  });
  

  new google.maps.places.Autocomplete(document.getElementById("pac-input"));
  geocoder = new google.maps.Geocoder();
  var location = document.getElementById( 'pac-input' ).value;
    if(location!=""){
        geocoder.geocode( { 'address' : location }, function( results, status ) {
        if( status == google.maps.GeocoderStatus.OK ) {
          $.ajax({
            type: "POST",
            //url: "{{route('buyer-property-search-by-location')}}",
            url: "{{route('buyer-search-map-filter')}}",
            data: {_token: "{{ csrf_token() }}",sort_by:sort_by_key,searchLoc:location,status:statusArr},
            dataType: "json",
            beforeSend: function(){
              $("#loaderDiv").show();
            },
            success: function (data){
              if(data.result_count > 0){
              	 $('.filterBar').removeClass('no_property_found');
	      		     $('.no_property').css('display','none');
                  // Listen for the event fired when the user selects a prediction and retrieve
                  //clear markers
                  clearOverlays();
                  //show markers and infowindow
                  markersInfoWindow(data.mapData);
                  //show proprty list sidebar
                  propertyListSidebar(data,statusChecked);
                }else{
                  $('.searchResultList').empty();
                  $('#sortPropertyOrder').hide();
                 
                  $('.filterBar').addClass('no_property_found');
                  $('.no_property').css('display','block');
               
                  //clear markers
                  clearOverlays(); 
                  // markers.setMap(null);
                }
              },
              complete: function(){
                $("#loaderDiv").hide();
              }
            });
         }else{
           $.ajax({
            type: "POST",
           // url: "{{route('buyer-property-search-by-location')}}",
             url: "{{route('buyer-search-map-filter')}}",

            data: {_token: "{{ csrf_token() }}",sort_by:sort_by_key,searchLoc:location,status:statusArr},
            dataType: "json",
            beforeSend: function(){
              $("#loaderDiv").show();
            },
            success: function (data){
              if(data.result_count > 0){
              	$('.filterBar').removeClass('no_property_found');
	      		     $('.no_property').css('display','none');
                // Listen for the event fired when the user selects a prediction and retrieve
                //clear markers
                clearOverlays();
                //show markers and infowindow
                markersInfoWindow(data.mapData);
                //show proprty list sidebar
                propertyListSidebar(data);
              }else{
                $('.searchResultList').empty();
                $('#sortPropertyOrder').hide();
                $('.filterBar').addClass('no_property_found');
                $('.no_property').css('display','block');
                
                //clear markers
                clearOverlays(); 
               // markers.setMap(null);
              }
            },
            complete: function(){
              $("#loaderDiv").hide();
            }
          });
        }
        });
    }else{
       $('.searchResultList').empty();
        $('#sortPropertyOrder').hide();
        $('.filterBar').addClass('no_property_found');
        $('.no_property').css('display','block');
      
  //clear markers
        clearOverlays(); 
       // markers.setMap(null);
    }


});

$('.close-input-location').click(function(){
 
  $('#dropdownMenuButton').show();
  $('.search-div-location').hide();
  $('#pac-input').val("");
  $('.citycheckinput').prop('checked', false);

  defaultLoad();
});

$(document).ready(function() {
  $(".searchResultList").on("change", ":checkbox",  function() {
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
      beforeSend: function(){
        $("#loaderDiv").show();
      },    
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
      },
      complete: function(){
        $("#loaderDiv").hide();
      }
      }); 
    });    
});


</script>
</body>
</html>