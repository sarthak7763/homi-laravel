@extends('buyer::auth.auth_layout.authmaster')
@section('title',"Homi Sign up")
@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
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

.phone_number_sec .country .country-name,
.phone_number_sec .country .country-dial-code {
    overflow: hidden;
    padding-left: 15px;
}

label#password-error {
    position: absolute;
    bottom: -25px;
}

label#confirm_password-error {
    position: absolute;
    bottom: -25px;
}

span.messages strong{
    color: red;
}
form#signupBuyerForm label.error {
    font-size: 14px;
}
form#signupBuyerForm button {
    line-height: 26px;
}
</style>
@endsection
@section('content')

@php 
  $otp_error="";
@endphp

@if (session()->has('valid_error'))
    @php $validationmessage=session()->get('valid_error'); @endphp

    @if($validationmessage!="" && isset($validationmessage['otp']))
      @php $otp_error=$validationmessage['otp']; @endphp
      @else
      @php $otp_error=""; @endphp
      @endif

@endif

<div class="row">

    

    <section class="signup-section pt-4 pb-4">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-12">
                    @if(session()->get('type')=="login")
                        <form  name="signupBuyerForm" id="signupBuyerForm" action="{{ route('buyer.post.verifyloginotp')}}" method="POST" class="signup-form p-5">
                    @else
                        <form  name="signupBuyerForm" id="signupBuyerForm" action="{{ route('buyer.post.verifyregisterotp')}}" method="POST" class="signup-form p-5">
                    @endif

                        @csrf
                        <h1>Welcome!</h1>
                        <strong>Verify your account</strong>
                        @if($message = Session::get('success'))
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

                       
                        
                       
                        <div class="mb-4">
                            <input type="text" name="otp" class="form-control"  id="otp" aria-describedby="emailHelp" placeholder="Enter OTP">
                            @if($otp_error!="")
                              <span class="messages">
                                  <strong>{{ $otp_error }}</strong>
                              </span>
                          @endif
                               
                        </div>   

                        <button type="submit"  id="btnSignup" class="btn btn-primary">Verify</button>
                        <button type = "button" class="btn btn-warning mt-3" id="verifyresendotp">Resend OTP</a>
                         </form>

                </div>
            </div>
        </div>
    </section>

</div>
@endsection
@section('js')
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
    
    $('#signupBuyerForm').validate({
        rules: {
            otp: {
                required: true,
                minlength: 4,
                digits: true,
            },
        },
        messages: {
            otp: {
                required: "OTP field is required",
                minlength: "OTP must be atleast 4 characters long",
                digits: "OTP should contains only digits.",
            },
        },
        submitHandler: function(form) 
            {
                 
                $("#loading").show();
                $("#btnSignup").hide();
                 form.submit();
            },
             invalidHandler: function(){
                  $("#btnSignup").show();
                  $("#loading").hide();
        }
    });

    $("#btnSignup").on('click',function(){
        $("#signupBuyerForm").submit();
        return false;
    });

</script>


<script type="text/javascript" src="{{ asset('assets_front/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/script.js')}}"></script>


<script>
        $("#verifyresendotp").on("click", function() {
                $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url : "{{ route('buyer.resendotp') }}",
                        
                        type : 'GET',
                        dataType : 'json',
                        success : function(result){
                            if (result.status=='success') {
                            $('div.alert-success').html(result.message);
                            } else {
                            $('div.alert-danger').html(result.message);
                            }                          
                        },
                });
        });
</script>


@endsection











