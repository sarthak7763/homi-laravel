@extends('buyer::auth.auth_layout.authmaster')
@section('title',"Homi Forgot Password")
@section('content')
<div class="row">

<section class="signup-section pt-4 pb-4">
   <div class="container h-100">
    <div class="row align-items-center justify-content-center h-100">  
      <div class="col-12">  
        <form class="signup-form p-5">
          <h1>Welcome!</h1>
          <strong>Signup your account</strong>
          <div class="mb-4">            
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email ID">            
          </div> 
          <button type="submit" class="btn btn-primary">Send Link</button>
      
        </form>
      </div>
    </div>
  </div>
</section>

</div>
@endsection
@section('js')

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

$(document).on("click", "#btnSignup", function() {

    $('form[name=signupBuyerForm]').validate({
        rules: {
            name: {
                required: true,
                maxlength: 30
            },

            email: {
                required: true,
                email: true,
                remote: {
                    url: "{{route('buyer-sign-up-email-check')}}",

                    type: "POST",

                    data: {

                        email: function() {
                            return $('#buyerSignupForm :input[name="email"]').val();
                        },

                    }
                }
            },
            mobile_no: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 13,
                remote: {
                    url: "{{route('buyer-sign-up-mobile-check')}}",
                    type: "post",
                    data: {

                        mobile_no: function() {
                            return $('#buyerSignupForm :input[name="mobile_no"]').val();

                        }

                    }
                }
            },
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                minlength: 5,
                equalTo: "#password"
            },
            'city[]': {
                required: true,
            },

        },
        messages: {
            // first_name: {
            //     required: "Please specify your first name",
            //     maxlength:"Name length should be maximum 30 characters long"
            // },
            name: {
                required: "Please specify your name",
                maxlength: "Name length should be maximum 30 characters long"
            },
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com",
                remote: "Email already exist"
            },
            mobile_no: {
                required: "We need your mobile number to contact you",
                digits: "Your mobile number must be in digits",
                minlength: "Your mobile number have minimum 6 digits",
                maxlength: "Your mobile number have maximum 13 digits",
                remote: "Mobile number already exist"
            },
            password: {
                required: "Password field is required",
                minlength: "Password must be atleast 5 characters long"

            },
            password_confirmation: {
                required: "Confirm password field is required",
                equalTo: "Confirm password must be same as password",

            },
            'city[]': {
                required: "Select at least one city",

            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>
@endsection