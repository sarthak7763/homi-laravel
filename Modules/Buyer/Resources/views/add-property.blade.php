@extends('buyer::layouts.master')
@section('content')
<div class="col-lg-9">
   <div class="profile-box">
      <div class="profile-box-form">
         <h1 class="mb-3">Add New Properties</h1>
 
         <form class="profile-form p-3 mb-4" action = "{{route('buyer.store-property')}}" method = "Post" enctype= "multipart/form-data">
            @csrf 
            <div class="row">
               <div class="col-12">
                  <div class="mb-4">
                     <input type="text" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror"   name = "title" aria-describedby="" placeholder="Title">            
                     @if($errors->has('title'))
                     <div class="invalid-feedback">
                        {{$errors->first('title')}}
                     </div>
                     @endif
                  </div>
               </div>
            </div>
            
            <div class="row-col">
               <div class="row">
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <select class="form-select form-control @error('property_type') is-invalid @enderror " name = "property_type"  aria-label="Default select example" id = "property_type" >
                           <option >Property type</option>
                           <option value="1" @if (old('property_type') == "1") {{ 'selected' }} @endif >Renting</option>
                           <option value="2" @if (old('property_type') == "2") {{ 'selected' }} @endif>Buying</option>
                           
                        </select>
                        @if($errors->has('property_type'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_type')}}
                        </div>
                        @endif           
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <select class="form-select form-control @error('property_category') is-invalid @enderror"  name = "property_category" aria-label="Default select example" id="property_category">
                           <option value = ""> Select Category</option>
                           <option value = ""> </option>

                        </select>
                        @if($errors->has('property_category'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_category')}}
                        </div>
                        @endif           
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="number" value="{{old('guest_count')}}" class="form-control @error('guest_count') is-invalid @enderror"  name = "guest_count" aria-describedby="" placeholder="Maximum guest allowed">
                        @if($errors->has('guest_count'))
                        <div class="invalid-feedback">
                           {{$errors->first('guest_count')}}
                        </div>
                        @endif            
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="number" value="{{old('no_of_bedroom')}}" class="form-control @error('no_of_bedroom') is-invalid @enderror"   name = "no_of_bedroom" aria-describedby="" placeholder="No of Bedrooms">            
                        @if($errors->has('no_of_bedroom'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_bedroom')}}
                        </div>
                        @endif 
                     </div>
                  </div>
                  <div class="col-sm-6">

                     <div class="mb-4">
                  <label> Property Built In Year</label>

                        <input type="date" name="built_in_year"   class="form-control datepicker @error('built_in_year') is-invalid @enderror"    id="built_in_year" >            
                        @if($errors->has('built_in_year'))
                        <div class="invalid-feedback">
                           {{$errors->first('built_in_year')}}
                        </div>
                        @endif 
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4 pt-4">
                        <input type="number" value="{{old('no_of_kitchen')}}"   class="form-control @error('no_of_kitchen') is-invalid @enderror" name = "no_of_kitchen"  aria-describedby="" placeholder="Enter No of Kitchen">            
                        @if($errors->has('no_of_kitchen'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_kitchen')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="number" value="{{old('no_of_bathroom')}}" class="form-control @error('no_of_bathroom') is-invalid @enderror" name = "no_of_bathroom"  aria-describedby="" placeholder="Enter No of Bathrooms">            
                        @if($errors->has('no_of_bathroom'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_bathroom')}}
                        </div>
                        @endif
                     </div>
                  </div>
                 
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="number" value="{{old('no_of_balcony')}}" class="form-control @error('no_of_balcony') is-invalid @enderror"  name = "no_of_balcony"  aria-describedby="" placeholder="Enter No of Balcony">            
                        @if($errors->has('no_of_balcony'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_balcony')}}
                        </div>
                        @endif  
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="number" value="{{old('property_area')}}" class="form-control @error('property_area') is-invalid @enderror" name ="property_area" aria-describedby="" placeholder=" Enter Property Area">            
                        @if($errors->has('property_area'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_area')}}
                        </div>
                        @endif    
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="number" value="{{old('no_of_floors')}}"  class="form-control @error('no_of_floors') is-invalid @enderror " name = "no_of_floors"  aria-describedby="" placeholder="Enter Floor No">            
                        @if($errors->has('no_of_floors'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_floors')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <select class="form-select form-control @error('property_condition') is-invalid @enderror"   name = "property_condition" aria-label="Default select example">
                           <option value = ""> Select Property Condition </option>
                           @foreach($property_condition as $property) 
                           <option value="{{$property->id}}">{{$property->name}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('property_condition'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_condition')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <div class="country_code_div">
                        <select id="country_id" name="country_id" class=" form-control">
                        @foreach($country_list as $list)
                        <option value="{{$list['id']}}">
                            ({{$list['phonecode']}})</option>
                           @endforeach
                         
                           </select>          
                        
                        <input type="number"    class="form-control" name = "property_number" value="{{$userData->mobile}}"  aria-describedby="" placeholder="Enter Contact No" id = "property_number">  
                        @if($errors->has('property_number'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_number')}}
                        </div>
                        @endif   
                     
                     </div>         
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">            
                        <input type="email"  class="form-control" value="{{$userData->email}}"  name = "property_email"  aria-describedby="" placeholder="Enter Contact Email">
                        @if($errors->has('property_email'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_email')}}
                        </div>
                        @endif            
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="mb-4 position-relative address-group">
                        <input type="text" id="property_address"   class="form-control pe-5 @error('property_address') is-invalid @enderror" name = "property_address" placeholder="Address">   
                        <input type="hidden" name="property_latitude" id="property_latitude" value="" />
                                <input type="hidden" name="property_longitude" id="property_longitude" value="" />
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <select class="form-select form-control @error('property_price_type') is-invalid @enderror"  name="property_price_type"  aria-label="Default select example" id="property_price_type" >
                           <option value="">Select price type</option>
                        </select>
                        @if($errors->has('property_price_type'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_price_type')}}
                        </div>
                        @endif
                        </select>           
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="number" value="{{old('property_price')}}"  class="form-control @error('property_price') is-invalid @enderror" name = "property_price"  aria-describedby="" placeholder="Enter Property Price">            
                        @if($errors->has('property_price'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_price')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="file"  id="property_image" value="{{old('property_image')}}" class="form-control @error('property_image') is-invalid @enderror" name="property_image">            
                        @if($errors->has('property_image'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_image')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-md-12 mb-2">
                        <img id="property_image_preview" src="#"
                        alt="" style="max-height: 250px;">

              </div>

                  <div class="row">
                     <div class="col-12">
                        <label> Property Features</label>
                        <div class="mb-4">
                           <select class="form-control js-example-tokenizer"  placeholder="Add Features" name="property_features[]" multiple="multiple">
                              <option value="">Add Features</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="mb-4">            
                        <textarea class="form-control @error('meta_title') is-invalid @enderror" name = "meta_title" id="exampleFormControlTextarea1" rows="3" placeholder="Meta Title"></textarea>         
                        @if($errors->has('meta_title'))
                        <div class="invalid-feedback">
                           {{$errors->first('meta_title')}}
                        </div>
                        @endif
                     </div>

                  </div>
                  <div class="col-12">
                     <div class="mb-4">            
                        <textarea class="form-control @error('meta_keywords') is-invalid @enderror"  name = "meta_keywords" id="exampleFormControlTextarea1" rows="3" placeholder="Meta keywords"></textarea>         
                        @if($errors->has('meta_keywords'))
                        <div class="invalid-feedback">
                           {{$errors->first('meta_keywords')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="mb-4">            
                        <textarea class="form-control @error('meta_description') is-invalid @enderror " name = "meta_description" id="exampleFormControlTextarea1" rows="3" placeholder="Meta Description"></textarea>         
                        @if($errors->has('meta_description'))
                        <div class="invalid-feedback">
                           {{$errors->first('meta_description')}}
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="col-12">
                  <div class="mb-4">            
                     <textarea class="form-control @error('property_description') is-invalid @enderror"  name = "property_description" id="exampleFormControlTextarea1" rows="3" placeholder="Property Description"></textarea>         
                     @if($errors->has('property_description'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_description')}}
                        </div>
                        @endif
                  </div>
               </div>
            </div>
            <div>
            </div>
             <div class="col-sm-12">
                   <div class="row"> 
                     <div class="col-auto">
                        <div class="mb-4 checkbox-col">
                           <label>Pool</label>
                           <input @if (old('chk_pool') == "1") {{ 'checked' }} @endif type = "checkbox" name = "chk_pool"  value = "1">           
                        </div>
                     </div>
                     <div class="col-auto">
                        <div class="mb-4 checkbox-col">
                           <label>Lift</label>
                           <input @if (old('chk_lift') == "1") {{ 'checked' }} @endif type = "checkbox" name = "chk_lift"   value = "1"  >           
                        </div>
                     </div>
                 
                  <div class="col-auto">
                     <div class="mb-4 checkbox-col">
                        <label>Garden</label>
                        <input @if (old('chk_garden') == "1") {{ 'checked' }} @endif type = "checkbox" name = "chk_garden"  value = "1" >           
                     </div>
                  </div>
                  <div class="col-auto">
                     <div class="mb-4 checkbox-col">
                        <label>Parking</label>
                        <input @if (old('chk_parking') == "1") {{ 'checked' }} @endif type = "checkbox" name = "chk_parking"  value = "1"  >           
                     </div>
                  </div>
                   </div>
                   </div>
            <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="file"  id="property_gallery_image"  class="form-control @error('property_gallery_image') is-invalid @enderror" name="property_gallery_image[]" multiple="multiple">            
                        @if($errors->has('property_gallery_image'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_gallery_image')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div>
        @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    </div>
   <div class="col-md-12">
      <div class="mt-1 text-center">
         <div class="images-preview-div"> </div>
      </div>
   </div> 
          
          <div class="d-flex text-center py-4 gap-2 justify-content-center">
            <button type="submit" class="btn btn-primary w-auto m-0 ">Save</button>
            <a href ="{{route('buyer.property','all')}}" button type="button" class="btn btn-danger cancel_btn  mx-0 mt-0 px-3">Back</a>
         </form>
      </div>
   </div>
</div>
</div>
</div>
</div>
@endsection

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZWubYF4RSrhWvk_cDI17x4oeUaZm7lf8&libraries=places&callback=initMap"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZWubYF4RSrhWvk_cDI17x4oeUaZm7lf8&libraries=places&callback=initMap"></script>

<script type="text/javascript" src="{{ asset('assets_front/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/script.js')}}"></script>


<script>
    $(document).ready(function(){
       
      var property_typeonload="{{old('property_type')}}";
      
      var property_price_type="{{old('property_price_type')}}";
      
      var property_category="{{old('property_category')}}";
      
      var optionhtmlonload='<option value="">Select price type</option>';
    if(property_typeonload!=""){
      if(property_typeonload==1)
      {
    
        if(property_price_type==4)
        {
          var selectoption4="selected";
        }
        else{
          var selectoption4="";
        }
    
        if(property_price_type==5)
        {
          var selectoption5="selected";
        }
        else{
          var selectoption5="";
        }
    
        if(property_price_type==6)
        {
          var selectoption6="selected";
        }
        else{
          var selectoption6="";
        }
    
        optionhtmlonload+='<option '+selectoption4+' value="4">Per night</option>';
      }
      else{
        if(property_price_type==1)
        {
          var selectoption1="selected";
        }
        else{
          var selectoption1="";
        }
    
        if(property_price_type==2)
        {
          var selectoption2="selected";
        }
        else{
          var selectoption2="";
        }
    
        if(property_price_type==3)
        {
          var selectoption3="selected";
        }
        else{
          var selectoption3="";
        }
    
        optionhtmlonload+='<option '+selectoption1+' value="1">PerSq.Ft</option><option '+selectoption2+' value="2">Fixed </option><option '+selectoption3+' value="3">Persq.yard</option>';
      }
    
      $('#property_price_type').html(optionhtmlonload);
    
      $.ajax({
            type: "POST",
            data:{_token: "{{ csrf_token() }}",property_type:property_typeonload,property_category:property_category}, 
            url: "{{ route('buyer.get-category') }}",
            dataType:'json',
            beforeSend: function(){
                $("#loading").show();
            },
            complete: function(){
                $("#loading").hide();
            },
            success:function(result){
                if(result.code==200) {
                    $('#property_category').html(result.categoryhtml);
                }
                else {
                    alert('error');
                }
            }
        });
   }
});
</script>

<script type="text/javascript">

$(document).ready(function (e) {
   
$('#property_image').change(function(){
let reader = new FileReader();
reader.onload = (e) => {

$('#property_image_preview').attr('src', e.target.result);

    }
reader.readAsDataURL(this.files[0]);
});

   });

</script>


<script>
var input = document.getElementById('property_address');
var originLatitude = document.getElementById('property_latitude');
var originLongitude = document.getElementById('property_longitude');

var originAutocomplete = new google.maps.places.Autocomplete(input);

    
originAutocomplete.addListener('place_changed', function(event) {
    var place = originAutocomplete.getPlace();

    if (place.hasOwnProperty('place_id')) {
        if (!place.geometry) {
                // window.alert("Autocomplete's returned place contains no geometry");
                return;
        }
        originLatitude.value = place.geometry.location.lat();
        originLongitude.value = place.geometry.location.lng();
    } else {
        service.textSearch({
                query: place.name
        }, function(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                originLatitude.value = results[0].geometry.location.lat();
                originLongitude.value = results[0].geometry.location.lng();
            }
        });
    }
});
</script>






 



<script>
    $(function() {
    // Multiple images preview with JavaScript
    var previewImages = function(input, imgPreviewPlaceholder) {
    
        if (input.files) {
            var filesAmount = input.files.length;
           
            for (i = 0; i < filesAmount; i++) {

                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img style="height:150px;width:150px;">')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#property_gallery_image').on('change', function() {
        previewImages(this, 'div.images-preview-div');
    });
  });
</script>
