@extends('admin::layouts.master')
@section('title', 'Create Sub-admin')
@section('css')
<style type="text/css">
    label.error{
        color: red;
         font-weight: bold;
      
    }

    #errNm1{
          color: red;
        position: relative;
        left: 15px;

    }
</style>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
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
                                    <h4>Create Sub-admin</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-sub-admins')}}">Sub-admin</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-add-sub-admin')}}">Create Sub-admin</a> </li>
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


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                                <!-- <div class="card-header">
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
                                <div class="card-block">
                                    <form id="add-sub-admin" action="{{ route('admin-add-sub-admin-post') }}" method="POST" enctype="multipart/form-data" autocomplete="off" name="saveSubAdminForm">
                                        {{ csrf_field() }}
                                    <div class="row">   
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Profile Pic <span style="color:red;">*</span></label>
                                                <input type="file" class="form-control  @error('photo') is-invalid @enderror" name="photo" id="profile-img">
                                                @if ($errors->has('photo'))
                                                    <span class="invalid-feedback" role="alert">
                                                       <strong>{{ $errors->first('photo') }}</strong>
                                                    </span>
                                                @endif

                                            </div>
                                        </div>
                                      {{--<div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">User Name <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="User Name" value="{{old('username')}}">
                                                @if ($errors->has('username'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>--}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">First Name <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="First Name" value="{{old('first_name')}}">
                                                @if ($errors->has('first_name'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Last Name <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control  @error('last_name') is-invalid @enderror" placeholder="Last Name" name="last_name" value="{{old('last_name')}}">
                                                @if ($errors->has('last_name'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Email <span style="color:red;">*</span></label>
                                                <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{old('email')}}">
                                                @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                               <strong> {{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 phone_number_sec">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Phone Number <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control us_telephone  @error('mobile_no') is-invalid @enderror" id="phone_number" autocomplete="off" name="mobile_no" placeholder="  Phone Number" value="{{ old('mobile_no')}}"  data-mask="999-999-9999">
                                                @if ($errors->has('mobile_no'))
                                               <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('mobile_no') }}</strong>
                                               </span>
                                                @endif
                                               
                                                <label for="phone_number" style="color: red;display: none;" class="error_code">Phone number is invalid.</label>

                                               <input type="hidden" class="contact_code"  name="contact_code" value="+1">
                                                <input type="hidden" class="country_name"  name="country_name" value="United States: +1">
                                                <input type="hidden" class="country_code" name="country_code" value="us">
                                               
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Password <span style="color:red;">*</span></label>
                                                <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password"  name="password" placeholder="Password" value="{{old('password')}}">
                                                @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                                <small>The password must have a minimum of 7 characters, 1 digit, and 2 special character(!$#%@%&_) </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Confirm Password <span style="color:red;">*</span></label>
                                                <input type="password" class="form-control  @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Confirm Password" value="{{old('confirm_password')}}">
                                                @if ($errors->has('confirm_password'))
                                               <span class="invalid-feedback" role="alert">
                                               <strong>{{ $errors->first('confirm_password') }}</strong>
                                               </span>
                                                @endif
                                               
                                            </div>
                                        </div>
                                        <div class="row col-md-12 errorTxt">
                                                <span id="errNm1"></span>
                                              </div>
                                        @if(@$perArr) 
                                          <div class="col-md-12">
                                                <div class="form-group">
                                                   
                                                    <strong>Permission:</strong>
                                                      @if ($errors->has('permission_name'))
                                                    
                                                    <span class="invalid-feedback" role="alert">
                                                      <strong> {{ $errors->first('permission_name') }}</strong>
                                                    </span>
                                                    @endif
                                                   
                                                    <div class="row col-md-12">
                                                   
                                                    @foreach(@$perArr as $key=>$value)
                                                    @if ($key != "default")
                                                      <ul class="mx-2 my-2"><li>

                                                        <input type="checkbox" class="checkAll" value="{{$key}}" id="{{$key}}">
                                                        <label class="text-uppercase font-weight-bold" for="{{$key}}">{{$key}}</label>
                                                       

                                                   
                                                    @foreach($value as $li)

                                                             
                                                            
                                                        <li><label>
                                                        <input type="checkbox" name="permission_name[]" value="{{ $li['id']}}" class="name @error('permission_name') is-invalid @enderror" data-error="#errNm1"> {{ $li['caption'] }}
                                                          @if ($errors->has('permission_name'))
                                                           <span class="invalid-feedback" role="alert">
                                                           {{ $errors->first('permission_name') }}
                                                           </span>
                                                            @endif

                                                        {{-- {{ Form::checkbox('permission_name[]', $li['id'],false, array('class' => 'name')) }}
                                                        {{ $li['name'] }} --}}</label></li>
                                                   
                                                     @endforeach
                                                     </ul>
                                                     @endif
                                                    @endforeach
                                                    </div>
                                                </div>
                                                </div>
                                                 @endif

                                        {{--<div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Permission <span style="color:red;">*</span></label>
                                              <!--   <select name="permission_name[]" id="permission_name" class="permission_name form-control js-example-placeholder-multiple col-sm-12 @error('permission_name') is-invalid @enderror" multiple="multiple"> -->
                                                    <?php /*
                                                    if (@$perArr && count($perArr) > 0) {
                                                        foreach ($perArr as $key => $val) {
                                                            foreach($val as $li){
                                                                echo $li['name'];
                                                            }
                                                           
                                                           

                                                            }
                                                           /*if ($key != "default") {
                                                           //      ?>
                                                           //      <option value="{{ $key }}" >{{ ucwords($key) }}</option>
                                                           //      <?php
                                                           //  }
                                                        } 
                                                    } */
                                                    ?>
                                               <!--  </select> -->
                                              {{--  @if ($errors->has('permission_name'))
                                                <span class="invalid-feedback" role="alert">
                                               <strong> {{ $errors->first('permission_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                       --}}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" name="submitBuyerInfo" id="submitSubAdmin" class="btn btn-primary m-b-0">Save</button>

                                                <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                <a href="{{route('admin-sub-admins')}}" class="btn btn-inverse m-b-0">Go Back</a>
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

     .select2-selection--multiple{
        border-radius: 2px !important;
        border-color: #cccccc !important;
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

$(document).on("click", "#submitSubAdmin", function () {
    $('form[name=saveSubAdminForm]').validate({ 
        rules: {
            mobile_no: {
                required: true,
                maxlength:12,
                minlength:12,
                //digits: true,
                //phoneNumValidation: true,
                 remote: 
                {
                    url: "{{route('admin-ajax-check-phone-exist')}}",
                    type: "post",
                    data: {
                        'mobile_no': function () { return ($('#phone_number').val().replace(/\D/g, '').slice(-10)); }
                    }                   
                }      
            },
            password: {
              required: true,
              minlength: 7,
              strong_password:"#password",
            },
            confirm_password : {
                required: true,
                minlength : 7,
                equalTo : "#password",
                strong_password:"#confirm_password",

            },
            photo: {
                required: true
            },
            "permission_name[]": { required: true, minlength: 1 },
            first_name:{
                required:true,
                maxlength:30
            }, 
            last_name:{
                required:true,
                maxlength:30
            }, 
            email: {
                required: true,
                email: true,
                 remote: 
                {
                    url: "{{route('admin-ajax-check-email-exist')}}",
                    type: "post",
                    data: {
                        'email': function () { return $('#email').val(); }
                    }                   
                }     
            },
          
        },
        messages: {
            mobile_no: {
                required: "Please enter mobile number",
                //digits: "Your mobile number must be in digits",
                remote:"Mobile number already exist",
            },
            first_name: {
                required: "Please enter first name",
                maxlength:"First name length should be maximum 30 characters long"
            },
            last_name: {
                required: "Please enter last name",
                maxlength:"Last name length should be maximum 30 characters long"
            },
            email: {
                required: "Please enter email address",
                email: "Your email address must be in the format of name@domain.com",
                remote:"Email already exist"
            },
            password: {
                required:"Please enter password",
                minlength:"password must be at least 6 characters long"
            },
            confirm_password: {
                equalTo: "Please enter confirm password same as password",
                required:"Please enter confirm password",
                minlength:"confirm password must be at least 6 characters long"
            },
            photo: {
                required: 'Please select the image!'
            },
            'permission_name[]': {
                required: "Please select atleast one permission"
              
            }
   
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
              },
               errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }

    // errorPlacement : function(error, element) {
    // //error.insertAfter($("#userPhoneDiv"));
    // }
    });
});



//////////////////////
$(document).ready(function(){
    $(".js-example-placeholder-multiple").select2({
        placeholder: "  Select Permission"
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
    initialCountry: "us",
    onlyCountries:['US','CA'],
    geoIpLookup: function (callback) {
        jQuery.get("http://ipinfo.io", function () {}, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
});

</script>

<script type="text/javascript">
   
    jQuery(document).ready(function () {
        jQuery(".ckbCheckAll").click(function () {
            var ids = jQuery(this).attr("data-id");
            if (this.checked) {
                jQuery('.' + ids).each(function () {
                    jQuery(this).prop('checked', true);
                });
            } else {
                jQuery('.' + ids).each(function () {
                    jQuery(this).prop('checked', false);
                });
            }
        });

       
        jQuery("#phone_number").on('change', function () {
            var code = jQuery('.selected-dial-code').text();
            var country_name = jQuery('.selected-flag').attr('title');
            jQuery(".contact_code").val(code);
            jQuery(".country_name").val(country_name);
        });

        jQuery(".country").on("click", function () {
            var countryCode = jQuery(this).attr("data-country-code");
            jQuery(".country_code").val(countryCode);
        });




//PASSWORD CUSTOM VALIDATIONS
$.validator.addMethod("strong_password", function (value, element) {
    let password = value;
    if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!$#%@%&_])(.{8,20}$)/.test(password))) {
        return false;
    }
    return true;
}, function (value, element) {
    let password = $(element).val();
    if (!(/^(.{8,20}$)/.test(password))) {
        return 'Password must be between 8 to 20 characters long.';
    }
    else if (!(/^(?=.*[A-Z])/.test(password))) {
        return 'Password must contain at least one uppercase.';
    }
    else if (!(/^(?=.*[a-z])/.test(password))) {
        return 'Password must contain at least one lowercase.';
    }
    else if (!(/^(?=.*[0-9])/.test(password))) {
        return 'Password must contain at least one digit.';
    }
    else if (!(/^(?=.*[!$#%@%&_])/.test(password))) {
        return "Password must contain special characters from !$#%@%&_.";
    }
    return false;
});
//



        $('#subadmin_permission').select2();
    //     jQuery("#add-sub-admin").validate({
    //         rules: {
    //             username: "required",
    //             first_name: "required",
    //             last_name: "required",
    //             email: {
    //                 required: true,
    //                 email: true
    //             },
    //             mobile_no: {
    //                 required: true,
    //                // phoneno: true,
    //                 minlength: 4,
    //                 maxlength: 14,
                     
    //             },
    //             password: {
    //               required: true,
    //               minlength: 7,
    //               strong_password:"#password",
    //             },
    //             confirm_password : {
    //                 required: true,
    //                 minlength : 7,
    //                 equalTo : "#password",
    //                 strong_password:"#confirm_password",

    //             },
    //             photo: {
    //                 required: true
    //             },
    //             "permission_name[]": { required: true, minlength: 1 },
    //         },
    //         messages: {
    //             username: "Please enter username",
    //             first_name: "Please enter first name",
    //             last_name: "Please enter last name",
    //             email: {
    //                 required: "Please enter email address",
    //                 email: "Email address must be in the format of name@domain.com"
    //             },
    //             mobile_no: {
    //                 required: "Please enter phone number",
    //                 //phoneno: "Phone number must be in the format."
    //             },
    //             password: {
    //                 required:"Please enter password",
    //                 minlength:"password must be at least 6 characters long"
    //             },
    //             confirm_password: {
    //                 equalTo: "Please enter confirm password same as password",
    //                 required:"Please enter confirm password",
    //                 minlength:"confirm password must be at least 6 characters long"
    //             },
    //             photo: {
    //                 required: 'Please select the image!'
    //             },
    //              'permission_name[]': {
    //                 required: "Please select atleast one permission"
                  
    //             }
    //         },
    //           errorPlacement: function(error, element) {
    //   var placement = $(element).data('error');
    //   if (placement) {
    //     $(placement).append(error)
    //   } else {
    //     error.insertAfter(element);
    //   }
    // }
    //     });
    
    });

//CHECK UNCHECK PERMISSION ALL CHECK ALL UNCHECK
$('.checkAll').on('click', function() {
     if($(this).is(':checked')){
   $(this).closest('li').siblings('li').find('.name').prop('checked', true);
   }else{
     $(this).closest('li').siblings('li').find('.name').prop('checked', false);
   }
});
</script>
@endsection

