@extends('buyer::layouts.master')
@section('content')
<div class="col-md-8 col-lg-9">
    
    <div class="profile-box">
        <div class="profile-box-form">
            <h1 class="mb-3">Edit Properties</h1>
            <form class="profile-form p-3 mb-4" action = "{{route('buyer.update-property',$propertyDetail->id)}}" method = "Post" enctype= "multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="mb-4">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" value = "{{$propertyDetail->title}}"  name = "title" aria-describedby="" placeholder="Title">            
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
                                <select name="property_type" id="property_type"  class="form-select form-control @error('property_type') is-invalid @enderror ">
                                <option value="1" {{ $propertyDetail->property_type == 1 ? 'selected' : '' }}>Renting</option>
                                <option value="2" {{ $propertyDetail->property_type == 2 ? 'selected' : '' }}>Buying</option>
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
                                    <option value = ""> Selerct Category</option>
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
                                <input type="number"  class="form-control @error('guest_count') is-invalid @enderror" value = "{{$propertyDetail->guest_count}}" name = "guest_count" aria-describedby="" placeholder="Maximum guest allowed">
                                @if($errors->has('guest_count'))
                                <div class="invalid-feedback">
                                    {{$errors->first('guest_count')}}
                                </div>
                                @endif            
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <input type="number"   class="form-control @error('no_of_bedroom') is-invalid @enderror" value = "{{$propertyDetail->no_of_bedroom}}"  name = "no_of_bedroom" aria-describedby="" placeholder="No of Bedrooms">            
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

                                <input type="date" name="built_in_year" class="form-control datepicker @error('built_in_year') is-invalid @enderror" value = "{{$propertyDetail->built_in_year}}" value="" id="built_in_year" >            
                                @if($errors->has('built_in_year'))
                                <div class="invalid-feedback">
                                    {{$errors->first('built_in_year')}}
                                </div>
                                @endif 
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-4 pt-4">
                                <input type="number"  class="form-control @error('no_of_kitchen') is-invalid @enderror" name = "no_of_kitchen" value = "{{$propertyDetail->no_of_kitchen}}"  aria-describedby="" placeholder="Enter No of Kitchen">            
                                @if($errors->has('no_of_kitchen'))
                                <div class="invalid-feedback">
                                    {{$errors->first('no_of_kitchen')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <input type="number"  class="form-control @error('no_of_bathroom') is-invalid @enderror" name = "no_of_bathroom" value = "{{$propertyDetail->no_of_bathroom}}"  aria-describedby="" placeholder="Enter No of Bathrooms">            
                                @if($errors->has('no_of_bathroom'))
                                <div class="invalid-feedback">
                                    {{$errors->first('no_of_bathroom')}}
                                </div>
                                @endif
                            </div>
                        </div>                       
                       
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <input type="number"  class="form-control @error('no_of_balcony') is-invalid @enderror" value = "{{$propertyDetail->no_of_balcony}}"  name = "no_of_balcony"  aria-describedby="" placeholder="Enter No of Balcony">            
                                @if($errors->has('no_of_balcony'))
                                <div class="invalid-feedback">
                                    {{$errors->first('no_of_balcony')}}
                                </div>
                                @endif  
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <input type="number"  class="form-control @error('property_area') is-invalid @enderror" value = "{{$propertyDetail->property_area}}" name ="property_area" aria-describedby="" placeholder=" Enter Property Area">            
                                @if($errors->has('property_area'))
                                <div class="invalid-feedback">
                                    {{$errors->first('property_area')}}
                                </div>
                                @endif    
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <input type="number"   class="form-control @error('no_of_floors') is-invalid @enderror" value = "{{$propertyDetail->no_of_floors}}" name = "no_of_floors"  aria-describedby="" placeholder="Enter Floor No">            
                                @if($errors->has('no_of_floors'))
                                <div class="invalid-feedback">
                                    {{$errors->first('no_of_floors')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <select name="property_condition" id="property_condition"  class="form-control ow">
                                <option value="1" {{ $propertyDetail->property_condition == 1 ? 'selected' : '' }}>New Home</option>
                                <option value="2" {{ $propertyDetail->property_condition == 2 ? 'selected' : '' }}>Good Condition</option>
                                <option value="3" {{ $propertyDetail->property_condition == 3 ? 'selected' : '' }}>Need Renocation</option>
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
                                      <option value="{{$list}}" @if($propertyDetail['country_code']==$list) selected @endif>
                                       {{$list}}</option>
                                  @endforeach
                                </select> 
                             <input type="text" class="form-control"  value="{{$propertyDetail->property_number}}" name="property_number" id="property_number" placeholder="Enter Contact Number" >  
                        </div>
                        @if($errors->has('property_number'))
                        <div class="invalid-feedback" style="display:block;">
                           {{$errors->first('property_number')}}
                        </div>
                        @endif         
                     </div>
                  </div>
                        <div class="col-sm-6">
                            <div class="mb-4">
                            <input type="email"  class="form-control @error('property_email') is-invalid @enderror" value="{{$propertyDetail->property_email}}"  name = "property_email"  aria-describedby="">
                        @if($errors->has('property_email'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_email')}}
                        </div>
                        @endif            
                       </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-4 position-relative address-group">
                                <input type="text" id="property_address" class="form-control pe-5 @error('property_address') is-invalid @enderror" name = "property_address" value = "{{$propertyDetail->property_address}}" aria-describedby="" placeholder="Address">   
                                <input type="hidden" name="property_latitude" id="property_latitude" value="" />
                                <input type="hidden" name="property_longitude" id="property_longitude" value="" />
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
                                <input type="number" class="form-control @error('property_price') is-invalid @enderror" name = "property_price" value = "{{$propertyDetail->property_price}}" aria-describedby="" placeholder="Enter Property Price">            
                                @if($errors->has('property_price'))
                                <div class="invalid-feedback">
                                    {{$errors->first('property_price')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <input type="file"  id="edit_property_image" class="form-control @error('property_image') is-invalid @enderror" name="property_image">            
                                @if($errors->has('property_image'))
                                <div class="invalid-feedback">
                                    {{$errors->first('property_image')}}
                                </div>
                                @endif
                                @if($propertyDetail->property_image!="")
                                <div class="edit_property_image_preview-box">
                                <img class="rounded-pill-box" id="edit_property_image_preview" src="{{url('/')}}/images/property/thumbnail/{{$propertyDetail->property_image}}">
                                </div>
                                @else
                                <img class="rounded-pill-box" src="{{url('/')}}/images/property/thumbnail/user-image-01.jpg" id="edit_property_image_preview">
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                <label> Property Features</label>

                                    <select class="form-control js-edit-example-tokenizer" name="property_features[]" multiple="multiple" id="property_features" >
                                        @foreach($featuresArray as $features)
                                        <option Selected="Selected"> 
                                            {{$features}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-4">            
                                <textarea class="form-control @error('meta_title') is-invalid @enderror" name = "meta_title"   rows="3" placeholder="Meta Title">{{$propertyDetail->meta_title}}</textarea>         
                                @if($errors->has('meta_title'))
                                <div class="invalid-feedback">
                                    {{$errors->first('meta_title')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-4">            
                                <textarea class="form-control @error('meta_keywords') is-invalid @enderror" name = "meta_keywords"  rows="3" placeholder="Meta keywords">{{$propertyDetail->meta_keywords}}</textarea>         
                                @if($errors->has('meta_keywords'))
                                <div class="invalid-feedback">
                                    {{$errors->first('meta_keywords')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-4">            
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" name = "meta_description"   rows="3" placeholder="Meta Description">{{$propertyDetail->meta_description}}</textarea>         
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
                            <textarea class="form-control @error('property_description') is-invalid @enderror" name = "property_description"   rows="3" placeholder="Property Description">{{$propertyDetail->property_description}}</textarea>
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
                 
                            <div class="row"> 
                                <div class="col-sm-6 mb-4">                    
                                    <label>Pool</label>
                                    <select class="form-select form-control @error('no_of_pool') is-invalid @enderror " name="no_of_pool"  aria-label="Default select example" >
                                    
                                    <option value="1" {{ $propertyDetail->no_of_pool == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ $propertyDetail->no_of_pool == 0 ? 'selected' : '' }}>No</option>
                                    
                                    
                                    </select>
                                    @if($errors->has('no_of_pool'))
                                    <div class="invalid-feedback">
                                    {{$errors->first('no_of_pool')}}
                                    </div>
                                    @endif           
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label>Lift</label>
                                    <select name="no_of_lift"   class="form-select form-control @error('no_of_lift') is-invalid @enderror ">
                                    <option value="1" {{ $propertyDetail->no_of_lift == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $propertyDetail->no_of_lift == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                    @if($errors->has('no_of_lift'))
                                    <div class="invalid-feedback">
                                        {{$errors->first('no_of_lift')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <div class="">
                                        <label>Garden</label>
                                            <select name="no_of_garden"   class="form-select form-control @error('no_of_garden') is-invalid @enderror ">
                                            <option value="1" {{ $propertyDetail->no_of_garden == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ $propertyDetail->no_of_garden == 0 ? 'selected' : '' }}>No</option>
                                            </select>
                                            @if($errors->has('no_of_garden'))
                                            <div class="invalid-feedback">
                                                {{$errors->first('no_of_garden')}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                    <div class="col-sm-6 mb-4">
                                        <div class="">
                                        <label>Parking</label>
                                            <select name="no_of_parking"   class="form-select form-control @error('no_of_parking') is-invalid @enderror ">
                                            <option value="1" {{ $propertyDetail->no_of_parking == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ $propertyDetail->no_of_parking == 0 ? 'selected' : '' }}>No</option>
                                            </select>
                                            @if($errors->has('no_of_parking'))
                                            <div class="invalid-feedback">
                                                {{$errors->first('no_of_parking')}}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                        </div>




                               
                        
                         
                <div class="col-sm-6">
                    <div class="mb-4 row-box-img">
                        <input type="file" id="edit_property_gallery_image" class="form-control @error('property_gallery_image') is-invalid @enderror" name="property_gallery_image[]" multiple="multiple"> 
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
                    <div class="mt-1 text-center row">
                          @foreach($propertyGallery as $gallery) 
                        <div class = "removeimage-box removeimage_{{$gallery['id']}}" >
                            <img class="rounded-pill-box" src="{{url('/')}}/images/property/gallery/{{$gallery['image']}}">
                            <button type="button" class="deleteProduct delete_property_gallery" id="delete_property_gallery"  data-id= "{{$gallery['id']}}" data-property= "{{$gallery['property_id']}}" class ="btn-btn-delete delete_image" >
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12.0005" cy="11.999" r="8.5" fill="white" stroke="#8DC83E"/>
                                    <path d="M8.1378 16.5742L7.42529 15.8617L15.9003 7.38672L16.6128 8.09922L8.1378 16.5742Z" fill="#8DC83E"/>
                                    <path d="M15.9003 16.5742L7.42529 8.09922L8.1378 7.38672L16.6128 15.8617L15.9003 16.5742Z" fill="#8DC83E"/>
                                </svg>
                            </button>
                        </div>
                        @endforeach
                        <div class="images-preview-div" id="images-preview-div"> </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 justify-content-center pb-4">
                    <button type="submit" class="btn btn-primary w-auto mt-0 mx-0">Update</button>
                    <a href ="{{route('buyer.property')}}" button type="button" class="btn btn-danger cancel_btn  mx-0 mt-0 px-3">Back</a>
                    
                </div>
                </form>

        </div>
    </div>
</div>
</div>
</div>
</div>
</body>
</html> 
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/script.js')}}"></script>
<script>
    $(document).ready(function(){
       
      var property_typeonload="{{$propertyDetail->property_type}}";
      
      var property_price_type="{{$propertyDetail->property_price_type}}";
      
      var property_category="{{$propertyDetail->property_category}}";
      
      var optionhtmlonload='<option value="">Select price type</option>';
    
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
    
        optionhtmlonload+='<option '+selectoption4+' value="4">Per Month</option>';
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
    });
</script>
<script type="text/javascript">
    $(document).ready(function (e) {
    $('#edit_property_image').change(function(){
    let reader = new FileReader();
    reader.onload = (e) => {
    
    $('#edit_property_image_preview').attr('src', e.target.result);
    
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
          (filesAmount);
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
    
                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                }
    
                reader.readAsDataURL(input.files[i]);
            }
        }
    
    };
    $('#edit_property_gallery_image').on('change', function() {
       $('#images-preview-div').html('');
        previewImages(this, 'div.images-preview-div');
    
    
    });
    });
</script>