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
                                          
                                            <div class="col-md-6 phone_number_sec">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Phone Number <span style="color:red;">*</span></label>
                                                  
                                                        <input type="tel" class="form-control us_telephone @error('mobile_no') is-invalid @enderror" id="phone_number" data-mask="999-999-9999" name="mobile_no" placeholder="Phone Number" value="{{ (isset($userInfo->mobile_no) && !empty($userInfo->mobile_no))?$userInfo->mobile_no:"" }}" >
                                                        @error('mobile_no')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                        <input type="hidden" class="contact_code" id="contact_code" name="contact_code" value="{{ @$userInfo->country_std_code }}">
                                                        <input type="hidden" class="country_name" name="country_name" value="{{ @$userInfo->country_name }}">
                                                        <input type="hidden" class="country_code" name="country_code" value="{{ @$userInfo->country_code }}">
                                                       
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Address<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{$userInfo->address}}">
                                                    @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Other Address</label>
                                                    <input type="text" class="form-control @error('home_address') is-invalid @enderror" name="home_address" id="home_address" value="{{$userInfo->home_address}}">
                                                    @error('home_address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Country<span style="color:red;">*</span></label>
                                                    
                                                    <select name="country" id="country" class="form-control @error('country') is-invalid @enderror" onchange="getState()" >
                                                    <option value="">Select Country</option>
                                                    @foreach($countryList as $cli)
                                                      
                                                            <option value="{{$cli->id}}" @if($cli->id == $userInfo->country) selected @endif>{{$cli->name}}</option>
                                                       
                                                        @endforeach 
                                                    </select>
                                                    @error('country')
                                                     <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">State<span style="color:red;">*</span></label>
                                                    <select class="form-control @error('state') is-invalid @enderror" name="state" id="state" onchange="getCity()" >
                                                       <option value="">Select State</option> 
                                                        @foreach($stateList as $sli)
                                                            @if($userInfo->country == $sli->country_id)
                                                                <option value="{{$sli->id}}" @if($sli->id == $userInfo->state) selected @endif>{{$sli->name}}</option>
                                                            @endif
                                                        @endforeach 
                                                    </select>
                                                    @error('state')
                                                       <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror  
                                                </div>
                                            </div>--}}
                                             <div class="row">
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Company Name</label>
                                                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" id="company_name" value="{{$userInfo->company_name}}">
                                                        @error('company_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Intrested In<span style="color:red;">*</span></label>
                                                         <select class="form-control js-example-placeholder-multiple col-sm-12 @error('city') is-invalid @enderror" name="city[]" id="city" multiple="multiple">
                                                            <option value="">Select</option>
                                                            @foreach($stateList as $cli)
                                                            <optgroup label="{{$cli->name}}">
                                                            @foreach($cli->getCities as $list)
                                                            <option value="{{$list->id}}"  {{ (collect($cityIntrested)->contains($list->id)) ? 'selected':'' }}>{{$list->name}}</option>
                                                            @endforeach
                                                           
                                                            </optgroup>
                                                              
                                                            @endforeach
                                                        </select>

                                                       
                                                        @error('city')
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
                                
                                <div class="card card-block">
                                   
                                   
                                     <h5 class="mt-3">Reset Password</h5>
                                    <hr>
                                       
                                       {{--<!--  <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Password</label>
                                                    <input type="password" class="form-control @error('user_password') is-invalid @enderror" name="user_password" id="user_password">
                                                   
                                                    @error('user_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror 
                                                     <small>The password must have a minimum of 7 characters, 1 digit upper case, 1 lower case and a special character(!$#%@%&_) </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Confirm Password</label>
                                                    <input type="password" class="form-control" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" id="confirm_password">
                                                    @error('confirm_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>  -->--}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" id="changePassword" class="btn btn-primary m-b-0" data-id="{{$userInfo->id}}">Generate Password</button>

                                                <a href="{{route('admin-user-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
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
