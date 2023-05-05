@extends('admin::auth.auth_layout.authmaster')
@section('title',"Offercity Admin Login")
@section('content')
          <!-- Authentication card start -->
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
                   
                    <form name="ForgotPasswordForm" class="md-float-material form-material" action="{{ route('admin-forget-password-post') }}" method="POST" name="resetPasswordForm">
                        @csrf
                        <div class="text-center">
                           <img src="{{asset('assets_front/images/brand-logo/logo.png')}}" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left">Recover your password</h3>
                                    </div>
                                </div>

                                
                                <div class="form-group form-primary">
                                   <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="form-bar"></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Send Reset Password Link</button>
                                       
                                    </div>
                                </div>
                                <p class="f-w-600 text-right"><a href="{{route('admin-login')}}">Back to Login.</a></p>
                               
                            </div>
                        </div>
                    </form>
                 
         
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function (e) { 
    $(document).on("click", "#btnSubmit", function () {
        $('form[name=ForgotPasswordForm]').validate({          
            rules: {
             
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