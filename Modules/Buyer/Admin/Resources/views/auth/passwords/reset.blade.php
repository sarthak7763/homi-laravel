@extends('admin::auth.auth_layout.authmaster')
@section('title',"Offercity : Admin Forgot Password Reset")
@section('content')
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
            <div class="text-center">
                            <img src="{{asset('assets_front/images/logo.png')}}" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center"> Reset your password</h3>
                                    </div>
                                </div>
       
             <form class="signForm mx-2" action="{{route('admin-reset-forgot-password') }}" id="resetPasswordForm"  method="POST" name="resetPasswordForm">
                @csrf
                  <input type="hidden" name="token" value="{{$token}}">
                  <input  type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus placeholder="Email">
                  <div class="form-group form-primary">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                   
                  </div>

                   <div class="form-group form-primary">
                      <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                   
                  </div>

                <div class="row">
                                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" id="resetPasswordBtn">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                      
                </div>
                 <p class="f-w-600 text-right"><a href="{{route('admin-login')}}">Back to Login.</a></p>
            </form>

@endsection
@section('js')
<script type="text/javascript">
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