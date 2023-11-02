
<div class="col-md-3">
<div class="profile-div">
  <div class="main-profile rounded-circle mb-3">
   <img class="rounded-pill" src="{{url('/')}}/assets_front/images/user-image-01.jpg">
 </div>
 @php $sellerinfo=getSellerinfo(auth()->user()->id); @endphp
 <div class="profile-text">                
  <strong>{{$sellerinfo->name}}</strong>
  <span>{{$sellerinfo->email}}</span>
</div>
</div>
<div class="profile-usermenu">
<ul class="profile-nav">
  <li class="item">
    <a href="#">
      <span class="user-icon dashboard-icon"></span>
      Dashboard
    </a>
  </li>
  <li class="item active">
    <a href="#">
      <span class="user-icon profile-icon">
      </span>
      My Profile
    </a>
  </li>
  <li class="item">
    <a href="#">
      <span class="user-icon bookings-icon">
      </span>
      My Bookings
    </a>
  </li>
  <li class="item">
    <a href="#">
      <span class="user-icon subscription-icon">              
      </span>
      My Subscription Plan
    </a>
  </li>
  <li class="item">
    <a href="#">
      <span class="user-icon properties-icon">   
      </span>
      Manage Properties
    </a> 
  </li>
  <li class="item">
    <a href="#">
      <span class="user-icon payments-icon">
      </span>
      Manage Payments
    </a> 
  </li>
  <li class="item">
    <a href="#">
      <span class="user-icon logout-icon">            

      </span>
      Logout
    </a> 
  </li> 
</ul>
</div>
</div>