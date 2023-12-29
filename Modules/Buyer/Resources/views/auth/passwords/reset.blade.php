@extends('buyer::auth.auth_layout.authmaster')
@section('title',"Homi Reset Password")
@section('content')
<div class="row">
   <section class="signup-section pt-4 pb-4">
       <div class="container h-100"> 
         <div class="row align-items-center justify-content-center h-100">
            <div class="col-md-12">
               
               <form class="signup-form p-5" action="{{route('buyer-update-password')}}" method="Post">                  
                  @csrf       
                  <input type="hidden" name="token" value="{{ $token }}">
                  <div class="logo-password snIN d-flex justify-content-center align-items-center">
                  <img src="{{asset('assets_front/images/brand-logo/logo.png')}}"/>
               </div>
               
                   <h1>{{ __('Reset Password') }}</h1>            
                  <div class="form-group mb-2">
                     <label for="email_address" class="col-form-label text-md-right">E-Mail Address</label>                    
                        <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif                   
                  </div>
                  <div class="form-group mb-2">
                     <label for="password" class="col-form-label text-md-right">Password</label>                     
                        <input type="password" id="password" class="form-control" name="password" required autofocus>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif                    
                  </div>
                  <div class="form-group mb-3">
                     <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>                   
                        <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                        @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif                    
                  </div>
                  <div class="col-md-12">
                     <button type="submit" class="btn btn-primary">
                        Reset Password
                     </button>
                  </div>
               </form>
            </div>
         </div>
       </div>
   </section>
</div>
@endsection