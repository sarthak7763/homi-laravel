
<style>
  button.btn.btn-primary.px-4 {
    line-height: normal;
}
    .logout_modal  p {
    font-size: 18px;
    font-weight: bold;
    color: #23323a;
}

.logout_modal  .btn {
    line-height: 36px;
    font-size: 16px;
    padding: 2px 10px;
    height: auto;
    min-height: auto;
    color: #fff;
}
</style>
<div class="col-md-4 col-lg-3  mb-4">
@php $sellerinfo=getSellerinfo(auth()->user()->id); @endphp
<div class="profile-div">
  <div class="main-profile rounded-circle mb-3">

  @if($sellerinfo->profile_pic)
  <img class="rounded-pill-box" src="{{url('/')}}/images/user/{{$sellerinfo->profile_pic}}">
              @else
    <img class="rounded-pill-box" src="{{url('/')}}/images/1699333958.jpg">
            @endif  
   
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
      <i class="fa-solid fa-laptop me-3"></i>
      Dashboard
    </a>
  </li>

  <li class="item {{ (request()->is('dealer/my-profile*')) ? 'active' : '' }}">
    <a href="{{route('buyer.my-profile')}}">
      <i class="fa-regular fa-user me-3"></i>
      </span>
      My Profile
    </a>
    </li>
  <li class="item {{ (request()->is('dealer/edit-profile*')) ? 'active' : '' }} ">
    <a href="{{route('buyer.edit-profile')}}">
      <i class="fa-solid fa-user-pen me-3"></i>
      </span>
      Edit Profile
    </a>
  </li>
  <li class="item {{ (request()->is('dealer/bookings*')) ? 'active' : '' }}">
    <a href="{{route('buyer.bookings','ongoing')}}">
      <i class="fa-solid fa-book-open-reader me-3"></i> 
      </span>
      My Bookings
    </a>
  </li>
  <li class="item {{ (request()->is('dealer/subscription-plans*')) ? 'active' : '' }}">
    <a href="{{route('buyer.subscription-plans')}}">
      <i class="fa-regular fa-lightbulb me-3"></i>
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
      <i class="fa-solid fa-building-user me-3"></i>
      Manage Properties
    </a> 
  </li>
  <!-- <li class="item {{ (request()->is('')) ? 'active' : '' }}">
    <a href="{{route('buyer.payment')}}">
      <span class="user-icon payments-icon">
      </span>
      Manage Payments
    </a> 
  </li> -->
  <li class="item {{ (request()->is('dealer-logout*')) ? 'active' : '' }}">
    <a href=""  data-toggle="modal" data-target="#exampleModalCenter">
 <i class="fa-solid fa-arrow-right-from-bracket me-3"></i>
      Logout
    </a> 
  </li> 
</ul>
</div>
</div>
<div class="modal fade logout_modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body p-0 text-center">
        <p class="mb-0 p-3">Are you sure you want to logout?</p>
        <div class="d-flex p-3 gap-3 border-top justify-content-center ">
          <button type="button" class="btn btn-danger cancel_btn  mx-0 mt-0 m-0 px-4" data-dismiss="modal">Cancel</button>
          <a href="{{route('buyer.logout')}}" class="btn btn-primary px-4" button type="button">ok</a>
        </div>
      </div>
    </div>
  </div>
</div>