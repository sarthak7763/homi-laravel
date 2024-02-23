@extends('buyer::layouts.master')
@section('content')
<style>
  .dashboard-icon-box i {
    font-size: 37px;
    color: #8dc83e;
}
</style>
<div class="col-md-8 col-lg-9">
     <section class="section-dashboard">
  
      <div class="row align-items-center">
        <div class="col-lg-4 col-sm-6 col-md-6">
          <div class="dashboard-box">
           <div class="row align-items-center">
            <div class="col-auto">
              <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
                <i class="fa-solid fa-building fa-fw"></i>
              </div>
            </div>
            <div class="col text-end">
              <a href="{{route('buyer.property','all')}}">
              <h3>{{$total_property}}</h3>
              <p class="mb-0">Total Properties</p>
              </a>
            </div>
          </div>
        </div>          
      </div>
      <div class="col-lg-4 col-sm-6 col-md-6">
        <div class="dashboard-box">
         <div class="row align-items-center">
          <div class="col-auto">
            <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
              <i class="fa-solid fa-book-open"></i>
            </div>
          </div>
          <div class="col text-end">
          <a href="{{route('buyer.bookings')}}">
            <h3>{{$total_booking}}</h3>
            <p class="mb-0">Total Bookings</p>
          </div>
        </a>
        </div>
      </div>          
    </div>
          <div class="col-lg-4 col-sm-6 col-md-6">
        <div class="dashboard-box">
         <div class="row align-items-center">
          <div class="col-auto">
            <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
              <i class="fa-solid fa-book-open-reader"></i>
            </div>
          </div>
          <div class="col text-end">
          <a href="{{route('buyer.bookings',['booking_status_search'=>'0'])}}">
            <h3>{{$ongoing_booking}}</h3>
            <p class="mb-0">ongoing booking</p></a>
          </div>
        </div>
      </div>          
    </div>
          <div class="col-lg-4 col-sm-6 col-md-6">
        <div class="dashboard-box">
         <div class="row align-items-center">
          <div class="col-auto">
            <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
              <i class="fa-solid fa-book"></i>
            </div>
          </div>
          <div class="col text-end">
          <a href="{{route('buyer.bookings',['booking_status_search'=>'1'])}}">
            <h3>{{$completed_booking}}</h3>
            <p class="mb-0">Completed Bookings</p>
</a>
          </div>
        </div>
      </div>          
    </div>
          <div class="col-lg-4 col-sm-6 col-md-6">
        <div class="dashboard-box">
         <div class="row align-items-center">
          <div class="col-auto">
            <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
             <i class="fa-solid fa-xmark"></i>
            </div>
          </div>
          <div class="col text-end">
          <a href="{{route('buyer.bookings',['booking_status_search'=>'2'])}}">
            <h3>{{$cancel_booking}}</h3>
            <p class="mb-0">Cancelled Bookings</p>
           </a>
          </div>
        </div>
      </div>          
    </div>

            <div class="col-lg-4 col-sm-6 col-md-6">
          <div class="dashboard-box">
           <div class="row align-items-center">
            <div class="col-auto">
              <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
                <i class="fa-solid fa-building-user"></i>
              </div>
            </div>
            <div class="col text-end">
            <a href="{{route('buyer.property',['status_search' => '1','property_type' => '2'])}}">
              <h3>{{$total_buying_property}}</h3>
              <p class="mb-0">Total Property for Active Selling</p>
             </a>
            </div>
          </div>
        </div>          
      </div>
              <div class="col-lg-4 col-sm-6 col-md-6">
          <div class="dashboard-box">
           <div class="row align-items-center">
            <div class="col-auto">
              <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
                <i class="fa-solid fa-city"></i>
              </div>
            </div>
            <div class="col text-end">
            <a href="{{route('buyer.property',['status_search' =>'','property_type' => '1'])}}">
              <h3>{{$total_renting_property}}</h3>
              <p class="mb-0">Total Renting Properties</p>
              </a>
            </div>
          </div>
        </div>          
      </div>
  </div>

</section>
  </div>



@endsection