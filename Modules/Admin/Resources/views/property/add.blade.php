@extends('admin::layouts.master')
@section('title', 'Add property')
@section('content')

@php 
  $property_owner_error="";
  $property_title_error="";
  $property_type_error="";
  $guest_count_error="";
  $bedroom_count_error="";
  $kitchen_count_error="";
  $bathroom_count_error="";
  $pool_count_error="";
  $garden_count_error="";
  $lift_count_error="";
  $parking_count_error="";
  $features_error="";
  $balcony_count_error="";
  $floors_count_error="";
  $property_condition_error="";
  $property_area_count_error="";
  $phone_number_error="";
  $address_error="";
  $email_error="";
  $price_error="";
  $price_type_error="";
  $property_category_error="";
  $property_image="";
  $meta_title_error="";
  $meta_description_error="";
  $meta_keywords_error="";
  $property_description_error="";
  $built_in_year_error="";
  $property_image_error="";
  @endphp

  @if (session()->has('valid_error'))
     @php $validationmessage=session()->get('valid_error'); @endphp
      @if($validationmessage!="" && isset($validationmessage['add_by']))
      @php $property_owner_error=$validationmessage['add_by']; @endphp
      @else
      @php $property_owner_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['title']))
      @php $property_title_error=$validationmessage['title']; @endphp
      @else
      @php $property_title_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_type']))
      @php $property_type_error=$validationmessage['property_type']; @endphp
      @else
      @php $property_type_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_category']))
      @php $property_category_error=$validationmessage['property_category']; @endphp
      @else
      @php $property_category_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['guest_count']))
      @php $guest_count_error=$validationmessage['guest_count']; @endphp
      @else
      @php $guest_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_bedroom']))
      @php $bedroom_count_error=$validationmessage['no_of_bedroom']; @endphp
      @else
      @php $bedroom_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_kitchen']))
      @php $kitchen_count_error=$validationmessage['no_of_kitchen']; @endphp
      @else
      @php $kitchen_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_bathroom']))
      @php $bathroom_count_error=$validationmessage['no_of_bathroom']; @endphp
      @else
      @php $bathroom_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_pool']))
      @php $pool_count_error=$validationmessage['no_of_pool']; @endphp
      @else
      @php $pool_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_garden']))
      @php $garden_count_error=$validationmessage['no_of_garden']; @endphp
      @else
      @php $garden_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_lift']))
      @php $lift_count_error=$validationmessage['no_of_lift']; @endphp
      @else
      @php $lift_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_parking']))
      @php $parking_count_error=$validationmessage['no_of_parking']; @endphp
      @else
      @php $parking_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_balcony']))
      @php $balcony_count_error=$validationmessage['no_of_balcony']; @endphp
      @else
      @php $balcony_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_area']))
      @php $property_area_count_error=$validationmessage['property_area']; @endphp
      @else
      @php $property_area_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['no_of_floors']))
      @php $floors_count_error=$validationmessage['no_of_floors']; @endphp
      @else
      @php $floors_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_condition']))
      @php $property_condition_error=$validationmessage['property_condition']; @endphp
      @else
      @php $property_condition_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_area']))
      @php $property_area_count_error=$validationmessage['property_area']; @endphp
      @else
      @php $property_area_count_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_number']))
      @php $phone_number_error=$validationmessage['property_number']; @endphp
      @else
      @php $phone_number_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_email']))
      @php $email_error=$validationmessage['property_email']; @endphp
      @else
      @php $email_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_address']))
      @php $address_error=$validationmessage['property_address']; @endphp
      @else
      @php $address_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_address']))
      @php $price_error=$validationmessage['property_address']; @endphp
      @else
      @php $price_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_price_type']))
      @php $price_type_error=$validationmessage['property_price_type']; @endphp
      @else
      @php $price_type_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['meta_title']))
      @php $meta_title_error=$validationmessage['meta_title']; @endphp
      @else
      @php $meta_title_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['meta_keywords']))
      @php $meta_keywords_error=$validationmessage['meta_keywords']; @endphp
      @else
      @php $meta_keywords_error=""; @endphp
      @endif


      @if($validationmessage!="" && isset($validationmessage['meta_description']))
      @php $meta_description_error=$validationmessage['meta_description']; @endphp
      @else
      @php $meta_description_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['property_description']))
      @php $property_description_error=$validationmessage['property_description']; @endphp
      @else
      @php $property_description_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['built_in_year']))
      @php $built_in_year_error=$validationmessage['built_in_year']; @endphp
      @else
      @php $built_in_year_error=""; @endphp
      @endif
      

      @if($validationmessage!="" && isset($validationmessage['property_image']))
      @php $property_image_error=$validationmessage['property_image']; @endphp
      @else
      @php $property_image_error=""; @endphp
      @endif

  @endif
 
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
                                    <h4>Add Property</h4>
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
                                     <li class="breadcrumb-item"><a href="{{route('admin-property-add')}}">Add Property</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->
                @if($message = Session::get('success'))
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
                              
                                <div class="card-block">
                                    <form method="POST" action="{{route('admin-property-save')}}" name="SavepropertyForm" id="SavepropertyForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="font-weight-bold">Property Owners<span style="color:red;">*</span></label>
                                      <select class="form-control livesearch" id="add_by" name="add_by">
                                      <option value="">Select Owner</option>
                                      @foreach($PropOwnerList as $k=>$property)
                                          <option value="{{$property->id}}  @if (old('add_by') == $property->id) {{ 'selected' }} @endif">{{$property->name}}</option>
                                      @endforeach
                                      </select>
                                       @if($property_owner_error!="")
                                      <span class="messages">
                                          <strong>{{ $property_owner_error }}</strong>
                                      </span>
                                  @endif  
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="font-weight-bold">Property Title<span style="color:red;">*</span></label>
                                      <input type="text" class="form-control" value="{{old('title')}}"  name="title" id="title"  placeholder="Property Title">
                                     @if($property_title_error!="")
                                          <span class="messages">
                                              <strong>{{ $property_title_error }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>
                                           
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Property Type<span style="color:red;">*</span></label>
                                    <select class="form-control" name="property_type" id="property_type">
                                   <option value="">Select Project Type</option>
                                  
                                   <option value="1" @if (old('property_type') == "1") {{ 'selected' }} @endif  >Renting</option>
                                   <option value="2" @if (old('property_type') == "2") {{ 'selected' }} @endif>Buying</option>
                                   
                                    </select>
                                     @if($property_type_error!="")
                                    <span class="messages">
                                        <strong>{{ $property_type_error }}</strong>
                                    </span>
                                @endif  
                                </div>
                            </div>

                        <div class="col-md-6">
                          <div class="form-group">
                              <label class="font-weight-bold">Category<span style="color:red;">*</span></label>
                              <select name="property_category" class="form-control" id="property_category">
                                  <option value="">Select Category</option>
                              </select>
                              @if($property_category_error!="")
                                  <span class="messages">
                                      <strong>{{ $property_category_error }}</strong>
                                  </span>
                              @endif
                             
                          </div>
                      </div>
                                           
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Maximum Guests Allowed<span style="color:red;">*</span></label>
                                    <input type="text" name="guest_count" class="form-control" value="{{old('guest_count')}}" placeholder="Enter no. of guest allowed"  id="guest-count" >
                                    @if($guest_count_error!="")
                                        <span class="messages">
                                            <strong>{{ $guest_count_error }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">No. of Bedroom<span style="color:red;">*</span></label>
                                    <input type="text" name="no_of_bedroom" class="form-control" value="{{old('no_of_bedroom')}}" placeholder="Enter no. of bedroom"  id="no_of_bedroom" >
                                    @if($bedroom_count_error!="")
                                        <span class="messages">
                                            <strong>{{ $bedroom_count_error }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            



                          
                          <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Built In Year<span style="color:red;">*</span></label>
                                    <input style="padding: 8px 10px; " type="text" name="built_in_year" class="form-control datepicker" value="{{old('built_in_year')}}" placeholder="Enter Built In Year"  id="built_in_year" >
                                    @if($built_in_year_error!="")
                                        <span class="messages">
                                            <strong>{{$built_in_year_error }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                          <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">No. of kitchen<span style="color:red;">*</span></label>
                                    <input type="text" name="no_of_kitchen" class="form-control" value="{{old('no_of_kitchen')}}" placeholder="Enter no. of kitchen"  id="no_of_kitchen" >
                                    @if($kitchen_count_error!="")
                                        <span class="messages">
                                            <strong>{{ $kitchen_count_error }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                                          
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="font-weight-bold">No. of Bathrooms<span style="color:red;">*</span></label>
                                  <input type="text" class="form-control" value="{{old('no_of_bathroom')}}" name="no_of_bathroom" id="no_of_bathroom" placeholder="Enter No. of bathrooms">
                                  @if($bathroom_count_error!="")
                                      <span class="messages">
                                          <strong>{{ $bathroom_count_error }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Garden<span style="color:red;">*</span></label>
                                    <select class="form-control" name="no_of_garden" id="no_of_garden">
                                   <option value="">Select Garden</option>
                                  
                                   <option value="1" @if (old('no_of_garden') == "1") {{ 'selected' }} @endif  >Yes</option>
                                   <option value="0" @if (old('no_of_garden') == "0") {{ 'selected' }} @endif>No</option>
                                   
                                    </select>
                                     @if($garden_count_error!="")
                                    <span class="messages">
                                        <strong>{{ $garden_count_error }}</strong>
                                    </span>
                                @endif  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Pool<span style="color:red;">*</span></label>
                                    <select class="form-control" name="no_of_pool" id="no_of_pool">
                                   <option value="">Select Pool</option>
                                  
                                   <option value="1" @if (old('no_of_pool') == "1") {{ 'selected' }} @endif  >Yes</option>
                                   <option value="0" @if (old('no_of_pool') == "0") {{ 'selected' }} @endif>No</option>
                                   
                                    </select>
                                     @if($pool_count_error!="")
                                    <span class="messages">
                                        <strong>{{ $pool_count_error }}</strong>
                                    </span>
                                @endif  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Parking<span style="color:red;">*</span></label>
                                    <select class="form-control" name="no_of_parking" id="no_of_parking">
                                   <option value="">Select Parking</option>
                                  
                                  <option value="1" @if (old('no_of_parking') == "1") {{ 'selected' }} @endif  >Yes</option>
                                  <option value="0" @if (old('no_of_parking') == "0") {{ 'selected' }} @endif>No</option>
                                   
                                    </select>
                                     @if($parking_count_error!="")
                                    <span class="messages">
                                        <strong>{{ $parking_count_error }}</strong>
                                    </span>
                                @endif  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Lift<span style="color:red;">*</span></label>
                                    <select class="form-control" name="no_of_lift" id="no_of_lift">
                                   <option value="">Select Lift</option>
                                  
                                   <option value="1" @if (old('no_of_lift') == "1") {{ 'selected' }} @endif  >Yes</option>
                                   <option value="0" @if (old('no_of_lift') == "0") {{ 'selected' }} @endif>No</option>
                                   
                                    </select>
                                     @if($lift_count_error!="")
                                    <span class="messages">
                                        <strong>{{ $lift_count_error }}</strong>
                                    </span>
                                @endif  
                                </div>
                            </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="font-weight-bold">Features</label>
                                  <select class="form-control js-example-tokenizer" name="features[]" multiple="multiple">
                                    
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="font-weight-bold">No. of Balcony<span style="color:red;">*</span></label>
                                  <input type="text" class="form-control" value="{{old('no_of_balcony')}}" name="no_of_balcony" id="no_of_balcony" placeholder="Enter No. of balcony">
                                  @if($balcony_count_error!="")
                                      <span class="messages">
                                          <strong>{{ $balcony_count_error }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Property Area <spanstyle="color:red;>(Sq. Ft.)*</span></label>
                                    <input type="text" class="form-control"  value="{{old('property_area')}}" name="property_area" id="property_area" placeholder="Enter property area">
                                         
                               
                                @if($property_area_count_error!="")
                                    <span class="messages">
                                        <strong>{{ $property_area_count_error }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <div class="col-md-6">
                              <div class="form-group">
                                  <label class="font-weight-bold">Floor No.<span style="color:red;">*</span></label>
                                  <input type="text" class="form-control" value="{{old('no_of_floors')}}" name="no_of_floors" id="no_of_floors" placeholder="Enter Floor No.">
                                  @if($floors_count_error!="")
                                      <span class="messages">
                                          <strong>{{ $floors_count_error }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="font-weight-bold">Property Condition<span style="color:red;">*</span></label>
                                  <select class="form-control" name="property_condition" id="property_condition">
                                    <option value="">Select Condition</option>
                                    @foreach($condition as $list)
                                    <option value="{{$list->id}}" @if (old('property_condition') == $list->id) {{ 'selected' }} @endif>{{$list->name}}</option>
                                    @endforeach
                                  </select>
                                  @if($property_condition_error!="")
                                      <span class="messages">
                                          <strong>{{ $property_condition_error }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>


                        <div class="col-md-6">
                            <div class="form-group country-select">
                                <label class="font-weight-bold">Contact Number<span style="color:red;">*</span></label>
                                <div class="d-flex input-wrap flex-wrap">
                                <select id="country_code" name="country_code" class=" form-control">
                                  @foreach($country_list as $list)
                                  <option value="{{$list}}">
                                      {{$list}}</option>
                                  @endforeach
                                </select>


                                <input type="text" class="form-control" value="{{old('property_number')}}" name="property_number" id="property_number" placeholder="Enter Contact Number" >
                              </div>
                                @if($phone_number_error!="")
                                    <span class="messages">
                                        <strong>{{ $phone_number_error }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Contact Email<span style="color:red;">*</span></label>
                                <input type="email" class="form-control" value="{{old('property_email')}}" name="property_email" id="property_email" placeholderF="Enter Contact Email">

                                @if($email_error!="")
                                    <span class="messages">
                                        <strong>{{ $email_error }}</strong>
                                    </span>
                                @endif
                                 
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Address<span style="color:red;">*</span></label>
                                <input type="text" class="form-control"  name="property_address" id="property_address" value="{{old('property_address')}}">
                                @if($address_error!="")
                                    <span class="messages" role="alert">
                                        <strong>{{ $address_error }}</strong>
                                    </span>
                                @endif
                                <input type="hidden" name="property_latitude" id="property_latitude" value="" />
                                <input type="hidden" name="property_longitude" id="property_longitude" value="" />
                            </div>
                        </div> 

                          <div class="col-md-6">
                          <div class="form-group">
                              <label class="font-weight-bold">Price type<span style="color:red;">*</span></label>
                              <select name="property_price_type" class="form-control" id="property_price_type">
                                  <option value="">Select price type</option>
                              </select>
                              @if($price_type_error!="")
                                  <span class="messages">
                                      <strong>{{ $price_type_error }}</strong>
                                  </span>
                              @endif
                             
                          </div>
                      </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Price <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="{{old('property_price')}}" name="property_price" id="property_price" placeholder="Enter Property Price" >
                                
                                @if($price_error!="")
                                    <span class="messages">
                                        <strong>{{ $price_error }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Property Featured Image<span style="color:red;">*</span></label>
                        <small></small>
                        <input type="file" class="form-control"  name="property_image" id="property_image"  onchange="preview_image()">
                        @if($property_image_error!="")
                             <span class="messages">
                                <strong>{{ $property_image_error }}</strong>
                            </span>
                        @endif
                        <div id="image_preview" style="display: none;"></div>
                    </div>
                </div>

              <div class="col-md-6">
                  <div class="form-group">
                      <label class="font-weight-bold">Meta Title</label>
                      <input type="text" class="form-control" value="{{old('meta_title')}}" name="meta_title" id="meta_title" placeholder="Enter Meta title">
                      @if($meta_title_error!="")
                          <span class="messages">
                              <strong>{{ $meta_title_error }}</strong>
                          </span>
                      @endif
                  </div>
              </div> 
                <div class="col-md-6">
                      <div class="form-group">
                          <label class="font-weight-bold">Meta keywords</label>
                          <input type="text" class="form-control" value="{{old('meta_keywords')}}" name="meta_keywords" id="meta_keywords" placeholder="Enter meta keywords">
                          @if($meta_keywords_error!="")
                              <span class="messages">
                                  <strong>{{ $meta_keywords_error }}</strong>
                              </span>
                          @endif
                      </div>
                  </div> 

              <div class="col-md-12">
                  <div class="form-group">
                      <label class="font-weight-bold">Meta Description<!-- <span style="color:red;">*</span> --></label>
                      <textarea class="ck-editor propertydesc" value="{{old('meta_description')}}" name="meta_description" id="meta_description" rows="5" cols="20"></textarea>
                      @if($meta_description_error!="")
                          <span class="messages">
                              <strong>{{ $meta_description_error }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
                                                               
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Property Description<span style="color:red;">*</span></label>
                        <textarea  class="ck-editor propertydesc" value="{{old('property_description')}}" name="property_description" id="property_description" rows="5" cols="20"></textarea>
                        @if($property_description_error!="")
                            <span class="messages">
                                <strong>{{ $property_description_error }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Property Gallery Image<span style="color:red;">*</span></label>
                        <small></small>
                        <input type="file" class="form-control"  name="property_gallery[]" multiple="multiple" id="property_gallery_image" accept="image/*" onchange="preview_multiple_image()">
                        @if($property_image_error!="")
                             <span class="messages">
                                <strong>{{ $property_image_error }}</strong>
                            </span>
                        @endif
                        <div id="property_gallery_image_preview">
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                        <button type="submit" id="submitBuyers"  class="btn btn-primary m-b-0">Save</button>

                        <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0 reset_form" onclick="clearData();">Reset</button>

                        <a href="{{route('admin-property-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                 
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

<script type="text/javascript">
    $('.livesearch').select2({});
</script>

<script type="text/javascript">

function preview_multiple_image() 
{
    
$('#property_gallery_image_preview').html("");
var total_file=document.getElementById("property_gallery_image").files.length;
if(total_file > 8)
{ 
  alert('upload only 8 property images');
}
else{
    for(var i=0;i<total_file;i++)
    {

      $('#property_gallery_image_preview').append("<div class='removeimage' id='removeimagediv_"+i+"' data-id='"+i+"'><img src='"+URL.createObjectURL(event.target.files[i])+"' height='150px' width='150px' class='img-fluid main_image_src mr-2'></div>");
     }
}

}

function preview_image() 
{
$('#image_preview').show();    
$('#image_preview').html("");
var total_file=document.getElementById("property_image").files.length;
for(var i=0;i<total_file;i++)
{

  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' height='150px' width='150px' class='img-fluid  mr-2'>");
 }

}


  $('.datepicker').datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'mm/yy',
});

  $(document).on('click','.removeimage',function(){
    var id=$(this).attr('data-id');
    $('#removeimagediv_'+id).remove();

    const galleryinput = document.getElementById('property_gallery_image');
    galleryinput.addEventListener('change', () => {
      const fileListArr = Array.from(galleryinput.files);
      console.log('fileListArr11',fileListArr);
      fileListArr.splice(1, 1);
      console.log('fileListArr122',fileListArr);
    });
  });

  $('#property_type').on('change',function(){
    var property_type=$(this).val();
    var optionhtml='<option value="">Select price type</option>';
    if(property_type==2)
    {
      optionhtml+='<option value="1">PerSq.Ft</option><option value="2">Fixed </option><option value="3">Persq.yard</option>';
    }
    else{
      optionhtml+='<option value="4">Per Month</option>';
    }

    $('#property_price_type').html(optionhtml);

     $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",property_type:property_type}, 
        url: "{{ route('admin-ajax-get-category-list') }}",
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
<script>

// CKEDITOR.replace( 'property_description' );
// CKEDITOR.replace( 'meta_description' );

// function clearData(){
//     for ( instance in CKEDITOR.instances ){
//         CKEDITOR.instances[instance].updateElement();
//     }
//     CKEDITOR.instances[instance].setData('');
 
// }

$(document).ready(function(){
    $(".js-example-placeholder-multiple").select2({
        placeholder: "Select"
    });

    $(".js-example-tokenizer").select2({
        tags: true,
        tokenSeparators: [',']
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
    $('#add_by').change(function(){
    var owner_id= $(this).val();
        $.ajax({
            type: "POST",
            data: {'owner_id':owner_id},
            url : "{{ route('admin-ajax-get-ownder-details') }}",
            dataType:'json',
            beforeSend: function(){
                $("#loading").show();
            },
            complete: function(){
                $("#loading").hide();
            },
            success:function(response){
                if(response.code==200){
                   $('#property_email').val(response.owner_email);
                   $('#property_number').val(response.owner_number);
                }else{
                    alert('error');
                }

            }
        });
});
    </script>



<script>
$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


   $("#SavepropertyForm").validate({  
        rules: {
            add_by:{
                required:true
            }, 
            title: {
                required: true
            },
            property_type:{
              required: true,
            },
            property_category:{
              required: true,
            },
            guest_count:{
                digits: true,
                required: true,

            },
            no_of_bedroom:{
                required: true,
                digits: true,
            },
            no_of_kitchen:{
                required: true,
                digits: true,
            },
            no_of_bathroom:{
                required: true,
                digits: true,
            },
            no_of_pool:{
                required: true,
            },
            no_of_garden:{
                required: true,
            },
            no_of_parking:{
                required: true,
            },
            no_of_lift:{
                required: true,
            },
            no_of_balcony:{
                digits: true,
                required: true,
            },
            built_in_year:{
                
                required: true,
            },
            no_of_floors:{
              required: true,
              digits: true,
            },
            property_area:{
                digits: true,
            },
            property_condition:{
              required: true,
            },
            property_number:{
                required: true,
                digits: true,
            },
            property_email:{
                required: true,
                email: true,
            },
            property_address:{
                required: true,
            },

            property_image:{
                required: true,
                accept: true,
            },

            property_description:{
                required: true,
            },
            property_area:{
                required: true,
            },
            property_price_type:{

            required: true,
                },
            property_price:{

                required: true,
            },
        },
        messages: {
            add_by: {
                required: "Please choose owner.",
            },
            title: {
                required: "Please enter property title",
            },
            built_in_year: {
                required: "This field is required ",
            },
            property_type: {
                required: "Please select property type",
            },
            property_description: {
                required: "This field is required",
            },
            property_area: {
                required: "This field is required",
            },
            property_price_type: {
                required: "This field is required",
            },

            property_category: {
                required: "Please select property category",
            },
            guest_count: {
                required: "Please enter guest count",
                digits: "guest count should contains only digits.",
            },
            no_of_bedroom: {
                required: "Please enter no. of bedroom",
                digits: "no. of bedroom value should contains only digits.",
            },
            built_in_year: {
                required: "Please select built-in year",
            },
            no_of_kitchen: {
                required: "Please enter no. of kitchen",
                digits: "no. of kitchen value should contains only digits.",
            },
            no_of_bathroom: {
                required: "Please enter no. of bathroom",
                digits: "no. of bathroom value should contains only digits.",
            },
            no_of_pool: {
                required: "This field is required",
                digits: "no. of pool value should contains only digits.",
            },
            no_of_garden: {
                required: "This field is required",
                digits: "no. of garden value should contains only digits.",
            },
            no_of_parking: {
                required: "This field is required",
                digits: "no. of garden value should contains only digits.",
            },
            no_of_lift: {
                required: "This field is required",
                digits: "no. of garden value should contains only digits.",
            },
            no_of_balcony: {
                required: "Please enter no. of balcony",
                digits: "no. of balcony value should contains only digits.",
            },
            no_of_floors: {
                required: "Please enter floor no.",
                digits: "floor no. should contains only digits.",
            },
            property_condition: {
                required: "Please select property condition",
            },
            property_area: {
                required: "Please enter property area",
                digits: "property area value should contains only digits.",
            },
            property_number: {
                required: "Please enter contact number",
                digits: "contact number should contains only digits.",
            },
            property_email: {
                required: "Please enter conatct email",
                email: "Please enter valid contact email address.",
            },
            property_address: {
                required: "Please enter property address",
            },
            property_price: {
                required: "Please enter property price",
            },
            property_price_type: {
                required: "Please select property price type",
            },
            property_image: {
                required: "Please select property thumbnail image",
                accept: "only image files allowed.",
            },
        },
        submitHandler: function(form) 
            {
                 
                $("#loading").show();
                $("#submitBuyers").hide();
                 form.submit();
            },
             invalidHandler: function(){
                  $("#submitBuyers").show();
                  $("#loading").hide();
        }
  });

   $("#submitBuyers").on('click',function(){
        $("#SavepropertyForm").submit();
        return false;
    });

</script>

@endsection
