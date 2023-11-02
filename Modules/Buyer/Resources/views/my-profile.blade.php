@extends('buyer::layouts.master')
@section('content')
    <div class="col-md-9">
      <div class="profile-box">          
        <div class="profile-box-form">
          <h1 class="mb-3">My Profile</h1>
          <form class="profile-form "> 
            <div class="user-box-img">
              <div class="row">
               <div class="col-12 text-center">
                <div class="user-box overflow-visible position-relative">
                  <img class="rounded-pill" src="{{url('/')}}/assets_front/images/user-icon.jpg">              
                  <div class="useravtarIcon">
                    <input type="file" id="myFile" class="opacity-0 position-absolute bottom-0" name="filename">
                    <span class="avtar_user d-inline-block rounded-pill position-absolute bottom-0 bg-white">
                      <svg width="18" height="16" viewBox="0 0 18 16" fill="none" class="mt-1">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.75 5.25002C0.75 4.2375 1.57081 3.41669 2.58333 3.41669H3.43549C4.04848 3.41669 4.6209 3.11034 4.96092 2.6003L5.70575 1.48307C6.04577 0.973037 6.61819 0.666687 7.2312 0.666687H10.7688C11.3818 0.666687 11.9542 0.973037 12.2942 1.48307L13.0391 2.6003C13.3791 3.11034 13.9516 3.41669 14.5645 3.41669H15.4167C16.4292 3.41669 17.25 4.2375 17.25 5.25002V13.5C17.25 14.5126 16.4292 15.3334 15.4167 15.3334H2.58333C1.57081 15.3334 0.75 14.5126 0.75 13.5V5.25002Z" stroke="#4A5568" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.75 8.91669C11.75 10.4355 10.5188 11.6667 9 11.6667C7.48117 11.6667 6.25 10.4355 6.25 8.91669C6.25 7.39786 7.48117 6.16669 9 6.16669C10.5188 6.16669 11.75 7.39786 11.75 8.91669Z" stroke="#4A5568" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                  </div>
                </div> 
              </div> 
            </div>           
            <div class="row">
              <div class="col-12">
                <strong>Owner Type</strong>
              </div>
              <div class="col-6">
               <div class="mb-4">            
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="" placeholder="Albert Flores">            
              </div>
            </div>
            <div class="col-6">
              <div class="mb-4"> 
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="" placeholder="Email ID">   
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="" placeholder="+244 9876543210">   
           </div>
         </div>        
          <div class="text-center">
            <a href="edit-profile.html" class="btn btn-primary">
              Edit Profile
            </a>           
        </div>
      </form>      
    </div>
  </div>
</div>
@endsection