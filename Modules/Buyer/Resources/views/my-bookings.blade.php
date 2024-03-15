@extends('buyer::layouts.master')
@section('content')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
 
</style>
<div class="col-md-8 col-lg-9">
    <div class="profile-box booking_page">
        <div class="profile-box-form">
            <h1 class="mb-3">Total Bookings</h1>
           
            @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    <form action = "{{route('buyer.bookings')}}" method="get" autocomplete="off">
                   
                        <div class="search-input-group">
                            <div class="row form-outline px-3 py-3">

                            <div class="col px-2 name-box">
                                    <label>Property Name</label>
                                    <input type="text" id="form1" class="form-control" name = "title_search" placeholder="Search Property Name" value="{{$search_title}}" >
                                </div>
                                <div class="col px-2 booking-box">
                                     <label>BookingID</label>
                                     <input type="text" id="form1" class="form-control" name = "booking_id_search" placeholder="Search Booking ID" value="{{$search_booking_id}}">
                                </div>
                                <div class="col px-2 status-box">
                                    <label>Booking Status</label>
                                    <select name="booking_status">
                                    
                                  <option value ="" {{empty($booking_status) ? 'selected' : ''  }} >select status</option> 
                                  <option value ="ongoing" {{ $booking_status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                  <option value ="completed" {{ $booking_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                  <option value ="cancel" {{ $booking_status == 'cancel' ? 'selected' : '' }} >Cancelled</option>
                                 </select> 
                                </div>

                                <div class="col-md-6 px-2 date-box">
                                    <label>Checkin Date</label>
                                    <input type="text" id="datepicker1" name = "check_in_search" value="{{$search_checkin}}" >
                                </div>                         
                                    <div class="col-md-6 px-2 date-box">
                                     <label>Checkout Date</label>
                                     <input type="text" id="datepicker2" name = "check_out_search" value="{{$search_checkout}}">
                                </div>
                                <div class="col-md-12 date-box-submit px-2  d-flex align-items-center pt-4 pb-4 justify-content-center">
                                     <button type="submit" class="btn-search font-18  btn btn-primary mx-0 mt-0" >Search</button>
                            <a href ="{{route('buyer.bookings')}}" button type="button" class="btn btn-danger ms-3 font-18 cancel_btn  mx-0 mt-0 px-3">Reset</a>
                                </div> 
                               
                                </div>                           
                            
                        </div>
                    </form>
                    

          @if(!empty($bookingData))
            <div class="total-bookings px-3">
                <table class="table mb-0 border">
                    <thead>
                        <tr>
                            <th scope="col">Sr.no</th>
                            <th scope="col">Property Name</th>
                            <th scope="col">Booking ID</th>
                            <th scope="col">Check in</th>
                            <th scope="col">Check out</th>
                            <th scope="col">Price</th>
                            <th class="bookings-status" scope="col"> Status</th>
                            <th class="bookings-status" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookingData as $booking)
                        
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$booking->title}}</td>
                            <td>
                                <a href="{{route('buyer.bookings_view',($booking->booking_id))}}" class="button-like">{{$booking->booking_id}}</a>
                            </td>
                            <td>{{date('M d, Y',strtotime($booking->user_checkin_date))}}</td>
                            
                            <td>{{date('M d, Y',strtotime($booking->user_checkout_date))}}</td>
                            <td>{{$booking->booking_property_price}}</td>
                            <td class=""><span class="text-warning"></span>
                                @if($booking->booking_status==0)
                                {{'ongoing'}}
                                @elseif($booking->booking_status==1) 
                                {{'completed'}}
                                @elseif($booking->booking_status==2) 
                                {{'cancelled'}}
                                @endif
                            </td>
                            <td>
                            &nbsp;&nbsp; @if($booking->booking_status==1 || $booking->booking_status==2)
                                <button type="button" class="button-like status_change" data-toggle="modal" data-target="#myModal" data-id="{{$booking->booking_id}}" data-status="{{$booking->booking_status}}" style = "display:none"; >Change Status</button>
                                @else
                                <button type="button" class="button-like status_change" data-toggle="modal" data-target="#myModal" data-id="{{$booking->booking_id}}" data-status="{{$booking->booking_status}}">Change Status</button>
                                 @endif
                                                         @if($booking->booking_status==1 || $booking->booking_status==2 )
                                <button type="button" class="button-like cancel_booking" data-toggle="modal" data-target="#cancelModal" data-id="{{$booking->booking_id}}" style = "display:none";>Cancel Booking</button>
                            @else
                            <button type="button" class="button-like cancel_booking" data-toggle="modal" data-target="#cancelModal" data-id="{{$booking->booking_id}}">Cancel Booking</button>
                            @endif
                             </td>
                         </tr>
                        
                        @endforeach 
                          
                    </tbody>
                </table>
                <form action = "{{route('buyer.bookings-update-status')}}" method ="Post">
                    @csrf
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Change Status</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Your form or content for status change goes here -->
                                    <p>Are you want to mark your booking completed ?</p>
                                    <input type= "hidden" name = "booking_id" id="booking_hidden_id">
                                    <input type= "hidden" name = "booking_status" id="booking_hidden_status"> 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="update_data" >Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{route('buyer.bookings-cancel-booking')}}" method="Post">
                    @csrf
                    <div class="modal fade" id="cancelModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cancel booking</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Why do you want to cancel booking?</p>
                                    <input type= "hidden" name = "cancel_booking_id" id="cancel_booking_hidden_id">
                                    @foreach($cancel_reasons as $key=>$cancel)
                                    <li>
                                        <label class="container3">
                                            <ul> <input type="radio" name="cancel_id" value="{{$cancel['id']}}">{{$cancel['reason_name']}}
                                                <span class="radio"></span>
                                            </ul>
                                        </label>
                                    </li>
                                    @endforeach
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-primary" id="update_data" >Yes</button>
                                </div>
                                @else
                                <div class ="no-data-box">
                                            <center>
                                    <h2>{{'No Data Found '}}</h2>
                                </center>
                                </div>
                              @endif
                            </div>
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
</main>
@endsection


<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#datepicker1" ).datepicker();
  } );
  </script>

<script>
  $( function() {
    $( "#datepicker2" ).datepicker();
  } );
  </script>

