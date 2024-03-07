<style>
.input-group-text .eyeopen {
    display: none;
}
.change-pw .input-group-text {
    height: auto;
    top: 10px;
    font-size: 15px;
    color: #394953;
}
.fa-eye-slash .eyeopen {
    display: block;
}

.fa-eye-slash .eyeclose {
    display: none;
}
span.input-group-text {
    z-index: 9;
    background: transparent;
    height: auto;
}
 .togglePassword3 {
    background-color: transparent;
    border: 1px solid var(--bs-white);
    border-left: none;
    cursor: pointer;
    position: absolute;
    height: 42px;
    top: 36px;
    padding: 0;
    right: 10px;
}
.change-pw .input-group-text:before {
    content: none;
}
</style>

@extends('buyer::layouts.master')
@section('content')
<div class="col-lg-9">
   <div class="profile-box">
      <div class="profile-box-form">
         <h1 class="mb-3">Change Password</h1>
        
    <div>
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <form name="buyerChangePasswordForm"  action="{{route('buyer.change-password-save')}}" method="POST" >
         @csrf        
             
              <div class="text-center">
            <div class="form-group clrFix position-relative mt-4 change-pw">
                    
                    <input type="password" name="current_password" id="current_password" value="{{old('current_password')}}"  class="form-control @error('old_password') is-invalid @enderror" placeholder="Enter Old Password">
                    <span toggle="#current_password" class="input-group-text togglePassword3 border-0 p-0" id="">
                    <i class="fa fa-eye eyeopen"></i>                                                                                     
                    <i class="fa fa-eye-slash eyeclose "></i>
                   
                            </span>
                    
                    @error('current_password')
                  <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror
                  </div>


                  
                    <div class="form-group clrFix position-relative mt-4 change-pw">
                    
                    <input type="password" name="new_password"  id="password" value="{{old('new_password')}}" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter New Password">
                   
                    <span toggle="#password" class="input-group-text togglePassword" id="">
                    <i class="fa fa-eye eyeopen "></i>                                                                                     
                    <i class="fa fa-eye-slash eyeclose "></i>
                   
                            </span>

                   
                    @error('new_password')
                  <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror
                  </div>
                    <div class="form-group clrFix mt-4 position-relative change-pw">
                  
                    <input type="password" name="confirm_password" id="confirm_password" value="{{old('confirm_password')}}"  class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Re-enter New Password">
                    
                    <span toggle="#confirm_password" class="input-group-text  togglePassword2" >
                    <i class="fa fa-eye eyeopen"></i>                                                                                     
                    <i class="fa fa-eye-slash  eyeclose"></i>


                            </span>

                    
                    @error('confirm_password')
                  <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror
                  </div>
                  <div  class="button-group justify-content-between pt-3 mt-3 mt-md-0 pt-md-0">
                    <button type="submit"  class="btn btn-primary blue">Change Password</button>
                  </div>
              </div>
              </form>
         </div>
      </div>
   </div>
</div>
</div>
</div>
</main> 
<script>
    $("body").on('click', '.togglePassword', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#password");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  $("body").on('click', '.togglePassword2', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#confirm_password");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });



  $("body").on('click', '.togglePassword3', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#current_password");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>
@endsection