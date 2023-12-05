@extends('buyer::layouts.master')
@section('content')
<style type="text/css">
   .carousel-item img {
   height: 300px;
   object-fit: cover;
   object-position: center;
   }
</style>
<div class="col-lg-9">
<div class="profile-box">
<div class="profile-box-form">
<h1 class="mb-3"> Properties</h1>
<div class="card-block">
<div class="tab-content">
<div class="tab-pane active" id="AboutTab">
   <div class="card col-md-12 o-auto">
      @if(count($property_gallery) > 0)
      <div class="row" style="margin-top: 20px;">
         <div class="col-lg-12 col-xl-12">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  @foreach($property_gallery as $image=>$gallery)
                  @if($image==0)
                  <div class="carousel-item active">
                     <img class="d-block w-100" src="{{url('/')}}/images/property/gallery/{{$gallery['image']}}" alt="First slide">
                  </div>
                  @else
                  <div class="carousel-item">
                     <img class="d-block w-100" src="{{url('/')}}/images/property/gallery/{{$gallery['image']}}" alt="Second slide">
                  </div>
                  @endif
                  @endforeach
               </div>
               <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="sr-only">Next</span>
               </a>
            </div>
         </div>
      </div>
      @endif
      <div class="view-info">
         <div class="row" style="font-size: 12px">
            <div class="col-lg-3">
               <img class="img-thumbnail" src="{{url('/')}}/images/property/thumbnail/{{ $propertyData->property_image}}" alt="user-pic" title="Featured Image">
            </div>
            <div>
               <dt class="col-md-12 mt-2">property Type:
                  @if($propertyData->property_type==1)
                  {{'Renting'}}
                  @else
                  {{'buying'}}
                  @endif
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">property Category :
                  {{$propertyData->categoryname->name}}
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">property Title : {{$propertyData->title ? $propertyData->title : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Guest Count : {{$propertyData->guest_count ? $propertyData->guest_count : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Kitchen : {{$propertyData->no_of_kitchen ? $propertyData->no_of_kitchen : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Bathroom : {{$propertyData->no_of_bathroom ? $propertyData->no_of_bathroom : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Floors : {{$propertyData->no_of_floors ? $propertyData->no_of_floors : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Lift :
                  @if($propertyData->no_of_lift==1)
                  {{'Yes'}}
                  @else
                  {{'No'}}
                  @endif
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Bedroom : {{$propertyData->no_of_bedroom ? $propertyData->no_of_bedroom : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Balcony : {{$propertyData->no_of_balcony ? $propertyData->no_of_balcony : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Garden :
                  @if($propertyData->no_of_garden==1)
                  {{'Yes'}}
                  @else
                  {{'No'}}
                  @endif
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Parking :
                  @if($propertyData->no_of_parking==1)
                  {{'Yes'}}
                  @else
                  {{'No'}}
                  @endif
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">No Of Pool :
                  @if($propertyData->no_of_pool==1)
                  {{'Yes'}}
                  @else
                  {{'No'}}
                  @endif
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Email: {{$propertyData->property_email? $propertyData->property_email : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Mobile: {{$propertyData->property_number ? $propertyData->property_number : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">property Condition:
                  {{$property_conditionData->name}}
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">property price type:
                  @if($propertyData->property_price_type==1)
                  {{'PerSq.Ft'}}
                  @elseif ($propertyData->property_price_type==2)
                  {{'Fixed'}}                                                                                                                                                                                                                                                                                                                                                                                                                                                                               '}}
                  @elseif ($propertyData->property_price_type==3)
                  {{'Persq.Yard'}}
                  @elseif ($propertyData->property_price_type==4)
                  {{'Per Night'}}
                  @elseif ($propertyData->property_price_type==5)
                  {{'Per Month'}}
                  @elseif ($propertyData->property_price_type==6)
                  {{'Per Annual'}}
                  @endif
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Built In Year: {{$propertyData->built_in_year ? $propertyData->built_in_year : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Property Price: {{$propertyData->property_price ? $propertyData->property_price : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Property Description: {{$propertyData->property_description ? $propertyData->property_description : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Property Features: {{$propertyData->property_features ? $propertyData->property_features : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Property Address: {{$propertyData->property_address ? $propertyData->property_address : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Property Status: 
                  @if($propertyData->property_status==1)
                  {{'Active'}}
                  @else
                  {{'pending'}}
                  @endif
               </dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Publish Date: {{$propertyData->publish_date ? $propertyData->publish_date : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Meta Title: {{$propertyData->meta_title ? $propertyData->meta_title : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Meta Keywords: {{$propertyData->meta_keywords ? $propertyData->meta_keywords : '--' }}</dt>
            </div>
            <div>
               <dt class="col-md-12 mt-2">Meta Description: {{$propertyData->meta_description ? $propertyData->meta_description : '--' }}</dt>
            </div>
            <div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection