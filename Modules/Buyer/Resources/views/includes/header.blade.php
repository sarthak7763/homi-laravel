<!doctype html>
<html lang="en">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
      href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet"
    />

    <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	
    

    
    
  <!-- Bootstrap CSS -->
  <link href="{{url('/')}}/assets_front/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="{{url('/')}}/assets_front/css/custom.css" rel="stylesheet">  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  @php $favicon=getFavicon(); @endphp
  <link rel="icon" href="{{asset('storage'.$favicon)}}" type="image/x-icon">
  <title>Homi Seller Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="account-page"> 
  <header class="p-3">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <div class="logo col-lg-auto me-lg-auto">
          <a href="{{route('buyer.dashboard')}}" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">   
            <img src="{{asset('storage'.getLogo())}}">
          </a>
        </div>
        

        <div class="dropdown text-end" id="seller_account">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle profiledropdown"  data-bs-toggle="dropdown" aria-expanded="false">
            <div class="account-box">
              @php $sellerinfo=getSellerinfo(auth()->user()->id); @endphp
              <div class="header-profile">

              @if($sellerinfo->profile_pic)
                <img class="rounded-pill-box" src="{{url('/')}}/images/user/{{$sellerinfo->profile_pic}}">
                           
                           @else
                           <img class="rounded-pill-box" src="{{url('/')}}/images/user-img.png">
                           @endif   
                
              </div>
              <div class="account-down">
                <span>Welcome</span>
                <strong>{{$sellerinfo->name}}</strong>
              </div>              
            </div>
            </a>
          <ul class="dropdown-menu text-small ssss" id="seller_dropdown">
            
            <li class = "dropdown-item {{ (request()->is('dealer/my-profile*')) ? 'active' : '' }}"><a href="{{route('buyer.my-profile')}}"><i class="fa-regular fa-user"></i> My Profile</a></li>
            <li class="dropdown-item" ><a href="{{route('buyer.change-password')}}" > <i class="fa-solid fa-unlock"></i> Change Password</a></li>
            <li class = "dropdown-item {{ (request()->is('dealer-logout*')) ? 'active' : '' }}"><a data-toggle="modal" data-target="#exampleModalCenter"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset('assets_admin/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
$(document).on('click','#seller_account',function(){
    
  $('#seller_dropdown').toggle();
    
});
</script>

