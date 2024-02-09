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
            <div class="form-group clrFix mt-1">
                    
                    <input type="password" name="current_password" value="{{old('current_password')}}"  class="form-control @error('old_password') is-invalid @enderror" placeholder="Enter Old Password">
                    @error('current_password')
                  <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror
                  </div>
                    <div class="form-group clrFix mt-4">
                    
                    <input type="password" name="new_password" value="{{old('new_password')}}" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter New Password">
                    @error('new_password')
                  <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror
                  </div>
                    <div class="form-group clrFix mt-4">
                  
                    <input type="password" name="confirm_password" value="{{old('confirm_password')}}"  class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Re-enter New Password">
                    @error('confirm_password')
                  <div class="invalid-feedback" style="display:block;">
                    {{$message}}
                  </div>
                  @enderror
                  </div>
                  <div  class="button-group justify-content-between">
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
@endsection