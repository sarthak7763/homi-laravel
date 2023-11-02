<!doctype html>
<html lang="en">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="{{url('/')}}/assets_front/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="{{url('/')}}/assets_front/css/custom.css" rel="stylesheet">  
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
          <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">   
            <img src="{{asset('storage'.getLogo())}}">
          </a>
        </div>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="account-box">
              @php $sellerinfo=getSellerinfo(auth()->user()->id); @endphp
              <div class="header-profile">
                <img class="rounded-pill" src="{{url('/')}}/assets_front/images/user-icon.jpg">
              </div>
              <div class="account-down">
                <span>Welcome</span>
                <strong>{{$sellerinfo->name}}</strong>
              </div>              
            </div>
            
            
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>