@extends('buyer::layouts.master')
@section('content')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="col-md-9">
    <div class="profile-box">
        <div class="profile-box-form">
            <div class="row align-items-center mb-3">
                <div class="col">
                    <h1 class="mb-0">Total Bookings</h1>
                    @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
                </div>
                <div class="col-auto">
                    <form action = "{{route('buyer.bookings-search')}}" method="Post">
                        @csrf
                        <div class="search-input-group">
                            <div class="form-outline">
                                <input type="text" id="form1" class="form-control" name = "title_search" placeholder="Search Property Name" />
                                <input type="number" id="form1" class="form-control" name = "booking_id_search" placeholder="Search Booking ID" />
                            </div>
                            <button type="submit" class="btn-search">
                            Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="total-bookings">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Sr.no</th>
                            <th class="text-center" scope="col">Property Name</th>
                            <th class="text-center" scope="col">Booking ID</th>
                            <th class="text-center" scope="col">Check in</th>
                            <th class="text-center" scope="col">Check out</th>
                            <th class="text-center" scope="col">Price</th>
                            <th class="bookings-status text-end" scope="col">Status</th>
                            <th class="bookings-status text-end" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookingData as $booking)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td class="text-center">{{$booking->title}}</td>
                            <td class="text-center">
                                <a href="{{route('buyer.bookings_view',($booking->booking_id))}}" class="button-like">{{$booking->booking_id}}</a>
                            </td>
                            <td class="text-center">{{date('M d, Y',strtotime($booking->user_checkin_date))}}</td>
                            
                            <td class="text-center">{{date('M d, Y',strtotime($booking->user_checkout_date))}}</td>
                            <td class="text-center">{{$booking->booking_property_price}}</td>
                            <td class="text-end"><span class="text-warning"></span>
                                @if($booking->booking_status==0)
                                {{'ongoing'}}
                                @elseif($booking->booking_status==1) 
                                {{'complete'}}
                                @elseif($booking->booking_status==2) 
                                {{'cancel'}}
                                @endif
                            </td>
                            <td>
                                <button type="button" class="button-like status_change" data-toggle="modal" data-target="#myModal" data-id="{{$booking->booking_id}}" data-status="{{$booking->booking_status}}">Change Status</button>              
                            <td>
                            <td>
                                <button type="button" class="button-like cancel_booking" data-toggle="modal" data-target="#cancelModal" data-id="{{$booking->booking_id}}">Cancel Booking</button>
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
                                    <p>Are you sure you want to change the status?</p>
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