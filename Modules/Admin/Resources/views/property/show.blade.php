@extends('admin::layouts.master')
@section('title', 'Property Details')

<style type="text/css">
	.carousel-item img {
    height: 300px;
    object-fit: cover;
    object-position: center;
}
</style>
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
                                    <h4>Property Details</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-list')}}">Property List</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-details',$propertyInfo->slug)}}">Property Details</a></li>
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
                            <label class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="font-size: 19px; margin-top: -1px;">&times;</span>
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
                <div class="card">
                    <div class="card-block">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                               <!-- Nav tabs -->
                               <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active"  href="{{route('admin-property-details',$propertyInfo->slug)}}">About</a>
                                    <div class="slide"></div>
                                </li>   
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="AboutTab">
                                    <div class="card col-md-12 o-auto">



                        @if(count($property_gallery) > 0)
                            	<div class="row" style="margin-top: 20px;">
                            		<div class="col-lg-12 col-xl-12">
                         <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
						  <div class="carousel-inner">
						  	@foreach($property_gallery as $key=>$list)
						  	@if($key==0)
						    <div class="carousel-item active">
						      <img class="d-block w-100" src="{{$list}}" alt="First slide">
						    </div>
						    @else
						    <div class="carousel-item">
						      <img class="d-block w-100" src="{{$list}}" alt="Second slide">
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

                                        <div class="card-header btn_modify full">
                                            <h5 class="card-header-text">About Property</h5>
                                            <a href="{{route('admin-property-edit',$propertyInfo->slug)}}" id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right wdh-60" style="font-weight: bold;">
                                                Edit
                                            </a>
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row" style="font-size: 12px">
                                            <div class="col-lg-3">
                                                <img class="img-thumbnail" src="{{url('/')}}/images/property/thumbnail/{{ $propertyInfo->property_image}}" alt="user-pic" title="Featured Image">
                                            </div>



                          <div class="col-lg-9">
                            <div class="general-info">
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-lg-12 col-xl-12">
                                    <dl class="row">
                                        <dt class="col-4 col-sm-4">Property Name</dt>
                                        <dd class="col-8 col-sm-8">{{$propertyInfo->title}}</dd>

                                        <dt class="col-4 col-sm-4">Property Owner</dt>
                                        <dd class="col-8 col-sm-8">{{$propertyInfo->ownername}}</dd>

                                        <dt class="col-4 col-sm-4">Property Type </dt>
                                        <dd class="col-8 col-sm-8">
                                        @if($propertyInfo->property_type=="1")
                                        <span class="badge badge-success" style="cursor: pointer;">Rent</span>
                                        @else
                                         <span class="badge badge-info" style="cursor: pointer;">Sell</span>
                                        @endif
                                        </dd>

                                        <dt class="col-4 col-sm-4">Property Category</dt>
                                        <dd class="col-8 col-sm-8">{{$propertyInfo->categoryname}}</dd>

                                        <dt class="col-4 col-sm-4">Guest Count</dt>
                                   <dd class="col-8 col-sm-8"> 
                                     {{$propertyInfo->guest_count ? $propertyInfo->guest_count  : '--' }}
                                 </dd>

                                  <dt class="col-4 col-sm-4">No. of Bathroom</dt>
                                   <dd class="col-8 col-sm-8"> 
                                     {{$propertyInfo->no_of_bathroom ? $propertyInfo->no_of_bathroom  : '--' }}
                                 </dd>

                                 <dt class="col-4 col-sm-4">No. of Beds</dt>
                                   <dd class="col-8 col-sm-8"> 
                                     {{$propertyInfo->no_of_bedroom ? $propertyInfo->no_of_bedroom  : '--' }}
                                 </dd>

                                 <dt class="col-4 col-sm-4">No. of Kitchen</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->no_of_kitchen ? $propertyInfo->no_of_kitchen  : '--' }}
                                </dd>

                                <dt class="col-4 col-sm-4">Pool</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->no_of_pool==1 ? 'Yes': 'No' }}
                                </dd>

                                <dt class="col-4 col-sm-4">Garden</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->no_of_garden==1 ? 'Yes': 'No' }}
                                </dd>

                                <dt class="col-4 col-sm-4">Lift</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->no_of_lift==1 ? 'Yes': 'No' }}
                                </dd>

                                <dt class="col-4 col-sm-4">Parking</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->no_of_parking==1 ? 'Yes': 'No' }}
                                </dd>

                                <dt class="col-4 col-sm-4">Property Features</dt>
                                @if($propertyInfo->property_features!="")
                                 <dd class="col-8 col-sm-8">  
                                  @php $property_features_array=json_decode($propertyInfo->property_features,true); @endphp
                                  @foreach($property_features_array as $list)
                                    <p>{{$list}}</p>
                                  @endforeach
                                </dd>
                                @else
                                  <dd class="col-8 col-sm-8">  
                                    N.A.
                                </dd>
                                @endif
                                <dt class="col-4 col-sm-4">Email</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->property_email ? $propertyInfo->property_email  : '--' }}
                                </dd>
                                <dt class="col-4 col-sm-4">Mobile No</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->property_number ? $propertyInfo->property_number  : '--' }}
                                </dd>

                                <dt class="col-4 col-sm-4">Publish Date</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->publish_date ? $publish_date  : '--' }}
                                </dd>



                                <dt class="col-4 col-sm-4">No. of Balcony</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->no_of_balcony ? $propertyInfo->no_of_balcony  : '--' }}
                                </dd>

                                <dt class="col-4 col-sm-4">Floor No.</dt>
                                 <dd class="col-8 col-sm-8">  
                                    {{$propertyInfo->no_of_floors ? $propertyInfo->no_of_floors  : '--' }}
                                </dd>


                                        <dt class="col-4 col-sm-4">Built In Year </dt>
                                        <dd class="col-8 col-sm-8">{{date('Y',strtotime($propertyInfo->built_in_year))}}</dd>

                                        <dt class="col-4 col-sm-4">Living SqFt</dt>
                                        <dd class="col-8 col-sm-8">{{$propertyInfo->property_area}}</dd>

                                        <dt class="col-4 col-sm-4">Property Condition</dt>
                                        <dd class="col-8 col-sm-8">{{$propertyInfo->conditionname}}</dd>

                                        
                                       

                                        <dt class="col-4 col-sm-4">List Price</dt>
                                        <dd class="col-8 col-sm-8">{{$propertyInfo->property_price}}</dd>

                                        <dt class="col-4 col-sm-4">Price Type</dt>
                                        <dd class="col-8 col-sm-8">
                                            @if($propertyInfo->property_price_type==1)
                                            <span class="badge badge-warning" style="cursor: pointer;">Per Sq. Ft.</span>
                                            @elseif($propertyInfo->property_price_type==2)
                                            <span class="badge badge-success" style="cursor: pointer;">Fixed</span>
                                            @elseif($propertyInfo->property_price_type==3)
                                            <span class="badge badge-danger" style="cursor: pointer;">Per Sq. Yd.</span>
                                            @elseif($propertyInfo->property_price_type==4)
                                            <span class="badge badge-warning" style="cursor: pointer;">Per Month</span>
                                            @elseif($propertyInfo->property_price_type==5)
                                            <span class="badge badge-success" style="cursor: pointer;">Per Month</span>
                                            @elseif($propertyInfo->property_price_type==6)
                                            <span class="badge badge-danger" style="cursor: pointer;">Annuanl</span>
                                            @else
                                            <span class="badge badge-danger" style="cursor: pointer;">N.A.</span>
                                            @endif 
                                        </dd>

                                        <dt class="col-4 col-sm-4">Status</dt>
                                        <dd class="col-8 col-sm-8"> 
                                            @if($propertyInfo->property_status==0)
                                            <span class="badge badge-warning" style="cursor: pointer;">Pending</span>
                                            @elseif($propertyInfo->property_status==1)
                                            <span class="badge badge-success" style="cursor: pointer;">Active</span>
                                            @else
                                            <span class="badge badge-danger" style="cursor: pointer;">Inactive</span>
                                            @endif 
                                        </dd>

                                       <dt class="col-4 col-sm-4">Address</dt>
                                       <dd class="col-8 col-sm-8">  
                                        {{ $propertyInfo->property_address}}</dd>
    
                                <dt class="col-sm-12">Description</dt>
                                <dd class="col-sm-12">  
                                   <div 
                                   style="
                                   border: 1px inset #ccc;
                                   background-color: white;
                                   font: small courier, monospace black;
                                   width: 100%;
                                   height: 120px;padding:5px; 
                                   overflow: auto;">
                                   {!! $propertyInfo->property_description ? $propertyInfo->property_description  : '--'
                                   !!}
                               </div>
                           </dd>

                           <dt class="col-sm-12">Meta Title</dt>
                                <dd class="col-sm-12">  
                                   <div 
                                   style="
                                   border: 1px inset #ccc;
                                   background-color: white;
                                   font: small courier, monospace black;
                                   width: 100%;
                                   height: 120px;padding:5px; 
                                   overflow: auto;">
                                   {!! $propertyInfo->meta_title ? $propertyInfo->meta_title  : '--'
                                   !!}
                               </div>
                           </dd>

                           <dt class="col-sm-12">Meta Description</dt>
                                <dd class="col-sm-12">  
                                   <div 
                                   style="
                                   border: 1px inset #ccc;
                                   background-color: white;
                                   font: small courier, monospace black;
                                   width: 100%;
                                   height: 120px;padding:5px; 
                                   overflow: auto;">
                                   {!! $propertyInfo->meta_description ? $propertyInfo->meta_description  : '--'
                                   !!}
                               </div>
                           </dd>

                           <dt class="col-sm-12">Meta Keywords</dt>
                                <dd class="col-sm-12">  
                                   <div 
                                   style="
                                   border: 1px inset #ccc;
                                   background-color: white;
                                   font: small courier, monospace black;
                                   width: 100%;
                                   height: 120px;padding:5px; 
                                   overflow: auto;">
                                   {!! $propertyInfo->meta_keywords ? $propertyInfo->meta_keywords  : '--'
                                   !!}
                               </div>
                           </dd>
                       </dl>
                   </div>
               </div>
               <!-- end of row -->
                                           </div>
                                           <!-- end of general info -->
                                       </div>
                                       <!-- end of col-lg-12 -->
                                   </div>
                               </div>
                           </div>
                           <!-- end of card-block -->
                       </div>
                </div> 
            </div>
        </div>
    </div>
    <!-- Row end -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>


@endsection   
@section('js') 

<script type="text/javascript">
	$('.carousel').carousel({
  interval: 2000
})
</script>

@endsection