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
                     <input type="text" class="form-control @error('title') is-invalid @enderror"  name = "title" aria-describedby="" placeholder="Title">            
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
                           <option value="1">Renting</option>
                           <option value="2">Buying</option>
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
                        <select class="form-select form-control @error('property_category') is-invalid @enderror" name = "property_category" aria-label="Default select example" id="property_category">
                           <option value = ""> Selerct Category</option>
                           <option value=""></option>
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
                        <input type="text" class="form-control @error('guest_count') is-invalid @enderror" name = "guest_count" aria-describedby="" placeholder="Maximum guest allowed">
                        @if($errors->has('guest_count'))
                        <div class="invalid-feedback">
                           {{$errors->first('guest_count')}}
                        </div>
                        @endif            
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_bedroom') is-invalid @enderror"   name = "no_of_bedroom" aria-describedby="" placeholder="No of Bedrooms">            
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

                        <input type="date" name="built_in_year" class="form-control datepicker @error('built_in_year') is-invalid @enderror" value=""   id="built_in_year" >            
                        @if($errors->has('built_in_year'))
                        <div class="invalid-feedback">
                           {{$errors->first('built_in_year')}}
                        </div>
                        @endif 
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4 pt-4">
                        <input type="text" class="form-control @error('no_of_kitchen') is-invalid @enderror" name = "no_of_kitchen"  aria-describedby="" placeholder="Enter No of Kitchen">            
                        @if($errors->has('no_of_kitchen'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_kitchen')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_bathroom') is-invalid @enderror" name = "no_of_bathroom"  aria-describedby="" placeholder="Enter No of Bathrooms">            
                        @if($errors->has('no_of_bathroom'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_bathroom')}}
                        </div>
                        @endif
                     </div>
                  </div>
                 
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_balcony') is-invalid @enderror"  name = "no_of_balcony"  aria-describedby="" placeholder="Enter No of Balcony">            
                        @if($errors->has('no_of_balcony'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_balcony')}}
                        </div>
                        @endif  
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('property_area') is-invalid @enderror" name ="property_area" aria-describedby="" placeholder=" Enter Property Area">            
                        @if($errors->has('property_area'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_area')}}
                        </div>
                        @endif    
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_floors') is-invalid @enderror " name = "no_of_floors"  aria-describedby="" placeholder="Enter Floor No">            
                        @if($errors->has('no_of_floors'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_floors')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <select class="form-select form-control @error('property_condition') is-invalid @enderror"  name = "property_condition" aria-label="Default select example">
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
                        
                        <input type="text" class="form-control" name = "property_number" value="{{$userData->mobile}}"  aria-describedby="" placeholder="Enter Contact No" id = "property_number">  
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
                        <input type="text" class="form-control" value="{{$userData->email}}"  name = "property_email"  aria-describedby="" placeholder="Enter Contact Email">
                        @if($errors->has('property_email'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_email')}}
                        </div>
                        @endif            
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="mb-4 position-relative address-group">
                        <input type="text" class="form-control pe-5 @error('property_address') is-invalid @enderror" name = "property_address" id="" aria-describedby="" placeholder="Address">   
                        @if($errors->has('property_address'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_address')}}
                        </div>
                        @endif                
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <select class="form-select form-control @error('property_price_type') is-invalid @enderror" name="property_price_type"  aria-label="Default select example" id="property_price_type" >
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
                        <input type="text" class="form-control @error('property_price') is-invalid @enderror" name = "property_price"  aria-describedby="" placeholder="Enter Property Price">            
                        @if($errors->has('property_price'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_price')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="file" id="property_image" class="form-control @error('property_image') is-invalid @enderror" name="property_image">            
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
                           <select class="form-control js-example-tokenizer" placeholder="Add Features" name="property_features[]" multiple="multiple">
                              <option value="">Add Features</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="mb-4">            
                        <textarea class="form-control" name = "meta_title" id="exampleFormControlTextarea1" rows="3" placeholder="Meta Title"></textarea>         
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="mb-4">            
                        <textarea class="form-control" name = "meta_keywords" id="exampleFormControlTextarea1" rows="3" placeholder="Meta keywords"></textarea>         
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="mb-4">            
                        <textarea class="form-control" name = "meta_description" id="exampleFormControlTextarea1" rows="3" placeholder="Meta Description"></textarea>         
                     </div>
                  </div>
               </div>
               <div class="col-12">
                  <div class="mb-4">            
                     <textarea class="form-control" name = "property_description" id="exampleFormControlTextarea1" rows="3" placeholder="Property Description"></textarea>         
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
                           <input type = "checkbox" name = "chk_pool"  value = "1" >           
                        </div>
                     </div>
                     <div class="col-auto">
                        <div class="mb-4 checkbox-col">
                           <label>Lift</label>
                           <input type = "checkbox" name = "chk_lift"   value = "1" >           
                        </div>
                     </div>
                 
                  <div class="col-auto">
                     <div class="mb-4 checkbox-col">
                        <label>Garden</label>
                        <input type = "checkbox" name = "chk_garden"  value = "1">           
                     </div>
                  </div>
                  <div class="col-auto">
                     <div class="mb-4 checkbox-col">
                        <label>Parking</label>
                        <input type = "checkbox" name = "chk_parking"  value = "1" >           
                     </div>
                  </div>
                   </div>
                   </div>
            <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="file" id="property_gallery_image"  class="form-control @error('property_gallery_image') is-invalid @enderror" name="property_gallery_image[]" multiple="multiple">            
                        @if($errors->has('property_gallery_image'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_gallery_image')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-md-12">

                    <div class="mt-1 text-center">

                        <div class="images-preview-div"> </div>

                    </div> 

                </div> 
          
            <button type="submit" class="btn btn-primary w-auto">Save</button>
         </form>
      </div>
   </div>
</div>
</div>
</div>
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script type="text/javascript" src="{{ asset('assets_front/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/script.js')}}"></script>

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
