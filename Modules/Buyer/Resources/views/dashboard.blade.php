@extends('buyer::layouts.master')
@section('content')
<div class="col-lg-9">
     <section class="section-dashboard">
  
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="dashboard-box">
           <div class="row align-items-center">
            <div class="col-auto">
              <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
                <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M29.4167 16.9167V0.25H8.58333V8.58333H0.25V37.75H16.9167V29.4167H21.0833V37.75H37.75V16.9167H29.4167ZM8.58333 33.5833H4.41667V29.4167H8.58333V33.5833ZM8.58333 25.25H4.41667V21.0833H8.58333V25.25ZM8.58333 16.9167H4.41667V12.75H8.58333V16.9167ZM16.9167 25.25H12.75V21.0833H16.9167V25.25ZM16.9167 16.9167H12.75V12.75H16.9167V16.9167ZM16.9167 8.58333H12.75V4.41667H16.9167V8.58333ZM25.25 25.25H21.0833V21.0833H25.25V25.25ZM25.25 16.9167H21.0833V12.75H25.25V16.9167ZM25.25 8.58333H21.0833V4.41667H25.25V8.58333ZM33.5833 33.5833H29.4167V29.4167H33.5833V33.5833ZM33.5833 25.25H29.4167V21.0833H33.5833V25.25Z" fill="#8DC83E"/>
                </svg>
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
      <div class="col-md-6">
        <div class="dashboard-box">
         <div class="row align-items-center">
          <div class="col-auto">
            <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
              <svg width="40" height="29" viewBox="0 0 40 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.5 2.51057C14.857 1.22265 11.8879 0.5 8.75 0.5C5.6121 0.5 2.643 1.22265 0 2.51057V27.5105C2.643 26.2227 5.6121 25.5 8.75 25.5C12.9215 25.5 16.7947 26.777 20 28.9618C23.2052 26.777 27.0785 25.5 31.25 25.5C34.388 25.5 37.357 26.2227 40 27.5105V2.51057C37.357 1.22265 34.388 0.5 31.25 0.5C28.112 0.5 25.143 1.22265 22.5 2.51057V20.5C22.5 21.8808 21.3808 23 20 23C18.6193 23 17.5 21.8808 17.5 20.5V2.51057Z" fill="#8DC83E"/>
              </svg>
            </div>
          </div>
          <div class="col text-end">
          <a href="{{route('buyer.bookings','all')}}">
            <h3>{{$total_booking}}</h3>
            <p class="mb-0">Total Bookings</p>
          </div>
        </a>
        </div>
      </div>          
    </div>
          <div class="col-md-6">
        <div class="dashboard-box">
         <div class="row align-items-center">
          <div class="col-auto">
            <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
              <svg width="40" height="29" viewBox="0 0 40 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.5 2.51057C14.857 1.22265 11.8879 0.5 8.75 0.5C5.6121 0.5 2.643 1.22265 0 2.51057V27.5105C2.643 26.2227 5.6121 25.5 8.75 25.5C12.9215 25.5 16.7947 26.777 20 28.9618C23.2052 26.777 27.0785 25.5 31.25 25.5C34.388 25.5 37.357 26.2227 40 27.5105V2.51057C37.357 1.22265 34.388 0.5 31.25 0.5C28.112 0.5 25.143 1.22265 22.5 2.51057V20.5C22.5 21.8808 21.3808 23 20 23C18.6193 23 17.5 21.8808 17.5 20.5V2.51057Z" fill="#8DC83E"/>
              </svg>
            </div>
          </div>
          <div class="col text-end">
          <a href="{{route('buyer.bookings','ongoing')}}">
            <h3>{{$ongoing_booking}}</h3>
            <p class="mb-0">ongoing booking</p>
</a>
          </div>
        </div>
      </div>          
    </div>
          <div class="col-md-6">
        <div class="dashboard-box">
         <div class="row align-items-center">
          <div class="col-auto">
            <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
              <svg width="40" height="29" viewBox="0 0 40 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.5 2.51057C14.857 1.22265 11.8879 0.5 8.75 0.5C5.6121 0.5 2.643 1.22265 0 2.51057V27.5105C2.643 26.2227 5.6121 25.5 8.75 25.5C12.9215 25.5 16.7947 26.777 20 28.9618C23.2052 26.777 27.0785 25.5 31.25 25.5C34.388 25.5 37.357 26.2227 40 27.5105V2.51057C37.357 1.22265 34.388 0.5 31.25 0.5C28.112 0.5 25.143 1.22265 22.5 2.51057V20.5C22.5 21.8808 21.3808 23 20 23C18.6193 23 17.5 21.8808 17.5 20.5V2.51057Z" fill="#8DC83E"/>
              </svg>
            </div>
          </div>
          <div class="col text-end">
          <a href="{{route('buyer.bookings','completed')}}">
            <h3>{{$completed_booking}}</h3>
            <p class="mb-0">Completed Bookings</p>
</a>
          </div>
        </div>
      </div>          
    </div>
          <div class="col-md-6">
        <div class="dashboard-box">
         <div class="row align-items-center">
          <div class="col-auto">
            <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
              <svg width="40" height="29" viewBox="0 0 40 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.5 2.51057C14.857 1.22265 11.8879 0.5 8.75 0.5C5.6121 0.5 2.643 1.22265 0 2.51057V27.5105C2.643 26.2227 5.6121 25.5 8.75 25.5C12.9215 25.5 16.7947 26.777 20 28.9618C23.2052 26.777 27.0785 25.5 31.25 25.5C34.388 25.5 37.357 26.2227 40 27.5105V2.51057C37.357 1.22265 34.388 0.5 31.25 0.5C28.112 0.5 25.143 1.22265 22.5 2.51057V20.5C22.5 21.8808 21.3808 23 20 23C18.6193 23 17.5 21.8808 17.5 20.5V2.51057Z" fill="#8DC83E"/>
              </svg>
            </div>
          </div>
          <div class="col text-end">
          <a href="{{route('buyer.bookings','cancel')}}">
            <h3>{{$cancel_booking}}</h3>
            <p class="mb-0">Cancelled Bookings</p>
           </a>
          </div>
        </div>
      </div>          
    </div>

            <div class="col-md-6">
          <div class="dashboard-box">
           <div class="row align-items-center">
            <div class="col-auto">
              <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
                <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M29.4167 16.9167V0.25H8.58333V8.58333H0.25V37.75H16.9167V29.4167H21.0833V37.75H37.75V16.9167H29.4167ZM8.58333 33.5833H4.41667V29.4167H8.58333V33.5833ZM8.58333 25.25H4.41667V21.0833H8.58333V25.25ZM8.58333 16.9167H4.41667V12.75H8.58333V16.9167ZM16.9167 25.25H12.75V21.0833H16.9167V25.25ZM16.9167 16.9167H12.75V12.75H16.9167V16.9167ZM16.9167 8.58333H12.75V4.41667H16.9167V8.58333ZM25.25 25.25H21.0833V21.0833H25.25V25.25ZM25.25 16.9167H21.0833V12.75H25.25V16.9167ZM25.25 8.58333H21.0833V4.41667H25.25V8.58333ZM33.5833 33.5833H29.4167V29.4167H33.5833V33.5833ZM33.5833 25.25H29.4167V21.0833H33.5833V25.25Z" fill="#8DC83E"/>
                </svg>
              </div>
            </div>
            <div class="col text-end">
            <a href="{{route('buyer.property','buying')}}">
              <h3>{{$total_buying_property}}</h3>
              <p class="mb-0">Total Property for Active Selling</p>
             </a>
            </div>
          </div>
        </div>          
      </div>
              <div class="col-md-6">
          <div class="dashboard-box">
           <div class="row align-items-center">
            <div class="col-auto">
              <div class="dashboard-icon-box d-flex justify-content-center align-items-center">
                <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M29.4167 16.9167V0.25H8.58333V8.58333H0.25V37.75H16.9167V29.4167H21.0833V37.75H37.75V16.9167H29.4167ZM8.58333 33.5833H4.41667V29.4167H8.58333V33.5833ZM8.58333 25.25H4.41667V21.0833H8.58333V25.25ZM8.58333 16.9167H4.41667V12.75H8.58333V16.9167ZM16.9167 25.25H12.75V21.0833H16.9167V25.25ZM16.9167 16.9167H12.75V12.75H16.9167V16.9167ZM16.9167 8.58333H12.75V4.41667H16.9167V8.58333ZM25.25 25.25H21.0833V21.0833H25.25V25.25ZM25.25 16.9167H21.0833V12.75H25.25V16.9167ZM25.25 8.58333H21.0833V4.41667H25.25V8.58333ZM33.5833 33.5833H29.4167V29.4167H33.5833V33.5833ZM33.5833 25.25H29.4167V21.0833H33.5833V25.25Z" fill="#8DC83E"/>
                </svg>
              </div>
            </div>
            <div class="col text-end">
            <a href="{{route('buyer.property','renting')}}">
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