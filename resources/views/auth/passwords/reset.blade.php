@extends('buyer::auth.auth_layout.authmaster')
@section('title',"Homi Reset Password")
@section('content')
 <div class="row">
    <div class="col-md-5 leftCol bg-white px-4">
        <div class="logo snIN d-flex justify-content-center align-items-center">
            <img src="{{asset('assets_front/images/brand-logo/logo.png')}}"/>
        </div>
        <h2 class="headsign d-inline-block">{{ __('Reset Password') }}</h2>
          @if (isset($errors) && count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </div>
            @endif 
            @if(session()->has('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
               <label  class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"  style="font-size: 19px;margin-top: -1px;">&times;</span>
                </label>
                   {{ session()->get('success') }}
              </div>
            @endif
             @if(session()->has('error'))
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <label  class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"  style="font-size: 19px;margin-top: -1px;">&times;</span>
                </label>
                   {{ session()->get('error') }}
              </div>
            @endif
        <form class="signForm mx-2" action="{{ route('buyer-reset-password') }}" id="resetPasswordForm"  method="POST" name="resetPasswordForm">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">               
            <input  type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus placeholder="Email">                

            <div class="form-group row">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <img src="/assets_front/images/icons/open_eye.svg"  onclick="myFunction()" class="eyeIcon"  id="openEye" style="height: 30px;width: 32px;" />
                <img src="/assets_front/images/icons/close_eye.svg" style="display: none;" onclick="myFunction()" class="eyeIcon" id="closeEye" />               
            </div>
            <div class="form-group row">
                <input id="password_confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                <img src="/assets_front/images/icons/open_eye.svg" onclick="myFunctionC()" class="eyeIcon" id="openEyeC" style="height: 30px;width: 32px;"/>
                <img src="/assets_front/images/icons/close_eye.svg" style="display: none;" onclick="myFunctionC()" class="eyeIcon" id="closeEyeC" />
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary login mx-auto" id="resetPasswordBtn">
                        {{ __('Reset Password') }}
                    </button>
                </div>
                <div class="col-md-12 text-center mt-5 noAccount">
                    Go Back to <a href="{{route('buyer-login')}}" class="text-primary">Login</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    $('#openEye').hide();
    $('#closeEye').show();
    
    x.type = "text";
  } else {
     $('#openEye').show();
    $('#closeEye').hide();
    x.type = "password";
  }
}

function myFunctionC() {
  var x = document.getElementById("password_confirm");
  if (x.type === "password") {
    $('#openEyeC').hide();
    $('#closeEyeC').show();
    
    x.type = "text";
  } else {
     $('#openEyeC').show();
    $('#closeEyeC').hide();
    x.type = "password";
  }
}


 $(document).on("click", "#resetPasswordBtn", function () 
    {
      
        $('form[name=resetPasswordForm]').validate({            
            rules: {
                
                password: {
                  required: true,
                  minlength: 5
                },
                password_confirmation : {
                    minlength : 5,
                    equalTo : "#password"
                }
                
            },
            messages: {
              
                password: {
                  required: "Password field is required",
                  minlength:"Password must be atleast 5 characters long"
                  
                },
                password_confirmation: {
                  required: "Confirm password field is required",
                  equalTo: "Confirm password must be same as password",
                 
                }
               
            },
            submitHandler: function(form) 
            {
                form.submit();
            }
        });
    });


</script>
@endsection