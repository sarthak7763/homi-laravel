@extends('admin::layouts.master')
@section('title', 'Add Buyer')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">

<style type="text/css">
  label.error{
    color: red;
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
                                    <h4>Add Buyer</h4>
                                    <span>Add buyers to buy property and apply bids on property</span>
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
                                     <li class="breadcrumb-item"><a href="{{route('admin-user-add')}}">Add Buyer</a> </li>
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
                                <div class="card-header">
                                   <!--  <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                          <!--   <li><i class="feather icon-trash-2 close-card"></i></li> -->
                                        </ul>
                                    </div>
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
                                </div>
                                <div class="card-block">
                                    <form  method="POST" action="{{route('admin-user-save')}}" name="saveBuyerForm"  enctype="multipart/form-data" id="SaveBuyerForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Profile Pic</label>
                                                    <input type="file" class="form-control @error('profile_pic') is-invalid @enderror"  name="profile_pic" id="profile_pic" onchange="preview_image()">
                                                    @error('profile_pic')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div id="image_preview"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Full Name<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control only_alpha @error('name') is-invalid @enderror" value="{{old('name')}}" name="name" id="name"  placeholder="Enter Full Name">
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
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" name="email" id="email" placeholder="Enter Email">
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
                                                <input type="text" class="form-control only_number @error('mobile_no') is-invalid @enderror" id="phone_number" autocomplete="off" name="mobile_no" placeholder="  Phone Number" value="{{ old('mobile_no')}}">
                                                @error('mobile_no')
	                                               <span class="invalid-feedback" role="alert">
	                                                  <strong>{{ $message }}</strong>
	                                               </span>
                                                @endif
                                               
                                              
                                               <input type="hidden" class="contact_code"  name="contact_code" value="+1">
                                                <input type="hidden" class="country_name"  name="country_name" value="United States: +1">
                                                <input type="hidden" class="country_code" name="country_code" value="us">
                                               
                                            </div>
                                        </div>
                                        </div>
                                     
                                        {{--<div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Address<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" name="address" id="address"  placeholder="Enter Address">
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
                                                    <input class="form-control @error('home_address') is-invalid @enderror" value="{{old('home_address')}}" name="home_address" id="home_address"  placeholder="Enter Other Address" type="text">
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
                                                    <select name="country" id="country" class="form-control @error('country') is-invalid @enderror" readonly>
                                                   
                                                    @foreach($countryList as $cli)
                                                    <option value="{{$cli->id}}">{{$cli->name}}</option>
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
                                                        <option value="{{$sli->id}}">{{$sli->name}}</option>
                                                          
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
                                                    <input class="form-control @error('company_name') is-invalid @enderror" value="{{old('company_name')}}" name="company_name" id="company_name"  placeholder="Enter Company Name" type="text">
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
                                                        <option value="{{$list->id}}"  {{ (collect(old('city'))->contains($list->id)) ? 'selected':'' }}>{{$list->name}}</option>
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
                                        {{--<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Password</label>
                                                    <input type="password" class="form-control @error('user_password') is-invalid @enderror" value="{{old('user_password')}}" name="user_password" id="user_password"  placeholder="Enter Password">
                                                    <small>The password must have a minimum of 7 characters, 1 digit, and 2 special character(!$#%@%&_) </small>
                                                    @error('user_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Confirm Password</label>
                                                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" value="{{old('confirm_password')}}" id="confirm_password"  placeholder="Enter Confirm Password">
                                                    @error('confirm_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>  --}}  
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" name="submit" value="submit" id="submitBuyer" class="btn btn-primary m-b-0">Save</button>

                                                 <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                <a href="{{route('admin-user-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
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
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>



<script>
$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function test(){
    var number =  $('input[name="mobile_no"]').val();
    var classf = $(".selected-flag > div").attr("class");
    var flag = classf.slice(-2);

    console.log("check number: ", number);
    console.log("check classf: ", classf);
    console.log("check flag: ", flag);
    
    var formattedNumber = intlTelInputUtils.formatNumber(number, flag, intlTelInputUtils.numberFormat.INTERNATIONAL);
    $('input[name="mobile_no"]').val(formattedNumber);

}

$.validator.addMethod("phoneNumValidation", function(value) {
    return $("#phone_number").intlTelInput("isValidNumber")
}, 'Please enter a valid number');


   $("#SaveBuyerForm").validate({  
        rules: {
            mobile_no: {
                required: true,
                maxlength:12,
                minlength: 4,
                digits: true,
                phoneNumValidation: true,
                remote: 
                {
                    url: "{{route('admin-ajax-check-phone-exist')}}",
                    type: "post",
                    data: {
                        'mobile_no': function () { return $('#phone_number').val(); ; }
                    }                   
                }      
            },
            name:{
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
            'city[]' : {
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

   $("#submitBuyer").click(function(){
        $("#SaveBuyerForm").submit();
        return false;
    });

//
var telInput = $("#phone_number");
telInput.on("countrychange", function () {
    var country_code_t = $("#phone_number").intlTelInput("getSelectedCountryData").iso2;
    jQuery(".country_code").val(country_code_t);

    var code = jQuery('.selected-dial-code').text();
    var country_name = jQuery('.selected-flag').attr('title');
    jQuery(".contact_code").val(code);
    jQuery(".country_name").val(country_name);
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
    onlyCountries:['US','CA','IN'],
    geoIpLookup: function (callback) {
        jQuery.get("http://ipinfo.io", function () {}, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
});

jQuery(document).ready(function () {
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

 });


// function getState(){
//     $('#state').html('');
//     $('#city').html('');
//     var countryID =$("#country").val();         
//     $.ajax({
//         type: "POST",
//         data:{_token: "{{ csrf_token() }}",country_id:countryID}, 
//         url: "{{ route('admin-ajax-get-state-list') }}",
//          beforeSend: function(){
//                   //  $("#loading").show();
//                 },
//                 complete: function(){
//                  //   $("#loading").hide();
//                 },
//         success:function(result){
//             if(result) {
//                 $('#state').html(result);
//             }
//             else {
//                 alert('error');
//             }
//         }
//     });
// }

// function getCity(){
//     var stateID =$("#state").val();         
//     $.ajax({
//         type: "POST",
//         data: {_token: "{{ csrf_token() }}",state_id:stateID}, 
//         url: "{{ route('admin-ajax-get-city-list') }}",
//          beforeSend: function(){
//                   //  $("#loading").show();
//                 },
//                 complete: function(){
//                  //   $("#loading").hide();
//                 },
//         success:function(result){
//             if(result) {
//                // $('#city').html(result);
//             }
//             else {
//                 alert('error');
//             }
//         }
//     });
// }


function preview_image() 
{
$('#image_preview').html("");
var total_file=document.getElementById("profile_pic").files.length;
for(var i=0;i<total_file;i++)
{

  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' height='150px' width='150px' class='img-fluid  mr-2'>");
 }

}

  $(document).ready(function(){
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select"
        });
    });



</script>
@endsection
