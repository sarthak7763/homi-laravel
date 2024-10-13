@extends('buyer::layouts.master')
@section('title', 'Homi City-My Profile')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">


<style type="text/css">
  .error_input{border: 1px solid red !important;}
  .formGroup form .form-group input {background: var(--white);}
  .color {color: #c9c9c9 !important;}
</style>
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
@endsection
@section('content')
@include('buyer::includes.profile_header')
<!-- tabs -->        
<div class="container">
  <div class="row mt-5">
    <div class="col-md-12 tabsPenal">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link"  href="{{route('buyer-bids')}}" role="tab">My Bids</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-fav-property')}}" role="tab">Favorite Property</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{route('buyer-profile')}}" role="tab">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-change-password')}}" role="tab">Settings</a>
          </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
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
         {{--<div class="tab-pane" role="tabpanel">--}}
        
          <div class="row">
            <div class="formGroup col-md-12 mt-5">
              <form name="buyerProfileForm" id="buyerProfileForm" action="{{route('buyer-save-profile')}}" method="POST" enctype="multipart/form-data">
                 @csrf
              <div class="userBadge text-center">
                  <label for="profile_pic" class="position-relative"><img class="usrBag" id="previewHolder" src="{{$buyerInfo->profile_pic}}" width="120px"/> <i class="fas fa-camera setIcin"></i></label>
                  <input type="file" accept="image/*"  name="profile_pic" id="profile_pic" class="required borrowerImageFile  @error('profile_pic') is-invalid @enderror" style="display: none;" data-errormsg="PhotoUploadErrorMsg">
                   @error('profile_pic')
                            <p class="messages">
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
              </div>
              <div class="text-center mt-5 pt-3">
              
             
                  <div class="form-group fname">
                    <label>First Name</label>
                    <input type="text" class="form-control  @error('first_name') is-invalid @enderror" 
                        placeholder="First Name" 
                        name="first_name" 
                        value="{{@$buyerInfo->first_name}}" 
                        autofocus 
                        id="focusField">
                        @error('first_name')
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                  </div>
                  <!-- <div class="form-group lname">
                    <label>Last Name</label>
                    <input type="text" class="form-control  @error('last_name') is-invalid @enderror" placeholder="Last Name" name="last_name" value="{{@$buyerInfo->last_name}}">
                    @error('last_name')
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                  </div> -->
                  <div class="form-group clrFix mt-4">
                    <label>Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address"
                    name="email" value="{{@$buyerInfo->email}}" disabled="disabled" readonly="readonly">
                    @error('email')
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                  </div>

                 

                    <!-- <div class="phone_number_sec">
                      <div class="form-group clrFix mt-4 ">
                          <label>Phone Number</label>
                        
                              <input type="tel" class="form-control us_telephone  @error('mobile_no') is-invalid @enderror" id="phone_number"  data-mask="999-999-9999" name="mobile_no" placeholder="Phone Number" value="{{@$buyerInfo->mobile_no}}">
                              @error('mobile_no')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              <input type="hidden" class="contact_code" id="contact_code" name="contact_code" value="{{ @$buyerInfo->country_std_code }}">
                              <input type="hidden" class="country_name" name="country_name" value="{{ @$buyerInfo->country_name }}">
                              <input type="hidden" class="country_code" name="country_code" value="{{ @$buyerInfo->country_code }}">
                             
                          
                      </div>
                  </div> -->
                  <!-- <div class="form-group clrFix mt-4">
                    <label>Company Name</label>
                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" placeholder="Company Name"
                    name="company_name" value="{{@$buyerInfo->company_name}}">
                    @error('company_name')
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                  </div> -->
               
                                                       
                  {{--<div class="form-group clrFix mt-4">
                    <label>Address</label>
                    <input type="text" class="form-control" placeholder="Address" name="address" value="{{@$buyerInfo->address}}">
                  </div>--}}
                  <div class="form-group clrFix mt-4">
                     <label>Intrested City</label>
                    <select class="form-control @error('city') is-invalid @enderror js-example-placeholder-multiple" name="city[]" id="city" multiple="multiple">
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
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                 
          
                  </div> 
                  {{--<div class="form-group clrFix mt-4">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password">
                  </div>--}}
                  <div id="btnProfileGroup" class="button-group justify-content-between">
                    <span id="editBtn" class="btn btn-primary transact link">Edit</span>
                    <button id="cancelBtn" type="button" class="btn btn-inverse" style="display: none">Cancel</button>
                    <button type="submit" value="submit" id="updateProfileBtn" class="btn btn-primary blue"  style="display: none">Update</button>
                  </div>
              </div>
              </form>
            </div>
          </div>
        
         {{--</div>--}}

      </div>
    </div>
  </div>            
</div>
@endsection
@section('js')
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

<script type="text/javascript">

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
    initialCountry: "{{ @$buyerInfo->country_code }}",
    onlyCountries:['US','CA','IN'],
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

  });

 $("#profile_pic").bind("change", function () {
        //Get reference of FileUpload.
        var fileUpload = $("#profile_pic")[0];
 
        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
                //Initiate the FileReader object.
                var reader = new FileReader();
                //Read the contents of Image File.
                reader.readAsDataURL(fileUpload.files[0]);
               
                reader.onload = function (e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    $('#previewHolder').attr('src', e.target.result);
                    image.onload = function () {
                        //Determine the Height and Width.
                        var height = this.height;
                        var width = this.width;
                        if (height > 1000 || width > 1000) {
                            alert("Height and Width must not exceed 1000px.");
                            return false;
                        }

                        //alert("Uploaded image has valid Height and Width.");
                        return true;
                    };
                }
            } else {
                alert("This browser does not support HTML5.");
                return false;
            }
        } else {
            alert("Please select a valid Image file.");
            return false;
        }
    });


    $(document).ready(function() {
        $("form#buyerProfileForm input,select").attr('disabled', 'disabled');
        $("form#buyerProfileForm input,select").addClass("color");
        $('#editBtn').click(function() {

            $("form#buyerProfileForm input,select").removeAttr('disabled', 'disabled');
            $("form#buyerProfileForm input,select").removeAttr('disabled', 'disabled');
            $('#editBtn').hide();
            $('#editBtn').parent('#btnProfileGroup').addClass('d-flex');
            $('#cancelBtn').show();
            $('#updateProfileBtn').show();


            $("form#buyerProfileForm input,select").removeClass("color");
            setFocus('focusField');      
        })
    });

    $('#cancelBtn').click(function() {

        $("form#buyerProfileForm input,select").attr('disabled', 'disabled');
        $("form#buyerProfileForm input,select").attr('disabled', 'disabled');
        $('#editBtn').parent('#btnProfileGroup').removeClass('d-flex');
        $('#editBtn').show();
        $('#cancelBtn').hide();
        $('#updateProfileBtn').hide();


        $("form#buyerProfileForm input,select").addClass("color");
          window.location.reload();
        
    })


  function setFocus (id){
    var input = document.getElementById(id);
    var size = input.value.length;
    input.setSelectionRange(size, size);
    input.focus();
  }

 $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
   });

$.validator.addMethod("phoneNumValidation", function(value) {
    return $("#phone_number").intlTelInput("isValidNumber")
}, 'Please enter a valid number');


$('#mobile_no').focusout(function () {
    var mobile_num=$(this).val();
    var phoneRegex =/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
    if (phoneRegex.test(mobile_num)) {
     
    } else {
         $(this).val("");
    }
});



  $(document).on("click", "#updateProfileBtn", function () 
    {
        $('form[name=buyerProfileForm]').validate({            
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
                        url: "{{route('buyer-ajax-check-email-exist')}}",
                        type: "POST",
                            data: {
                               email: function() { 
                            return $('#buyerProfileForm :input[name="email"]').val();
                            },
                            }                 
                    }      
                },
                mobile_no: {
                    required: true,
                    // maxlength:12,
                    // minlength: 12,
                    // remote: 
                    // {
                    //   url: "{{route('buyer-ajax-check-phone-exist')}}",
                    //   type: "post",
                    //   data: {
                    //     mobile_no: function() { 
                    //     return ($('#buyerProfileForm :input[name="mobile_no"]').val().replace(/\D/g, '').slice(-10));
                          
                    //     }
                    //   }                   
                    // }      
                },
                // user_password: {
                //   required: true,
                //   minlength: 5
                // },
                // confirm_password : {
                //     minlength : 5,
                //     equalTo : "#user_password"
                // },
                'city[]' : {
                    required: true,
                },
                profile_pic:{
                    required: true,
                }  
            },
            messages: {
                first_name: {
                    required: "Please specify your first name",
                    maxlength:"Name length should be maximum 30 characters long"
                },
                last_name: {
                    required: "Please specify your last name",
                    maxlength:"Name length should be maximum 30 characters long"
                },
                email: {
                  required: "We need your email address to contact you",
                  email: "Your email address must be in the format of name@domain.com",
                  remote:"Email already exist"
                },
                 mobile_no: {
                  required: "We need your mobile number to contact you",
                 // digits: "Your mobile number must be in digits",
              //    remote:"Mobile number already exist",
                },
                // user_password: {
                //   required: "Password field is required",
                //   minlength:"Password must be atleast 5 characters long"
                  
                // },
                // confirm_password: {
                //   required: "Confirm password field is required",
                //   equalTo: "Confirm password must be same as password",
                 
                // },
                'city[]': {
                  required: "Select at least one city",
                 
                },
                profile_pic: {
                  required: "Select Profile Pic",
                  extension: "Please upload file in these format only (jpg, jpeg, png).",
                  accept: "Please upload file in these format only jpg,jpeg,png"
   
                 
                },
            },
            submitHandler: function(form) 
            {
                form.submit();
            }
        });
    });

</script>
@endsection
