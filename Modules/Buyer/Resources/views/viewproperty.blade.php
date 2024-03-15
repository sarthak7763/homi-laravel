@extends('buyer::layouts.master')
@section('content')
<style type="text/css">
   .carousel-item img {
   height: 300px;
   object-fit: cover;
   object-position: center;
   }
</style>
<div class="col-md-8 col-lg-9 pb-4">
<div class="profile-box">
<div class="profile-box-form">
<h1 class="mb-3"> Properties</h1>
<div class="card-block">
<div class="tab-content">
<div class="tab-pane active" id="AboutTab">
   <div class="card col-md-12 o-auto p-3">
      @if(count($property_gallery) > 0)
      <div class="row">
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
      <div class="view-info mt-3"> 
         <div class="booking-detail">
            <div class="row">
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0">Property Type:</p>
                   <strong>
                                    @if($propertyData->property_type==1)
                                    {{'Renting'}}
                                    @else
                                    {{'buying'}}
                                    @endif
                  </strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0"> Property Category :</p>
                  <strong>{{$propertyData->categoryname->name}}</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0"> Property Title :</p>
                  <strong>{{$propertyData->title ? ucfirst($propertyData->title) : '--' }}</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0"> Guest Count :</p>
                  <strong>{{$propertyData->guest_count ? $propertyData->guest_count : '--' }}</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0"> No Of Kitchen :</p>
                  <strong> {{$propertyData->no_of_kitchen ? $propertyData->no_of_kitchen : '--' }}</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0">No Of Bathroom :</p>
                  <strong> {{$propertyData->no_of_bathroom ? $propertyData->no_of_bathroom : '--' }}</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0">No Of Floors :</p>
                  <strong> {{$propertyData->no_of_bathroom ? $propertyData->no_of_bathroom : '--' }}</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0">No Of Lift :</p>
                  <strong>@if($propertyData->no_of_lift==1)
                  {{'Yes'}}
                  @else
                  {{'No'}}
                  @endif</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0">No Of Lift :</p>
                  <strong>@if($propertyData->no_of_lift==1)
                  {{'Yes'}}
                  @else
                  {{'No'}}
                  @endif</strong> 
               </div>
               </div>
                <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0">No Of Bedroom : </p>
                  <strong>{{$propertyData->no_of_bedroom ? $propertyData->no_of_bedroom : '--' }}</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0">No Of Balcony :</p>
                  <strong>{{$propertyData->no_of_balcony ? $propertyData->no_of_balcony : '--' }}</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                   <p class="mb-0">No Of Garden :</p>
                  <strong>@if($propertyData->no_of_garden==1)
                  {{'Yes'}}
                  @else
                  {{'No'}}
                  @endif</strong> 
               </div>
               </div>
               
               <div class="col-sm-6 col-md-4">
                  <div class="booking-detail-box">
                     <p class="mb-0">No Of Parking :</p>
                     <strong>@if($propertyData->no_of_parking==1)
                     {{'Yes'}}
                     @else
                     {{'No'}}
                     @endif</strong> 
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">No Of Pool :</p>
                     <strong> @if($propertyData->no_of_pool==1)
                  {{'Yes'}}
                  @else
                  {{'No'}}
                  @endif</strong> 
               </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">

                  <p class="mb-0">Email:</p>
                     <strong> {{$propertyData->property_email? $propertyData->property_email : '--' }}</strong> 
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Mobile:</p>
                     <strong> {{$propertyData->property_number ? $propertyData->property_number : '--' }}</strong> 
                  </div>
               </div>
                
                <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Property Condition:</p>
                     <strong>{{$property_conditionData->name}}</strong> 
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Property Price Type:</p>
                     <strong>
                        
                     
                     @if($propertyData->property_price_type==1)
                                    {{'PerSq.Ft'}}
                                    @elseif ($propertyData->property_price_type==2)
                                    {{'Fixed'}}
                                    @elseif ($propertyData->property_price_type==3)
                                    {{'Persq.Yard'}}
                                    @elseif ($propertyData->property_price_type==4)
                                    {{'Per Night'}}
                                    @elseif ($propertyData->property_price_type==5)
                                    {{'Per Month'}}
                                    @elseif ($propertyData->property_price_type==6)
                                    {{'Per Annual'}}
                                    @endif
                           </strong> 
                         </div>
                        </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Built In Year:</p>
                     <strong> {{$propertyData->built_in_year ? date('Y',strtotime($propertyData->built_in_year)) : '--' }}</strong> 
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Property Price:</p>
                  
                     <strong> {{$propertyData->property_price ? $propertyData->property_price : '--' }}</strong> 
                  </div>
               </div>
               
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                   <p class="mb-0">Property Features: </p>
                     <strong>{{implode(", ",$featuresArray)}}</strong>
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Property Address: </p>
                     <strong> {{$propertyData->property_address ? $propertyData->property_address : '--' }}</strong> 
                  </div>
               </div>
                              <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Property Status: </p>
                     <strong>  @if($propertyData->property_status==1)
                  {{'Active'}}
                  @else
                  {{'pending'}}
                  @endif</strong> 
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Publish Date:</p>
                     <strong>  {{$propertyData->publish_date ? $propertyData->publish_date : '--' }}</strong> 
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Meta Title:</p>
                     <strong>  {{$propertyData->meta_title ? $propertyData->meta_title : '--' }}</strong> 
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Meta Keywords:</p>
                     <strong> {{$propertyData->meta_keywords ? $propertyData->meta_keywords : '--' }}</strong> 
                  </div>
               </div>
               <div class="col-sm-6 col-md-4">
                   <div class="booking-detail-box">
                  <p class="mb-0">Meta Description:</p>
                     <strong>  {{$propertyData->meta_description ? $propertyData->meta_description : '--' }}</strong> 
                  </div>
               </div>
               <div class="col-sm-12 col-md-12">
                   <div class="booking-detail-box">
                  <p class="mb-0">Property Description:</p>
                     <strong> {{$propertyData->property_description ? $propertyData->property_description : '--' }}</strong> 
                  </div>
               </div>


            </div>
         </div>
               
                    
      </div>
   </div>
   <div class="d-block text-center py-4 gap-2 justify-content-center">
   <a href ="{{route('buyer.property')}}" button type="button" class="btn btn-danger cancel_btn  mx-0 mt-0 px-3">Back</a>
   </div>
</div>
@endsection