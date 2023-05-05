@extends('admin::layouts.master')
@section('title', 'Edit Buyer')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">

<style type="text/css">
  label.error{
    color: red;
     font-weight: bold;
    }
 #city-error{
        position: relative;
    top: 66px;
    right: 84px;
    }
</style>
@endsection
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Edit Buyer</h4>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-list')}}">Buyer List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-user-edit',$userInfo->id)}}">Edit Buyer</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                               <!--  <div class="card-header">
                                    <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div>
                                </div> -->
                                  @if ($message = Session::get('success'))
                                    <div class="row">
                                        <div class="col-md-12">
                                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                                             <label  class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"  style="font-size: 19px;margin-top: -1px;">&times;</span>
                                              </label>
                                                {{ $message }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($message = Session::get('error'))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                             <label type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true" style="font-size: 19px;margin-top: -1px;">&times;</span>
                                              </label>
                                                
                                                {{ $message }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="card-block">
                                    <form method="POST" class="box bg-white" action="{{route('admin-user-update')}}" name="updateBuyerForm"  enctype="multipart/form-data" id="buyerFrom">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Profile Pic</label>
                                                        <input type="hidden" name="id" id="id" value="{{$userInfo->id}}">
                                                       <input type="file" class="form-control @error('profile_pic') is-invalid @enderror"  name="profile_pic" id="profile_pic"   accept="image/*" onchange="loadFile(event)">
                                                        <img id="output" @if(@$userInfo->profile_pic!="") src="{{@$userInfo->profile_pic}}" width="100" height="100" @endif/>
                                                        @error('profile_pic')
                                                              <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Full Name
                                                    <span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control only_alpha @error('name') is-invalid @enderror" name="name" id="name"   value="{{$userInfo->name}}">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Email<span style="color:red;">*</span></label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"  value="{{$userInfo->email}}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                          
                                           
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" id="submitBuyer" class="btn btn-primary m-b-0">Update</button>

                                                <a href="{{route('admin-user-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                            </div>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<style type="text/css">
    .phone_number_sec .intl-tel-input {
        width: 100%;
    }
    .phone_number_sec .form-group .form-control {
        padding-left: 80px;
    }
    .phone_number_sec .flag-box {
        display: inline-block;
        vertical-align: middle;
    }
    .phone_number_sec .country .country-name, .phone_number_sec .country .country-dial-code {
        overflow: hidden;
        padding-left: 15px;
    }
    .form-check-wrap {
        display: inline-block;
        vertical-align: middle;
        padding: 0 20px 13px 0;
    }
    .form-group .form-check-wrap label {
        width: auto;
    }
    .form-check-wrap input[type="checkbox"], .form-check-wrap input[type="radio"] {
        vertical-align: middle;
    }

</style>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

<script type="text/javascript">
$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$.validator.addMethod("phoneNumValidation", function(value) {
    return $("#phone_number").intlTelInput("isValidNumber")
}, 'Please enter a valid number');

$(document).on("click", "#submitBuyer", function () {
    $('form[name=updateBuyerForm]').validate({ 
        rules: {
            name:{
                required:true,
                maxlength:30
            }, 
            email: {
                required: true,
                email: true,
                remote: 
                {
                    url: "{{route('admin-ajax-check-exist-email')}}",
                    type: "post",
                    data: {
                        'email': function () { return $('#email').val(); },
                        'id':function () { return $('#id').val(); }
                    }                   
                }      
            },
            mobile_no: {
                required: true,
                // digits: true,
                 maxlength:12,
                 minlength:12,
                //phoneNumValidation: true,
                remote: 
                {
                url: "{{route('admin-ajax-check-exist-phone')}}",
                type: "post",
                data: {
                    'mobile_no': function () { return ($('#phone_number').val().replace(/\D/g, '').slice(-10)); },
                    'id':function () { return $('#id').val(); }
                    }                   
                }      
            },
            'city[]' : {
                required: true,
            },
        },
        messages: {
            mobile_no: {
                required: "Please enter mobile number",
                //digits: "Your mobile number must be in digits",
                remote:"Mobile number already exist",
            },
            name: {
                required: "Please enter name",
                maxlength:"Name length should be maximum 30 characters long"
            },
            email: {
                required: "Please enter email address",
                email: "email address must be in the format of name@domain.com",
                remote:"Email already exist"
            },
            'city[]': {
                required: "Select at least one city",
            },
   
        },
        submitHandler: function(form) 
        {
             
            $("#loading").show();
            $("#submitBuyer").hide();
            form.submit();
        },
        invalidHandler: function(){
              $("#submitBuyer").show();
              $("#loading").hide();
        }
    // errorPlacement : function(error, element) {
    // //error.insertAfter($("#userPhoneDiv"));
    // }
    });
});

$(document).ready(function(){
    $(".js-example-placeholder-multiple").select2({
        placeholder: "Select"
    });
});

var telInput = $("#phone_number");
  
telInput.on("countrychange", function () {
    var country_code_t = $("#phone_number").intlTelInput("getSelectedCountryData").iso2;
    jQuery(".country_code").val(country_code_t);

    var code = jQuery('.selected-dial-code').text();
    var country_name = jQuery('.selected-flag').attr('title');
    jQuery(".contact_code").val(code);
    jQuery(".country_name").val(country_name);
});


telInput.focusout(function () {
    var mobile_num=$(this).val();
    var phoneRegex =/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
    if (phoneRegex.test(mobile_num)) {
     
    } else {
         $(this).val("");
    }
});

// function test(){
//     var number =  $('input[name="mobile_no"]').val();
//     var classf = $(".selected-flag > div").attr("class");
//     var flag = classf.slice(-2);
//     var formattedNumber = intlTelInputUtils.formatNumber(number, flag, intlTelInputUtils.numberFormat.INTERNATIONAL);
//     $('input[name="mobile_no"]').val(formattedNumber);

// }

// telInput.on("keyup", function () {
//     test();
// });
// initialise plugin
telInput.intlTelInput({
    allowExtensions: true,
    formatOnDisplay: false,
    autoFormat: true,
    autoHideDialCode: true,
    autoPlaceholder: true,
    defaultCountry: "auto",
    ipinfoToken: "yolo",
    nationalMode: false,
    numberType: "MOBILE",
    //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    preferredCountries: ['sa', 'ae', 'qa', 'om', 'bh', 'kw', 'ma'],
    preventInvalidNumbers: true,
    separateDialCode: true,
    initialCountry: "{{ @$userInfo->country_code }}",
    onlyCountries:['US','CA'],
    geoIpLookup: function (callback) {
        jQuery.get("http://ipinfo.io", function () {}, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
});


   
      
        jQuery(document).on('keyup', "#phone_number", function () {
            var code = jQuery('.selected-dial-code').text();
            var country_name = jQuery('.selected-flag').attr('title');
            jQuery(".contact_code").val(code);
            jQuery(".country_name").val(country_name);
        });

        jQuery(".country").on("click", function () {
            var countryCode = jQuery(this).attr("data-country-code");
            jQuery(".country_code").val(countryCode);
        });

 

  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    $("#output").css("width", 200);
    $("#output").css("height", 150);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };


   $(document).on('click', '#changePassword', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('data-id');
            var change_btn = $(this);
            var url = "{{ route('admin-change-buyer-password') }}";
            
           
           var title ='Are you sure to generate new password ?';
            e.preventDefault();      
            swal({
              title: title,
              icon: "warning",
              buttons: [
                'No, cancel it!',
                'Yes, I am sure!'
              ],
              dangerMode: true,
            }).then(function(isConfirm) {
              if(isConfirm){
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {_token: "{{ csrf_token() }}",id:id},
                    dataType: "json",
                     beforeSend: function(){
                        $("#loading").show();
                    },
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function (data){
                     
                        toastr.success('Password generated successfully!');
                       // change_btn.html(status);
                        //change_btn.removeClass(status_class).addClass(newClass);
                    }         
                })
            } else {
                swal("Cancelled", "Password is not change", "error");
            }
            });         
    });   

</script>
@endsection
