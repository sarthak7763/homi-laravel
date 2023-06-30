<!doctype html>
<html lang="en">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="{{url('/')}}/assets_front/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="{{url('/')}}/assets_front/css/custom.css" rel="stylesheet">  
  <link rel="icon" href="images/favicon.png">
  <title>Hello, world!</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="dashboard-page"> 
  <header class="p-3">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <div class="logo col-lg-auto me-lg-auto">
          <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">   
            <img src="images/logo.png">
          </a>
        </div>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="account-box">
              <div class="header-profile">
                <img class="rounded-pill" src="images/user-icon.jpg">
              </div>
              <div class="account-down">
                <span>Welcome</span>
                <strong>Albert Flores</strong>
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

  <main>
   <section class="section-dashboard">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-4 mb-3">
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
              <h3>150</h3>
              <p class="mb-0">Total Properties</p>
            </div>
          </div>
        </div>          
      </div>
      <div class="col-4 mb-3">
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
            <h3>100</h3>
            <p class="mb-0">Total Bookings</p>
          </div>
        </div>
      </div>          
    </div>
          <div class="col-4 mb-3">
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
            <h3>50</h3>
            <p class="mb-0">Ongoing Bookings</p>
          </div>
        </div>
      </div>          
    </div>
          <div class="col-4 mb-3">
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
            <h3>80</h3>
            <p class="mb-0">Completed Bookings</p>
          </div>
        </div>
      </div>          
    </div>
          <div class="col-4 mb-3">
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
            <h3>20</h3>
            <p class="mb-0">Cancelled Bookings</p>
          </div>
        </div>
      </div>          
    </div>

            <div class="col-4 mb-3">
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
              <h3>120</h3>
              <p class="mb-0">Total Property for Active
Selling</p>
            </div>
          </div>
        </div>          
      </div>
              <div class="col-4 mb-3">
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
              <h3>70</h3>
              <p class="mb-0">Total Rented/Sold
Properties</p>
            </div>
          </div>
        </div>          
      </div>
  </div>
</div>
</section>
</main>



<footer>
  <div class="copyright-section text-center">
    <div class="container">
      <p>© 2023 - Homi. All rights reserved</p>          
    </div>
  </div>
</footer>
<!--Jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<!-- Owl Carousel -->
<script src="js/owl.carousel.min.js"></script>
<!-- custom JS code after importing jquery and owl -->
<script type="text/javascript">
  $(document).ready(function () {
    $(".owl-carousel").owlCarousel();
  });

  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 3
      },
      1000: {
        items: 5
      }
    }
  })
</script>
<script>
  $(".profile-nav .item").on("click", function() {
    $(".profile-nav .item").removeClass("active");
    $(this).addClass("active");
  });

</script>


</body>
</html> 