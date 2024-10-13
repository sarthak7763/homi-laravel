@extends('admin::layouts.master')
@section('title', 'Edit Sub-Admin')
@section('css')
<style type="text/css">
    label.error{
        color: red;
         font-weight: bold;
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
                                    <h4>Edit Sub-admin</h4>
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
                                <div class="card-header">
                                    <h5>Edit Sub Admin</h5>
                                 <!--    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div> -->
                                </div>
                                <div class="card-block">
                                     
                                    <form class="box bg-white" id="edit-sub-admin" name="updateSubAdminForm" action="{{route('admin-edit-sub-admin-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="slug" value="{{$user->slug}}" />
                                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                                         <input type="hidden" id="id" name="id" value="{{$user->id}}" />
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Profile Pic <span style="color:red;">*</span></label>
                                                    <input type="file" class="file form-control  @error('photo') is-invalid @enderror" name="photo" id="profile-img">
                                                    <img src="{{$user->profile_pic}}" height="50" width="50" class="profile_image_cls" id="profile_image_cls" alt="img">

                                                </div>
                                                @if ($errors->has('photo'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $errors->first('photo') }}</strong>
                                                    </span>
                                                @endif
                                               
                                            </div>
                                               
                                            {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">User Name <span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control  @error('username') is-invalid @enderror" minlength="1" maxlength="50" id="username" name="username" placeholder="User Name" value="{{$user->username}}">
                                                    @if ($errors->has('username'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong> {{ $errors->first('username') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>--}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">First Name <span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control  @error('first_name') is-invalid @enderror" minlength="1" maxlength="25" id="first_name" name="first_name" placeholder="First Name" value="{{$user->first_name}}">
                                                    @if ($errors->has('first_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                         <strong>  {{ $errors->first('first_name') }}</strong>
                                                        </span>
                                                    @endif

                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Last Name <span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control  @error('last_name') is-invalid @enderror" minlength="1" maxlength="25" id="last_name" placeholder="Last Name" name="last_name" value="{{$user->last_name}}">
                                                    @if ($errors->has('last_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                           <strong>  {{ $errors->first('last_name') }}</strong>
                                                        </span>
                                                    @endif
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Email <span style="color:red;">*</span></label>
                                                  
                                                        <input type="email" class="form-control  @error('email') is-invalid @enderror" minlength="1" maxlength="100" id="email" name="email" placeholder="Email" value="{{$user->email}}">
                                                       @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                          <strong>  {{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-6 phone_number_sec">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Phone Number <span style="color:red;">*</span></label>
                                                  
                                                        <input type="tel" class="form-control us_telephone @error('mobile_no') is-invalid @enderror"  data-mask="999-999-9999" id="phone_number"  name="mobile_no" placeholder="Phone Number" value="{{ (isset($user->mobile_no) && !empty($user->mobile_no))?$user->mobile_no:"" }}">
                                                         @if ($errors->has('mobile_no'))
                                                        <span class="invalid-feedback" role="alert">
                                                           <strong> {{ $errors->first('mobile_no') }}</strong>
                                                        </span>
                                                    @endif
                                                        <input type="hidden" class="contact_code" id="contact_code" name="contact_code" value="{{ @$user->country_std_code }}">
                                                        <input type="hidden" class="country_name" name="country_name" value="{{ @$user->country_name }}">
                                                        <input type="hidden" class="country_code" name="country_code" value="{{ @$user->country_code }}">
                                                       
                                                    
                                                </div>
                                            </div>

                                            <?php
                                            $userPrPermitn = [];
                                            if (@$userPr && count($userPr) > 0) {
                                                foreach ($userPr as $key => $userPrEach) {
                                                    if ($key != "default") {
                                                        $userPrPermitn[] = $key;
                                                    }
                                                }
                                            }

                                              if (@$userPr && count($userPr) > 0) {
                                                foreach ($userPr as $key => $userPrEach) {
                                                    if ($key != "default") {
                                                        foreach ($userPrEach as $v) {
                                                        $userPrPermitn[] = $v['id'];
                                                        }
                                                    }
                                                }
                                            }
                                            ?>

                                             <div class="errorTxt ml-3">
                                                <span id="errNm1"></span>
                                              </div>
                                              @if(@$perArr) 
                                          <div class="col-md-12">
                                                <div class="form-group">
                                                   
                                                    <strong>Permission:</strong>
                                                    <div class="row col-md-12">
                                                   
                                                    @foreach(@$perArr as $key=>$value)
                                                    @if ($key != "default")
                                                      <ul class="mx-4 my-3">


                                                      <li> <input type="checkbox" class="checkAll" value="{{$key}}" id="{{$key}}">
                                                        <label class="text-uppercase font-weight-bold" for="{{$key}}">{{$key}}</label>


                                                     </li>
                                                    @foreach($value as $li)
                                                             
                                                            
                                                        <li><label>
                                                        <?php if(in_array($li['id'], $userPrPermitn)){
                                                            $checked="checked";
                                                            }else{
                                                                 $checked="";
                                                                }  ?>

                                                                <input type="checkbox" name="permission_name[]" class="name"  data-error="#errNm1" value="{{$li['id']}}" {{$checked}}>
                                                     {{--    {{ Form::checkbox('permission_name[]', $li['id'],$checked, array('class' => 'name')) }}--}}
                                                        {{ $li['caption'] }}

                                                        </label></li>
                                                    
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
                                                    <label class="font-weight-bold">Permission</label>
                                                    <select name="permission_name[]" id="permission_name" class="permission_name js-example-placeholder-multiple col-sm-12  @error('permission_name') is-invalid @enderror" multiple="multiple">
                                                        <?php
                                                        if (@$perArr && count($perArr) > 0) {
                                                            foreach ($perArr as $key => $val) {
                                                                if ($key != "default") {
                                                                    ?>
                                                                    <option value="{{ $key }}" <?php echo (in_array($key, $userPrPermitn)) ? 'selected="selected"' : ""; ?>>
                                                                        {{ ucwords($key) }}
                                                                    </option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    @if ($errors->has('permission_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong> {{ $errors->first('permission_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>--}}

                                            {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Status <span style="color:red;">*</span></label>
                                                    <select name="status" class="form-control" id="status">
                                                        <option value="1" @if($user->status== 1) selected @endif>Active</option>
                                                        <option value="0"  @if($user->status== 0) selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>--}}
                                        </div>
                                        <div class="row"> 
                                            <div class="col-md-12 mb-3 text-center">
                                                <button type="submit" name="submitBtn" id="updateSubAdminBtn" class="btn btn-primary m-b-0 text">Update</button>

                                              <a href="{{route('admin-sub-admins')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                            </div>
                                        </div>
                                    </form>
                                        
                                    <hr>
                                  
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Reset Sub Admin Password</h5>
                                        </div> 
                                        <div class="card-body">
                                            <form class="box bg-white" id="sub-admin-change-password" action="{{route('admin-sub-admin-change-password')}}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="slug" value="{{$user->slug}}" />
                                             <input type="hidden" name="id" value="{{$user->id}}" />
                                            <input type="hidden" name="email" value="{{$user->email}}" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Password <span style="color:red;">*</span></label>
                                                        <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" minlength="6" maxlength="15" placeholder="Password" name="password" value="{{old('password')}}">
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror

                                                         <small>The password must have a minimum of 7 characters, 1 digit upper case, 1 lower case and a special character(!$#%@%&_) </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Confirm Password <span style="color:red;">*</span></label>
                                                        <input type="password" class="form-control  @error('photo') is-invalid @enderror" id="confirm_password" minlength="6" maxlength="15" placeholder="Confirm Password" name="confirm_password" value="{{old('confirm_password')}}">
                                                        {{--@if ($errors->has('confirm_password'))
                                                            <span class="invalid-feedback" role="alert">
                                                                 {{ $errors->first('confirm_password') }}
                                                            </span>
                                                        @endif--}}
                                                        @error('confirm_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-12 mb-3 text-center">
                                                   
                                                    <button type="submit" class="btn btn-primary" id="changePassword">Reset Password</button>
                                                     <a href="{{route('admin-sub-admins')}}" class="btn btn-inverse m-b-0">Go Back</a>
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
</div>
@endsection

@section('js')
<style type="text/css">
    .permission-cls {
        width: 100%;  
        padding: 0 15px;
    }
    .permission-cls h6 {
        font-size: 20px;
        font-weight: 600;
    }
    .permission-cls ul {
        padding: 0;
        margin: 0;
        list-style: none;
        width: 100%;
    }
    .permission-cls ul li {
        padding: 15px;
        border: 1px solid #ced4da;
    }
    .label-title {
        display: inline-block;
        font-size: 20px;
        border-bottom: 1px solid #ced4da;
        padding-bottom: 10px;
        font-weight: 600;
    }
    .permission-cls ul li.form-group .form-check-wrap input {
        float: left;
        width: 18px;
        margin-top: 5px;
        margin-right: 5px;
    }
    .permission-cls ul li.form-group .form-check-wrap {
        display: inline-block;
        width: 24%;
        vertical-align: middle;
    }
    .permission-cls ul li.form-group .form-check-wrap .form-check-label {
        font-size: 15px;
        display: inline;
        cursor: pointer;
    }

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

jQuery.validator.addMethod("phoneNumValidation", function(value) {
    return $("#phone_number").intlTelInput("isValidNumber")
}, 'Please enter a valid number');

jQuery(document).on("click", "#updateSubAdminBtn", function () {
    jQuery('form[name=updateSubAdminForm]').validate({ 
        rules: {
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
                minlength: 12,
               // phoneNumValidation: true,
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
            'permission_name[]' : {
                required: true,
            },
        },
        messages: {
            mobile_no: {
                required: "We need your mobile number to contact you",
                digits: "Your mobile number must be in digits",
                remote:"Mobile number already exist",
            },
            name: {
                required: "Please specify your name",
                maxlength:"Name length should be maximum 30 characters long"
            },
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com",
                remote:"Email already exist"
            },
            'permission_name[]': {
                required: "Select at least one permission",
            },
   
        },
        submitHandler: function(form) 
        {
             
            $("#loading").show();
            $("#updateSubAdminBtn").hide();
            form.submit();
           
        },
        invalidHandler: function(){
              $("#updateSubAdminBtn").show();
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

    });
});

///////////////////////////////////////////



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
    initialCountry: "{{ @$user->country_code }}",
    onlyCountries:['US','CA'],
    geoIpLookup: function (callback) {
        jQuery.get("http://ipinfo.io", function () {}, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
});

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


      
        

        jQuery("#profile-img").change(function () {
            profileImgReadURL(this);
        });
    });

    function profileImgReadURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                jQuery('#profile_image_cls').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


//PASSWORD CUSTOM VALIDATIONS
jQuery.validator.addMethod("strong_password", function (value, element) {
    let password = value;
    if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!$#%@%&_])(.{8,20}$)/.test(password))) {
        return false;
    }
    return true;
}, function (value, element) {
    let password = $(element).val();
    if (!(/^(.{7,20}$)/.test(password))) {
        return 'Password must be between 7 to 20 characters long.';
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
        return "Password must contain special characters from @#$%&.";
    }
    return false;
});
//
   jQuery(document).on("click", "#changePassword", function () 
    {
        jQuery('form[name=sub-admin-change-password]').validate({            
            rules: {
                password: {
                    required:true,
                    minlength: 7,
                    strong_password:"#password",
                },
                confirm_password : {
                    required:true,
                    minlength : 7,
                    equalTo : "#password",
                    strong_password:"#confirm_password",
                }
            },
            messages: {
                password: {
                    required:"Password is required",
                    minlength:"Password must be atleast 7 characters long"
                },
                confirm_password: {
                    required:"Confirm Password is required",
                    equalTo: "Confirm password must be same as password",
                }
            },
            submitHandler: function(form) 
            {
                $("#loading").show();
                $("#changePassword").hide();
                form.submit();
            },
             invalidHandler: function(){
                $("#changePassword").show();
                $("#loading").hide();
              }
        });
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

