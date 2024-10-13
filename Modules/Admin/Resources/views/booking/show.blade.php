@extends('admin::layouts.master')
@section('title', 'Booking Details')

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
                                    <h4>Booking Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-booking-list')}}">Booking List</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-booking-details',$bookinginfo->id)}}">Booking Details</a></li>
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
                                    <a class="nav-link active"  href="{{route('admin-booking-details',$bookinginfo->id)}}">About</a>
                                    <div class="slide"></div>
                                </li>   
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="AboutTab">
                                    <div class="card col-md-12 o-auto">

                                        <div class="card-header btn_modify full">
                                            <h5 class="card-header-text">About Booking</h5>
                                            <a href="{{route('admin-booking-invoice',$bookinginfo->id)}}" id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right wdh-60" style="font-weight: bold;">
                                                <img src="{{url('/')}}/assets_admin/assets/file-invoice-solid.png" style="height:auto;width:40%;">
                                            </a>
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row" style="font-size: 12px">

                          <div class="col-lg-9">
                            <div class="general-info">
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-lg-12 col-xl-12">
                                    <dl class="row">
                                        <dt class="col-4 col-sm-4">Booking ID</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->booking_id}}</dd>

                                        <dt class="col-4 col-sm-4">Booked On</dt>
                                        <dd class="col-8 col-sm-8">
                                          @php
                                            $booking_date=date('d M,Y',strtotime($bookinginfo->created_at));
                                          @endphp
                                          {{$booking_date}}</dd>

                                        <dt class="col-4 col-sm-4">Booked By</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->booking_user_name}}</dd>

                                        <dt class="col-4 col-sm-4">Customer Name</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_name}}</dd>

                                        <dt class="col-4 col-sm-4">Customer Email</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_email}}</dd>

                                        <dt class="col-4 col-sm-4">Customer Phone</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_number}}</dd>

                                        <dt class="col-4 col-sm-4">Customer Age</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_age}}</dd>

                                        <dt class="col-4 col-sm-4">Customer Gender</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_gender}}</dd>

                                        <dt class="col-4 col-sm-4">Property Title</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->property_title}}</dd>

                                        <dt class="col-4 col-sm-4">Property Type </dt>
                                        <dd class="col-8 col-sm-8">
                                        @if($bookinginfo->property_type=="1")
                                        <span class="badge badge-success" style="cursor: pointer;">Rent</span>
                                        @else
                                         <span class="badge badge-info" style="cursor: pointer;">Sell</span>
                                        @endif
                                        </dd>

                                        <dt class="col-4 col-sm-4">Check In Date</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_checkin_date}}</dd>

                                         <dt class="col-4 col-sm-4">Check Out Date</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_checkout_date}}</dd>

                                         <dt class="col-4 col-sm-4">Adults Guest Count</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_adult_count}}</dd>

                                        <dt class="col-4 col-sm-4">Children Guest Count</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->user_children_count}}</dd>

                                        <dt class="col-4 col-sm-4">Property Price (Subtotal)</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->booking_property_price}}</dd>

                                        <dt class="col-4 col-sm-4">Booking Tax Price</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->booking_tax_price}}</dd>

                                        <dt class="col-4 col-sm-4">Total Booking Prize</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->booking_price}}</dd>

                                        <dt class="col-4 col-sm-4">Payment Mode</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->payment_mode}}</dd>

                                        <dt class="col-4 col-sm-4">Payment Status</dt>
                                        <dd class="col-8 col-sm-8">
                                        <span class="badge badge-warning" style="cursor: pointer;">{{$bookinginfo->payment_status}}</span></dd>

                                        <dt class="col-4 col-sm-4">Status</dt>
                                        <dd class="col-8 col-sm-8"> 
                                            @if($bookinginfo->booking_status==0)
                                            <span class="badge badge-warning" style="cursor: pointer;">Ongoing</span>
                                            @elseif($bookinginfo->booking_status==1)
                                            <span class="badge badge-success" style="cursor: pointer;">Complete</span>
                                            @else
                                            <span class="badge badge-danger" style="cursor: pointer;">Cancel</span>
                                            @endif 
                                        </dd>

                                        @if($bookinginfo->booking_status==2)
                                        <dt class="col-4 col-sm-4">Cancel Reason</dt>
                                        <dd class="col-8 col-sm-8">{{$bookinginfo->payment_mode}}</dd>

                                        <dt class="col-4 col-sm-4">Cancel Date</dt>

                                        @php
                                            $cancel_date=date('d M,Y',strtotime($bookinginfo->cancel_date));
                                          @endphp

                                        <dd class="col-8 col-sm-8">{{$cancel_date}}</dd>
                                        @endif



                                    
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