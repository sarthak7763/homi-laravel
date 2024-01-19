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
                  
               
                   <h1>{{ __('Reset Password') }}</h1>            
                  <div class="form-group mb-2">
                     <label for="email_address" class="col-form-label text-md-right">E-Mail Address</label>                    
                        <input type="text" id="email_address" class="form-control" name="email"  autofocus>
                        @error('email')
                        <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror                
                  </div>
                  <div class="form-group mb-2">
                     <label for="password" class="col-form-label text-md-right">Password</label>                     
                        <input type="password" id="password" class="form-control" name="password"  autofocus>
                        @error('password')
                        <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror                   
                  </div>
                  <div class="form-group mb-3">
                     <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>                   
                        <input type="password" id="password-confirm" class="form-control" name="password_confirmation"  autofocus>
                        @error('password_confirmation')
                        <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror                  
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