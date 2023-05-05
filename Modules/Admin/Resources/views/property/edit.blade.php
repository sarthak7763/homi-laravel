@extends('admin::layouts.master')
@section('title', 'Edit property')
@section('content')
 
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit Property</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-list')}}">Property List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-property-edit',$propertyInfo->slug)}}">Edit Property</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->
                @if ($message = Session::get('success'))
                    <div class="row">
                        <div class="col-md-12">
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                             <label  class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"  style="font-size: 19px;margin-top: -1px;">&times;</span>
                              </label>
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                @endif
                @if($message = Session::get('error'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                             <label type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="font-size: 19px;margin-top: -1px;">&times;</span>
                              </label>
                                
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <!-- <div class="card-header">
                                    <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div>
                                </div> -->
                                <div class="card-block">
                                    <form method="POST" action="{{route('admin-property-update')}}"  enctype="multipart/form-data">
                                        @csrf
                                         <input type="hidden" value="{{$propertyInfo->slug}}" name="slug">
                                         

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Property Featured Image<span style="color:red;">*</span></label>
                                                    <input type="file" class="form-control  @error('image') is-invalid @enderror" name="image"  id="image"  accept="image/*" onchange="loadFile(event)">
                                                    <span class="messages"></span>
                                                     @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <img id="output" @if($propertyInfo->image!="") src="{{$propertyInfo->image}}" width="200" height="100" @endif/>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Property Type<span style="color:red;">*</span>
                                                    </label>
                                                    <select class="form-control @error('property_type') is-invalid @enderror" name="property_type">
                                                     @foreach($catTypeList as $k=>$cli)
     
                                                        <option value="{{$cli->id}}" @if($cli->id== $propertyInfo->property_type)  selected @endif>{{$cli->name}}</option>
                                                       @endforeach
                                                    </select>
                                                     @error('property_type')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Address<span style="color:red;">*</span></label>
                                                    <input type="text" value="{{$propertyInfo->location}}"  class="form-control @error('location') is-invalid @enderror" name="location" id="location">
                                                    @error('location')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Property Title<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{$propertyInfo->title}}" name="title" id="title"  required="required">
                                                    @error('title')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Living SqFt<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('property_size') is-invalid @enderror autonumber" data-v-min="0" data-v-max="999999999999999" value="{{$propertyInfo->property_size}}" name="property_size" id="property_size">
                                                    @error('property_size')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Lot Size<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('lot_size') is-invalid @enderror autonumber" data-a-sep="," value="{{$propertyInfo->lot_size}}" data-v-min="0" data-v-max="999999999999999" name="lot_size" id="lot_size">
                                                    @error('lot_size')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">List Price<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control autonumber @error('base_price') is-invalid @enderror" value="{{$propertyInfo->base_price}}" data-v-min="0" data-v-max="999999999999" name="base_price" id="base_price" maxlength="12" data-a-sign="$">
                                                    @error('base_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Seller Price<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control autonumber @error('seller_price') is-invalid @enderror" value="{{$propertyInfo->seller_price}}" data-v-min="0" data-v-max="999999999999" name="seller_price" id="seller_price" maxlength="12" data-a-sign="$">
                                                    @error('seller_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                             {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Price From</label>
                                                    <input type="text" class="form-control only_number @error('price_from') is-invalid @enderror" value="{{$propertyInfo->price_from}}" name="price_from" id="price_from" maxlength="12">
                                                    @error('price_from')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}
                                             {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Max Price</label>
                                                    <input type="text" class="form-control only_number @error('price_to') is-invalid @enderror" value="{{$propertyInfo->price_to}}" name="price_to" id="price_to" maxlength="12">
                                                    @error('price_to')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Year Built</label>
                                                    <input type="text" class="form-control only_number @error('year_from') is-invalid @enderror" maxlength="4" value="{{$propertyInfo->year_from}}" name="year_from" id="year_from">
                                                    @error('year_from')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Built In Year To</label>
                                                    <input type="text" class="form-control only_number @error('year_to') is-invalid @enderror" maxlength="4" value="{{$propertyInfo->year_to}}" name="year_to" id="year_to">
                                                    @error('year_to')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}
                                            {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Currency Type</label>
                                                    <select class="form-control @error('currency_type') is-invalid @enderror" name="currency_type" id="currency_type">
                                                    <option value="Rupees" @if($propertyInfo->price_to== "Rupees")  selected @endif>Rupees</option>
                                                    <option value="Dollar" @if($propertyInfo->price_to== "Dollar")  selected @endif>Dollar</option>
                                                    </select>
                                                    @error('currency_type')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Baths</label>
                                                    <input type="text" class="form-control only_number @error('no_of_bathroom') is-invalid @enderror" value="{{$propertyInfo->no_of_bathroom}}" name="no_of_bathroom" id="no_of_bathroom" maxlength="3">
                                                    @error('no_of_bathroom')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Beds</label>
                                                    <input type="text" class="form-control only_number @error('no_of_bedroom') is-invalid @enderror" value="{{$propertyInfo->no_of_bedroom}}" name="no_of_bedroom" id="no_of_bedroom" maxlength="3">
                                                    @error('no_of_bedroom')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">No. of Roof</label>
                                                    <input type="text" class="form-control only_number @error('no_of_roof') is-invalid @enderror" value="{{$propertyInfo->no_of_roof}}" name="no_of_roof" id="no_of_roof" maxlength="2">
                                                    @error('no_of_roof')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}
                                        
                                       
                                              <input type="hidden" name="country" value="{{$propertyInfo->country}}">
                                             

                                           {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Country<span style="color:red;">*</span></label>
                                                    
                                                    <select name="country" id="country" class="form-control @error('country') is-invalid @enderror" onchange="getState()" readonly="true">
                                                  
                                                    @foreach($countryList as $cli)
                                                      
                                                            <option value="{{$cli->id}}" selected>{{$cli->name}}</option>
                                                       
                                                        @endforeach 
                                                    </select>
                                                    @error('country')
                                                        <span class="messages">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>--}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">State<span style="color:red;">*</span></label>
                                                    <select class="form-control @error('state') is-invalid @enderror" name="state" id="state" onchange="getCity()" required>
                                                       <option value="">Select State</option> 
                                                        @foreach($stateList as $sli)
                                                                <option value="{{$sli->id}}" @if($sli->id == $propertyInfo->state) selected @endif>{{$sli->name}}</option>
                                                          
                                                        @endforeach 
                                                    </select>
                                                    @error('state')
                                                        <span class="messages">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">City<span style="color:red;">*</span></label>
                                                    <select class="form-control @error('city') is-invalid @enderror" name="city" id="city" required>
                                                        <option value="">Select City</option>
                                                        @foreach($cityList as $li)
                                                            @if($propertyInfo->state==$li->state_id)
                                                                <option value="{{$li->id}}" @if($li->id == $propertyInfo->city) selected @endif>{{$li->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('city')
                                                        <span class="messages">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>  
                                         {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Zip Code</label>
                                                    <input type="text" class="form-control only_number @error('zipcode') is-invalid @enderror" value="{{$propertyInfo->zipcode}}" name="zipcode" id="zipcode" maxlength="5">
                                                    @error('zipcode')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> 
                                         
                                          
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Address<span style="color:red;">*</span></label>
                                                    <textarea type="text" class="form-control @error('address') is-invalid @enderror"  name="address" id="address">{{$propertyInfo->address}}</textarea>
                                                    @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}

                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Est. COE</label>
                                                    <input type="text" class="form-control bg-white @error('emd_coe') is-invalid @enderror" value="@if(@$propertyInfo->emd_coe && $propertyInfo->emd_coe != "")@php echo date('M-d-Y',strtotime($propertyInfo->emd_coe));@endphp @endif" name="emd_coe" id="emd_coe" readonly="readonly">
                                                    @error('emd_coe')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                           
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">EMD Amount</label>
                                                    <input type="text" data-a-sign="$" class="form-control autonumber @error('emd_amount') is-invalid @enderror" value="{{$propertyInfo->emd_amount}}" data-v-min="0" data-v-max="999999999999" name="emd_amount" id="emd_amount">
                                                    @error('emd_amount')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">EMD Due</label>
                                                    <input type="text" class="form-control  @error('emd_due') is-invalid @enderror" value="{{$propertyInfo->emd_due}}" name="emd_due" id="emd_due">
                                                    @error('emd_due')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            

                                           



                                             {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Latitude<span style="color:red;">*</span></label>--}}
                                                    <input type="hidden" class="form-control @error('latitude') is-invalid @enderror" value="{{$propertyInfo->latitude}}" name="latitude" id="latitude">
                                                   {{-- @error('latitude')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Longtitude<span style="color:red;">*</span></label>--}}
                                                    <input type="hidden" class="form-control @error('longitude') is-invalid @enderror" value="{{$propertyInfo->longitude}}" name="longitude" id="longitude">
                                                    {{-- @error('longitude')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>--}}
                                       
                                         <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Property Description</label>
                                                    <textarea  class="ck-editor @error('description') is-invalid @enderror"  name="description" id="description">{{$propertyInfo->description}}</textarea>
                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(Auth::user()->hasRole('Admin')) 
                                                    
                                                    <button type="submit" class="btn btn-primary m-b-0">Update</button>

                                                    <a href="{{route('admin-property-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                            
                                                
                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-property-update'))
                                                       
                                                        <button type="submit"  class="btn btn-primary m-b-0">Update</button>
                                                    @endif
                                                    @if(auth()->user()->can('admin-property-list'))
                                                       <a href="{{route('admin-property-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                                    @endif
                                                @endif
                                              
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
@section('js')

<!-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{env('GOOGLE_API_KEY')}}"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZWubYF4RSrhWvk_cDI17x4oeUaZm7lf8&libraries=places&callback=initMap"></script>



<script>
 $('#emd_coe').datepicker({
    dateFormat: "M-dd-yy",

});


let autocomplete = new google.maps.places.Autocomplete(document.getElementById("location"));
google.maps.event.addListener(autocomplete, 'place_changed', function() {
    var place = autocomplete.getPlace();
    console.log('palace',place);
    console.log('lat',place.geometry.location.lat())
    console.log('lng',place.geometry.location.lng())
    $('#latitude').val(place.geometry.location.lat());
    $('#longitude').val(place.geometry.location.lng());
     var data = $("#location").val();
     show_submit_data(data);
        return false;
});

function show_submit_data(data) {
    var new_title=data.slice(0,data.lastIndexOf(','));
    $("#title").val(new_title);
}


//$("#location").bind("paste select", function() {
//  $("#location").on("change paste keyup keydown mousedown mouseup mousedown mousemove mouseout click", function() {
//     var title = $(this).val();
//     var new_title=title.slice(0,title.lastIndexOf(','));
//     $('#title').val(new_title);
// });
// var autocomplete1 = new google.maps.places.Autocomplete(document.getElementById("location"));
// geocoder = new google.maps.Geocoder();
//    google.maps.event.addListener(autocomplete1, 'place_changed', function() {
//         var data = $("#location").val();
        
//         show_submit_data(data);
//         return false;
//     });



// autocomplete1.addListener('place_changed', fillInAddress);
//                 function fillInAddress() {
//                     var place1 = autocomplete1.getPlace();
//                    // console.log(place1);
//                 }

// $("#location").blur(function(){ 
//     var location = document.getElementById( 'location' ).value;
//     if(location!=""){
//         geocoder.geocode( { 'address' : location }, function( results, status ) {
//         if( status == google.maps.GeocoderStatus.OK ) {
//             console.log(results[0].geometry.location.lat(), results[0].geometry.location.lng());
//             $('#latitude').val(results[0].geometry.location.lat());
//             $('#longitude').val(results[0].geometry.location.lng());


//                 // map.setCenter( results[0].geometry.location );

//                 // var marker = new google.maps.Marker( {
//                 //     map     : map,
//                 //     position: results[0].geometry.location
//                 // } );
//         }else{
//             //alert( 'Geocode was not successful for the following reason: ' + status );
//         }
//         });
//     }
// });


CKEDITOR.replace( 'description' );
function clearData(){
    for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
    CKEDITOR.instances[instance].setData('');
 
}

function getState(){
    $('#state').html('');
    $('#city').html('');
    var countryID =$("#country").val();         
    $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",country_id:countryID}, 
        url: "{{ route('admin-ajax-get-state-list') }}",
         beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
        success:function(result){
            if(result) {
                $('#state').html(result);
            }
            else {
              //  alert('error');
            }
        }
    });
}
function getCity(){
    var stateID =$("#state").val();         
    $.ajax({
        type: "POST",
        data: {_token: "{{ csrf_token() }}",state_id:stateID}, 
        url: "{{ route('admin-ajax-get-city-list') }}",
         beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
        success:function(result){
            if(result) {
                $('#city').html(result);
            }
            else {
              //  alert('error');
            }
        }
    });
}


</script>
@endsection
