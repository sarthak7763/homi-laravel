@extends('admin::layouts.master')
@section('title', 'Edit property Gallery')
@section('content')
 <div class="card">
    <div class="card-header">
        <h4>Edit Property
            <a href="{{route('admin-property-list')}}" class="btn btn-primary btn-md pull-right"><i class="fa fa-reply"></i> Go Back to Property List</a>
        </h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{route('admin-property-update')}}"  enctype="multipart/form-data">
            @csrf
             <input type="hidden" class="form-control @error('slug') is-invalid @enderror" value="{{$propertyInfo->slug}}" name="slug" id="slug">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Property Image</label>
                        <input type="file" class="form-control  @error('image') is-invalid @enderror" name="image"  id="image"  accept="image/*" onchange="loadFile(event)">
                        <span class="messages"></span>
                         @error('image')
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <img id="output" @if($propertyInfo->image!="") src="{{$propertyInfo->image}}" width="200" height="100" @endif/>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Property Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{$propertyInfo->title}}" name="title" id="title"  required="required">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Property Size Area Square Fit</label>
                        <input type="text" class="form-control @error('property_size') is-invalid @enderror" value="{{$propertyInfo->property_size}}" name="property_size" id="property_size">
                        @error('property_size')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Base Price</label>
                        <input type="text" class="form-control @error('base_price') is-invalid @enderror" value="{{$propertyInfo->base_price}}" name="base_price" id="base_price">
                        @error('base_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">Price From</label>
                        <input type="text" class="form-control @error('price_from') is-invalid @enderror" value="{{$propertyInfo->price_from}}" name="price_from" id="price_from">
                        @error('price_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold"> Price To</label>
                        <input type="text" class="form-control @error('price_to') is-invalid @enderror" value="{{$propertyInfo->price_to}}" name="price_to" id="price_to">
                        @error('price_to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">Year From</label>
                        <input type="text" class="form-control @error('year_from') is-invalid @enderror" value="{{$propertyInfo->year_from}}" name="year_from" id="year_from">
                        @error('year_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">Year To</label>
                        <input type="text" class="form-control @error('year_to') is-invalid @enderror" value="{{$propertyInfo->year_to}}" name="year_to" id="year_to">
                        @error('year_to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                 <div class="col-md-3">
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
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">No. of Bathrooms</label>
                        <input type="text" class="form-control @error('no_of_bathroom') is-invalid @enderror" value="{{$propertyInfo->no_of_bathroom}}" name="no_of_bathroom" id="no_of_bathroom">
                        @error('no_of_bathroom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">No. of Bedrooms</label>
                        <input type="text" class="form-control @error('no_of_bedroom') is-invalid @enderror" value="{{$propertyInfo->no_of_bedroom}}" name="no_of_bedroom" id="no_of_bedroom">
                        @error('no_of_bedroom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">No. of Roof</label>
                        <input type="text" class="form-control @error('no_of_roof') is-invalid @enderror" value="{{$propertyInfo->no_of_roof}}" name="no_of_roof" id="no_of_roof">
                        @error('no_of_roof')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" value="{{$propertyInfo->address}}" name="address" id="address">
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">Zip Code</label>
                        <input type="text" class="form-control @error('zipcode') is-invalid @enderror" value="{{$propertyInfo->zipcode}}" name="zipcode" id="zipcode">
                        @error('zipcode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">Latitude</label>
                        <input type="text" class="form-control @error('latitude') is-invalid @enderror" value="{{$propertyInfo->latitude}}" name="latitude" id="latitude">
                        @error('latitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">Longtitude</label>
                        <input type="text" class="form-control @error('longitude') is-invalid @enderror" value="{{$propertyInfo->longitude}}" name="longitude" id="longitude">
                        @error('longitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
               
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" value="{{$propertyInfo->location}}" name="location" id="location">
                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
               
               
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Country</label>
                        
                        <select name="country" id="country" class="form-control" onchange="getState()" required>
                        <option value="">Select Country</option>
                        @foreach($countryList as $cli)
                          
                                <option value="{{$cli->id}}" @if($cli->id == $propertyInfo->country) selected @endif>{{$cli->name}}</option>
                           
                            @endforeach 
                        </select>
                        @error('country')
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror  
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">State</label>
                        <select class="form-control" name="state" id="state" onchange="getCity()" required>
                           <option value="">Select State</option> 
                            @foreach($stateList as $sli)
                                @if($propertyInfo->country == $sli->country_id)
                                    <option value="{{$sli->id}}" @if($sli->id == $propertyInfo->state) selected @endif>{{$sli->name}}</option>
                                @endif
                            @endforeach 
                        </select>
                        @error('state')
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror  
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">City</label>
                        <select class="form-control" name="city" id="city" required>
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
            </div>
            <div class="row">
             <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Property Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" value="{{$propertyInfo->description}}"  name="description" id="description">
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
                    <button type="submit" name="submit" value="submit" class="btn btn-primary m-b-0">Submit</button>

                    <a href="{{route('admin-property-list')}}" class="btn btn-inverse m-b-0">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    $("#output").css("width", 200);
    $("#output").css("height", 150);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
function getState(){
    $('#state').html('');
    $('#city').html('');
    var countryID =$("#country").val();         
    $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",country_id:countryID}, 
        url: "{{ route('admin-ajax-get-state-list') }}",
        success:function(result){
            if(result) {
                $('#state').html(result);
            }
            else {
                alert('error');
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
        success:function(result){
            if(result) {
                $('#city').html(result);
            }
            else {
                alert('error');
            }
        }
    });
}
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    $("#output").css("width", 200);
    $("#output").css("height", 150);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };


function getState(){
    $('#state').html('');
    $('#city').html('');
    var countryID =$("#country").val();         
    $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",country_id:countryID}, 
        url: "{{ route('admin-ajax-get-state-list') }}",
        success:function(result){
            if(result) {
                $('#state').html(result);
            }
            else {
                alert('error');
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
        success:function(result){
            if(result) {
                $('#city').html(result);
            }
            else {
                alert('error');
            }
        }
    });
}
</script>
@endsection
