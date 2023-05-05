@extends('buyer::auth.auth_layout.authmaster')
@section('title',"Homi-Reset Password")
@section('content')
 <div class="row">
    <div class="col-md-5 leftCol bg-white px-4">
        <div class="logo snIN d-flex justify-content-center align-items-center">
            <img src="{{asset('assets_front/images/brand-logo/logo.png')}}"/>
        </div>
        <h2 class="headsign d-inline-block">{{ __('Reset Password') }}</h2>
     
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
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
        <form class="signForm mx-2" action="{{ route('buyer-forget-password-post') }}" method="POST" name="resetPasswordForm">
    
            @csrf

            <div class="form-group row">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                <span class="input-label">Email Address</span>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            

            <div class="form-group row mb-0">
                <div class="col-md-12">
                   <button type="submit" class="btn btn-primary login resetPasswordBtn mx-auto">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>
             <div class="col-md-12 text-center mt-5 noAccount">
            Go Back to <a href="{{route('buyer-login')}}" class="text-primary">Login</a>
          </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
 $(document).on("click", ".resetPasswordBtn", function () {
    $('form[name=resetPasswordForm]').validate({          
        rules: {
          
            email:{email:true,  required: true}
           },      
        messages: {
            email:{
                email:"Please enter a valid email address",
                required:"Please enter email address"
            }
        },
        submitHandler: function(form) {
      
            form.submit();
    
        }
    });
});

    $(document).ready(function(){
        $(".form-control").change( function () {
          if($(this).val() != ""){
            $(this).addClass("active");
          }
          else{
            $(this).removeClass("active");
          }
        })
    });
</script>
@endsection