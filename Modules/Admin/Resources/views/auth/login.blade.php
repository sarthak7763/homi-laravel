@extends('admin::auth.auth_layout.authmaster')
@section('title',"Homi Admin Login")
@section('content')
<form class="md-float-material form-material" action="{{ route('admin.login') }}" method="POST" name="loginForm">
 @csrf
    <div class="text-center">
    <img src="{{asset('assets_front/images/logo.png')}}" alt="logo.png">
    </div>
    <div class="auth-box card">
        <div class="card-block">
            <div class="row m-b-20">
                <div class="col-md-12">
                    <h3 class="text-center"> Admin Login</h3>
                </div>
            </div>
            @if(isset($errors) && count($errors) > 0)
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
            <div class="form-group form-primary">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Your Email Address">      
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group form-primary">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Password">@error('password')
                    <span class="invalid-feedback" role="alert">
                       {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="row m-t-25 text-left">
                <div class="col-12">
                   <!--  <div class="checkbox-fade fade-in-primary d-">
                        <label>
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="cr">
                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                            </span>
                            <span class="text-inverse">Remember me</span>
                        </label>
                    </div> -->
                    <div class="forgot-phone text-right f-right">
                      @if (Route::has('admin-forget-password'))
                            <a class="text-right f-w-600" href="{{ route('admin-forget-password') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif  
                    </div> 
                </div>
            </div> 
            <div class="row m-t-30">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20" id="btnLogin">
                    Sign in
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>            
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function (e) { 
    $(document).on("click", "#btnLogin", function () {
        $('form[name=loginForm]').validate({          
            rules: {
                password: {              
                    required: true
                },
                email:{email:true,  required: true}
               },      
            messages: {
                
            
            },
            submitHandler: function(form) {
          
                form.submit();
        
            }
        });
    });    
});
</script>
@endsection