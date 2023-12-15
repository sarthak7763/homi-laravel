@extends('buyer::layouts.master')
@section('content')



<div class="col-md-9">
  <div class="profile-box">          
    <div class="profile-box-form">
      <div class="row align-items-center mb-3">
        <div class="col">
        <center> <h1 class="mb-0">VIEW Bookings</h1></center>
        </div>
        <div class="col-auto">
          
        </div>
      </div>
      <a href="{{route('buyer.bookings')}}" class="button-like">Go Back</a>

      <div class="total-bookings">
      <table class="table table-bordered">
    <tr>
   <th width="400px">Invoice ID</th>
    <td>{{$view_booking_data->invoice_id}}</td>
   </tr>
   <tr>
   <th width="400px">Name:</th>
    <td>{{$view_booking_data->user_name}}</td>
   </tr>

   <tr>
   <th width="400px">Email</th>
    <td>{{$view_booking_data->user_email}}</td>
   </tr>
   <tr>
   <th width="400px"> User Gender</th>
    <td>{{$view_booking_data->user_gender}}</td>
   </tr>

   <tr>
   <th width="400px"> User Age</th>
    <td>{{$view_booking_data->user_age}}</td>
   </tr>
   <tr>
   <th width="400px">Contact Number</th>
    <td>{{$view_booking_data->user_number}}</td>
   </tr>
   <tr>
   <th width="400px">User CheckIn Date </th>
    <td>{{$view_booking_data->user_checkin_date}}</td>
   </tr>
   <th width="400px">User CheckOut Date </th>
    <td>{{$view_booking_data->user_checkout_date}}</td>
   </tr>
   <tr>
   <th width="400px">Vendor Property Price </th>
    <td>{{$view_booking_data->booking_property_price}}</td>
   </tr>
   <tr>
   <th width="400px">Booking Tax Price </th>
    <td>{{$view_booking_data->booking_tax_price}}</td>
   </tr>
   <tr>
   <th width="400px">Booking Price </th>
    <td>{{$view_booking_data->booking_price}}</td>
   </tr>
   <tr>
   <th width="400px">User Adult Count </th>
    <td>{{$view_booking_data->user_adult_count}}</td>
   </tr>
   <tr>
   <th width="400px">User Children Count </th>
    <td>{{$view_booking_data->user_children_count}}</td>
   </tr>
   <tr>
   <th width="400px">Booking Status </th>
    <td>
    @if($view_booking_data->booking_status==0)
              {{'ongoing'}}
              @elseif($view_booking_data->booking_status==1) 
              {{'complete'}}
              @elseif($view_booking_data->booking_status==2)
              {{'cancel'}}
              @endif   
    </td>
   </tr>
   <tr>
   <th width="400px">Payment Mode</th>
    <td>{{$view_booking_data->payment_mode}}</td>
   </tr>
   <tr>
   <th width="400px">Payment Status</th>
    <td>{{$view_booking_data->payment_status}}</td>
   </tr>
   <tr>
   <th width="400px">Booking Cancel Reason</th>
    <td>{{$view_booking_data->cancel_reason}}</td>
   </tr>
   <tr>
   <th width="400px">Booking Cancel Date</th>
    <td>{{$view_booking_data->cancel_date}}</td>
   </tr>

   </table>
      </div> 

    </div>
  </div>
</div>
</div>
</div>
</div>
</main>

@endsection