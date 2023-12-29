
<div class="col-lg-3  mb-4">
@php $sellerinfo=getSellerinfo(auth()->user()->id); @endphp
<div class="profile-div">
  <div class="main-profile rounded-circle mb-3">
   <img class="rounded-pill-box" src="{{url('/')}}/images/{{$sellerinfo->profile_pic}}">
 </div>
 
 <div class="profile-text">                
  <strong>{{$sellerinfo->name}}</strong>
  <span>{{$sellerinfo->email}}</span>
</div>
</div>
<div class="profile-usermenu">
<ul class="profile-nav">
  <li class="item {{ (request()->is('dealer/dashboard*')) ? 'active' : '' }}">
   <a href="{{route('buyer.dashboard')}}">
      <span class="user-icon dashboard-icon"></span>
      Dashboard
    </a>
  </li>

  <li class="item {{ (request()->is('dealer/my-profile*')) ? 'active' : '' }}">
    <a href="{{route('buyer.my-profile')}}">
      <span class="user-icon profile-icon">
      </span>
      My Profile
    </a>
    </li>
  <li class="item {{ (request()->is('dealer/edit-profile*')) ? 'active' : '' }} ">
    <a href="{{route('buyer.edit-profile')}}">
      <span class="user-icon profile-icon">
      </span>
      Edit Profile
    </a>
  </li>
  <li class="item {{ (request()->is('dealer/bookings*')) ? 'active' : '' }}">
    <a href="{{route('buyer.bookings','all')}}">
      <span class="user-icon bookings-icon">
      </span>
      My Bookings
    </a>
  </li>
  <li class="item {{ (request()->is('dealer/subscription-plans*')) ? 'active' : '' }}">
    <a href="{{route('buyer.subscription-plans')}}">
      <span class="user-icon subscription-icon">              
      </span>
       Subscription Plans
    </a>
  </li>
  <li class="item {{ (request()->is('dealer/my-subscription*')) ? 'active' : '' }}">
    <a href="{{route('buyer.my-subscription')}}">
      <span class="user-icon subscription-icon">              
      </span>
      My Subscription Plan
    </a>
  </li>
  <li class="item {{ (request()->is('dealer/manage-properties*')) ? 'active' : '' }}">
    <a href="{{route('buyer.property','all')}}">
      <span class="user-icon properties-icon">   
      </span>
      Manage Properties
    </a> 
  </li>
  <li class="item {{ (request()->is('')) ? 'active' : '' }}">
    <a href="{{route('buyer.payment')}}">
      <span class="user-icon payments-icon">
      </span>
      Manage Payments
    </a> 
  </li>
  <li class="item {{ (request()->is('dealer-logout*')) ? 'active' : '' }}">
    <a href="{{route('buyer.logout')}}">
      <span class="user-icon logout-icon">            

      </span>
      Logout
    </a> 
  </li> 
</ul>
</div>
</div>