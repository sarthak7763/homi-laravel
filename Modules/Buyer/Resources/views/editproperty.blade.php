@extends('buyer::layouts.master')
@section('content')
<div class="col-lg-9">
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
            <div class="row">
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
                        <input type="text" class="form-control @error('guest_count') is-invalid @enderror" value = "{{$propertyDetail->guest_count}}" name = "guest_count" aria-describedby="" placeholder="Maximum guest allowed">
                        @if($errors->has('guest_count'))
                        <div class="invalid-feedback">
                           {{$errors->first('guest_count')}}
                        </div>
                        @endif            
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_bedroom') is-invalid @enderror" value = "{{$propertyDetail->no_of_bedroom}}"  name = "no_of_bedroom" aria-describedby="" placeholder="No of Bedrooms">            
                        @if($errors->has('no_of_bedroom'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_bedroom')}}
                        </div>
                        @endif 
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="date" name="built_in_year" class="form-control datepicker @error('built_in_year') is-invalid @enderror" value = "{{$propertyDetail->built_in_year}}" value="" placeholder="Enter Built In Year"  id="built_in_year" >            
                        @if($errors->has('built_in_year'))
                        <div class="invalid-feedback">
                           {{$errors->first('built_in_year')}}
                        </div>
                        @endif 
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_kitchen') is-invalid @enderror" name = "no_of_kitchen" value = "{{$propertyDetail->no_of_kitchen}}"  aria-describedby="" placeholder="Enter No of Kitchen">            
                        @if($errors->has('no_of_kitchen'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_kitchen')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_bathroom') is-invalid @enderror" name = "no_of_bathroom" value = "{{$propertyDetail->no_of_bathroom}}"  aria-describedby="" placeholder="Enter No of Bathrooms">            
                        @if($errors->has('no_of_bathroom'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_bathroom')}}
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="mb-4 ">
                        <label>Pool</label>
                        <input class="form-check-input" type="checkbox" name="chk_pool"  value="" @if (isset($propertyDetail)) @if ($propertyDetail->no_of_pool==1) checked @endif @endif id="">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="mb-4">
                        <label>Lift</label>
                        <input class="form-check-input" type="checkbox" name="chk_lift"  value="" @if (isset($propertyDetail)) @if ($propertyDetail->no_of_lift==1) checked @endif @endif id="">           
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="mb-4">
                        <label>Garden</label>
                        <input class="form-check-input" type="checkbox" name="chk_garden"  value="" @if (isset($propertyDetail)) @if ($propertyDetail->no_of_garden==1) checked @endif @endif id="">           
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="mb-4">
                        <label>Parking</label>
                        <input class="form-check-input" type="checkbox" name="chk_parking"  value="" @if (isset($propertyDetail)) @if ($propertyDetail->no_of_parking==1) checked @endif @endif id="">           
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_balcony') is-invalid @enderror" value = "{{$propertyDetail->no_of_balcony}}"  name = "no_of_balcony"  aria-describedby="" placeholder="Enter No of Balcony">            
                        @if($errors->has('no_of_balcony'))
                        <div class="invalid-feedback">
                           {{$errors->first('no_of_balcony')}}
                        </div>
                        @endif  
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('property_area') is-invalid @enderror" value = "{{$propertyDetail->property_area}}" name ="property_area" aria-describedby="" placeholder=" Enter Property Area">            
                        @if($errors->has('property_area'))
                        <div class="invalid-feedback">
                           {{$errors->first('property_area')}}
                        </div>
                        @endif    
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">
                        <input type="text" class="form-control @error('no_of_floors') is-invalid @enderror" value = "{{$propertyDetail->no_of_floors}}" name = "no_of_floors"  aria-describedby="" placeholder="Enter Floor No">            
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
                     <div class="form-group country-select">
                        <input type="text" class="form-control" readonoly name = "property_number" value="{{$propertyDetail->property_number}} " readonly   aria-describedby="" placeholder="Enter Contact No" id = "property_number">            
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="mb-4">            
                        <input type="text" class="form-control" readonly value="{{$propertyDetail->property_email}}" name = "property_email" readonly  aria-describedby="" placeholder="Enter Contact Email">            
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="mb-4 position-relative address-group">
                        <input type="text" class="form-control pe-5 @error('property_address') is-invalid @enderror" name = "property_address" value = "{{$propertyDetail->property_address}}" aria-describedby="" placeholder="Address">   
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
                        <input type="text" class="form-control @error('property_price') is-invalid @enderror" name = "property_price" value = "{{$propertyDetail->property_price}}" aria-describedby="" placeholder="Enter Property Price">            
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
                        <img class="rounded-pill" id="edit_property_image_preview" src="{{url('/')}}/images/property/thumbnail/{{$propertyDetail->property_image}}">
                        @else
                        <img class="rounded-pill" src="{{url('/')}}/images/property/thumbnail/user-image-01.jpg" id="edit_property_image_preview">
                        @endif
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-12">
                        <div class="mb-4">
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
                  <div class="col-6">
                     <div class="mb-4">            
                        <textarea class="form-control" name = "meta_title"   rows="3" placeholder="Meta Title">{{$propertyDetail->meta_title}}</textarea>         
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="mb-4">            
                        <textarea class="form-control" name = "meta_keywords"  rows="3" placeholder="Meta keywords">{{$propertyDetail->meta_keywords}}</textarea>         
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="mb-4">            
                        <textarea class="form-control" name = "meta_description"   rows="3" placeholder="Meta Description">{{$propertyDetail->meta_description}}</textarea>         
                     </div>
                  </div>
               </div>
               <div class="col-12">
                  <div class="mb-4">            
                     <textarea class="form-control" name = "property_description"   rows="3" placeholder="Property Description">{{$propertyDetail->property_description}}</textarea>
                  </div>
               </div>
            </div>
            <div>
            </div>
            <div class="col-sm-6">
               <div class="mb-4">
                  <input type="file" id="edit_property_gallery_image" class="form-control @error('property_gallery_image') is-invalid @enderror" name="property_gallery_image[]" multiple="multiple"> 
                  @foreach($propertyGallery as $gallery) 
                  <div class = "removeimage_{{$gallery['id']}}" >
                     <img class="rounded-pill" src="{{url('/')}}/images/property/gallery/{{$gallery['image']}}">
                     <button type="button" class="deleteProduct delete_property_gallery" id="delete_property_gallery"  data-id= "{{$gallery['id']}}" data-property= "{{$gallery['property_id']}}" class ="btn-btn-delete delete_image" >Delete Image</button>
                  </div>
                  @endforeach
               </div>
            </div>
            <div class="col-md-12">
               <div class="mt-1 text-center">
                  <div class="images-preview-div"> </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-5 mb-4">
                  <div class="thumbnail-image text-center rounded-6" name = "">
                     <span>
                        <svg width="40" height="39" viewBox="0 0 40 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M9.58333 27.7999C10.1356 27.7999 10.5833 27.3522 10.5833 26.7999C10.5833 26.2477 10.1356 25.7999 9.58333 25.7999V27.7999ZM7.75148 12.5743L7.94175 13.556C8.21269 13.5035 8.44989 13.3413 8.59718 13.1079C8.74446 12.8745 8.78874 12.5906 8.71952 12.3235L7.75148 12.5743ZM28.1254 8.80147L27.1519 9.02996C27.2594 9.4881 27.6718 9.80928 28.1423 9.80132L28.1254 8.80147ZM30.2439 25.635C29.6999 25.7304 29.3363 26.2487 29.4317 26.7927C29.5271 27.3367 30.0454 27.7003 30.5894 27.6049L30.2439 25.635ZM25.5962 22.1566C26.0141 22.5176 26.6456 22.4716 27.0067 22.0537C27.3678 21.6357 27.3217 21.0043 26.9038 20.6432L25.5962 22.1566ZM20.6538 15.2431C20.2359 14.882 19.6044 14.9281 19.2433 15.346C18.8822 15.7639 18.9283 16.3954 19.3462 16.7565L20.6538 15.2431ZM20.6538 16.7565C21.0717 16.3954 21.1178 15.7639 20.7567 15.346C20.3956 14.9281 19.7641 14.882 19.3462 15.2431L20.6538 16.7565ZM13.0962 20.6432C12.6783 21.0043 12.6322 21.6357 12.9933 22.0537C13.3544 22.4716 13.9859 22.5176 14.4038 22.1566L13.0962 20.6432ZM21 15.9998C21 15.4475 20.5523 14.9998 20 14.9998C19.4477 14.9998 19 15.4475 19 15.9998H21ZM19 37.6001C19 38.1524 19.4477 38.6001 20 38.6001C20.5523 38.6001 21 38.1524 21 37.6001H19ZM9.58333 25.7999C5.39105 25.7999 2.25 22.8918 2.25 19.5998H0.25C0.25 24.2608 4.57086 27.7999 9.58333 27.7999V25.7999ZM2.25 19.5998C2.25 16.7516 4.57871 14.2078 7.94175 13.556L7.56121 11.5925C3.482 12.3831 0.25 15.5824 0.25 19.5998H2.25ZM8.71952 12.3235C8.5758 11.7687 8.5 11.1922 8.5 10.5997H6.5C6.5 11.3639 6.59791 12.109 6.78344 12.8251L8.71952 12.3235ZM8.5 10.5997C8.5 6.31359 12.5738 2.59961 17.9167 2.59961V0.599609C11.7536 0.599609 6.5 4.94462 6.5 10.5997H8.5ZM17.9167 2.59961C22.5801 2.59961 26.3124 5.45297 27.1519 9.02996L29.099 8.57298C28.0097 3.93203 23.3336 0.599609 17.9167 0.599609V2.59961ZM28.1423 9.80132C28.2059 9.80025 28.2695 9.7997 28.3333 9.7997V7.7997C28.258 7.7997 28.1832 7.80035 28.1085 7.80161L28.1423 9.80132ZM28.3333 9.7997C33.6762 9.7997 37.75 13.5137 37.75 17.7998H39.75C39.75 12.1447 34.4963 7.7997 28.3333 7.7997V9.7997ZM37.75 17.7998C37.75 21.5603 34.6352 24.8647 30.2439 25.635L30.5894 27.6049C35.7073 26.7072 39.75 22.7479 39.75 17.7998H37.75ZM26.9038 20.6432L20.6538 15.2431L19.3462 16.7565L25.5962 22.1566L26.9038 20.6432ZM19.3462 15.2431L13.0962 20.6432L14.4038 22.1566L20.6538 16.7565L19.3462 15.2431ZM19 15.9998V37.6001H21V15.9998H19Z" fill="#124868"/>
                        </svg>
                     </span>
                     <h3>Upload Thumbnail Image</h3>
                     <p>Drag and Drop or Browse</p>
                  </div>
               </div>
               <div class="col-md-7 mb-4">
                  <div class="thumbnail-image text-center rounded-6" name = "">
                     <span>
                        <svg width="40" height="39" viewBox="0 0 40 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M9.58333 27.7999C10.1356 27.7999 10.5833 27.3522 10.5833 26.7999C10.5833 26.2477 10.1356 25.7999 9.58333 25.7999V27.7999ZM7.75148 12.5743L7.94175 13.556C8.21269 13.5035 8.44989 13.3413 8.59718 13.1079C8.74446 12.8745 8.78874 12.5906 8.71952 12.3235L7.75148 12.5743ZM28.1254 8.80147L27.1519 9.02996C27.2594 9.4881 27.6718 9.80928 28.1423 9.80132L28.1254 8.80147ZM30.2439 25.635C29.6999 25.7304 29.3363 26.2487 29.4317 26.7927C29.5271 27.3367 30.0454 27.7003 30.5894 27.6049L30.2439 25.635ZM25.5962 22.1566C26.0141 22.5176 26.6456 22.4716 27.0067 22.0537C27.3678 21.6357 27.3217 21.0043 26.9038 20.6432L25.5962 22.1566ZM20.6538 15.2431C20.2359 14.882 19.6044 14.9281 19.2433 15.346C18.8822 15.7639 18.9283 16.3954 19.3462 16.7565L20.6538 15.2431ZM20.6538 16.7565C21.0717 16.3954 21.1178 15.7639 20.7567 15.346C20.3956 14.9281 19.7641 14.882 19.3462 15.2431L20.6538 16.7565ZM13.0962 20.6432C12.6783 21.0043 12.6322 21.6357 12.9933 22.0537C13.3544 22.4716 13.9859 22.5176 14.4038 22.1566L13.0962 20.6432ZM21 15.9998C21 15.4475 20.5523 14.9998 20 14.9998C19.4477 14.9998 19 15.4475 19 15.9998H21ZM19 37.6001C19 38.1524 19.4477 38.6001 20 38.6001C20.5523 38.6001 21 38.1524 21 37.6001H19ZM9.58333 25.7999C5.39105 25.7999 2.25 22.8918 2.25 19.5998H0.25C0.25 24.2608 4.57086 27.7999 9.58333 27.7999V25.7999ZM2.25 19.5998C2.25 16.7516 4.57871 14.2078 7.94175 13.556L7.56121 11.5925C3.482 12.3831 0.25 15.5824 0.25 19.5998H2.25ZM8.71952 12.3235C8.5758 11.7687 8.5 11.1922 8.5 10.5997H6.5C6.5 11.3639 6.59791 12.109 6.78344 12.8251L8.71952 12.3235ZM8.5 10.5997C8.5 6.31359 12.5738 2.59961 17.9167 2.59961V0.599609C11.7536 0.599609 6.5 4.94462 6.5 10.5997H8.5ZM17.9167 2.59961C22.5801 2.59961 26.3124 5.45297 27.1519 9.02996L29.099 8.57298C28.0097 3.93203 23.3336 0.599609 17.9167 0.599609V2.59961ZM28.1423 9.80132C28.2059 9.80025 28.2695 9.7997 28.3333 9.7997V7.7997C28.258 7.7997 28.1832 7.80035 28.1085 7.80161L28.1423 9.80132ZM28.3333 9.7997C33.6762 9.7997 37.75 13.5137 37.75 17.7998H39.75C39.75 12.1447 34.4963 7.7997 28.3333 7.7997V9.7997ZM37.75 17.7998C37.75 21.5603 34.6352 24.8647 30.2439 25.635L30.5894 27.6049C35.7073 26.7072 39.75 22.7479 39.75 17.7998H37.75ZM26.9038 20.6432L20.6538 15.2431L19.3462 16.7565L25.5962 22.1566L26.9038 20.6432ZM19.3462 15.2431L13.0962 20.6432L14.4038 22.1566L20.6538 16.7565L19.3462 15.2431ZM19 15.9998V37.6001H21V15.9998H19Z" fill="#124868"/>
                        </svg>
                     </span>
                     <h3>Upload Image</h3>
                     <p>
                        Drag and Drop or Browse
                        (Allow maximum 8 images format allowed will be JPEG, PNG)
                     </p>
                  </div>
               </div>
            </div>
            <button type="submit" class="btn btn-primary w-auto">Update</button>
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
         alert(filesAmount);
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
      alert('heeelo');
       previewImages(this, 'div.images-preview-div');


   });
   });
</script>