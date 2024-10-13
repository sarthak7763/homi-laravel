    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
<meta name="_token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    @php $favicon=getFavicon(); @endphp
    <link rel="icon" href="{{asset('storage'.$favicon)}}" type="image/x-icon">

    <!---google api key starts here-->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZWubYF4RSrhWvk_cDI17x4oeUaZm7lf8&libraries=places&callback=initMap"
        async defer>
    </script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZWubYF4RSrhWvk_cDI17x4oeUaZm7lf8&libraries=places&callback=initMap"></script>

    <!-- google api ends-->
    
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/bootstrap/css/bootstrap.min.css')}}">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
 
    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css')}}">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/multiselect/css/multi-select.css')}}">
   
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Date-range picker css  -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css
" rel="stylesheet" type="text/css" />


   {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/bootstrap-daterangepicker/css/daterangepicker.css')}}">--}}
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">

    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/assets/icon/themify-icons/themify-icons.css')}}">

    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/assets/icon/icofont/css/icofont.css')}}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/assets/icon/feather/css/feather.css')}}">

    <!-- jquery file upload Frame work -->
    <link href="{{ asset('assets_admin/jquery.filer/css/jquery.filer.css')}}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets_admin/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet">
      
     <!-- Select 2 css -->
     <link rel="stylesheet" href="{{ asset('assets_admin/bower_components/select2/css/select2.min.css')}}">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/lightbox2/css/lightbox.min.css')}}">
    
    <!-- Chartlist chart css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/bower_components/chartist/css/chartist.css')}}">
    <!-- Style.css -->

  <link rel="stylesheet" type="text/css" href="{{asset('toastr.min.css')}}">
  

   <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/sweetalert.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/assets/css/style.css')}}">
     <link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/assets/css/jquery.mCustomScrollbar.css')}}">
  
  <style>
  .swal-footer {
     text-align: center !important;
  </style>