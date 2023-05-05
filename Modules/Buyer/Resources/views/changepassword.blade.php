@extends('buyer::layouts.master')
@section('title', 'Offer City-Change password')
@section('css')
<style type="text/css">
  .error_input{border: 1px solid red !important;}
  .formGroup form .form-group input {background: var(--white);}
  .color {color: #c9c9c9 !important;}
</style>
@endsection
@section('content')
@include('buyer::includes.profile_header')
<!-- tabs -->        
<div class="container">
  <div class="row mt-5">
    <div class="col-md-12 tabsPenal">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link"  href="{{route('buyer-bids')}}" role="tab">My Bids</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-fav-property')}}" role="tab">Favorite Property</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-profile')}}" role="tab">Profile</a>
          </li>
           <li class="nav-item">
            <a class="nav-link active" href="{{route('buyer-change-password')}}" role="tab">Settings</a>
          </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
         {{--<div class="tab-pane" role="tabpanel">--}}
           @if ($message = Session::get('success'))
                    <div class="row">
                        <div class="col-md-12">
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                             <label  class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"  style="font-size: 19px;margin-top: -1px;">&times;</span>
                              </label>
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                @endif
                @if($message = Session::get('error'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                             <label type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="font-size: 19px;margin-top: -1px;">&times;</span>
                              </label>
                                
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                @endif
          <div class="row">
            <div class="formGroup col-md-12 mt-5">
              <form name="buyerChangePasswordForm" id="buyerChangePasswordForm" action="{{route('buyer-update-password')}}" method="POST" enctype="multipart/form-data">
                 @csrf
             
              <div class="text-center">
             

  
             
                
                 <div class="form-group clrFix mt-1">
                    <label>Current Password</label>
                    <input type="password" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Enter Current Password">
                    @if($errors->has('old_password'))
                      <div class="error" style="color: red;text-align: left;font-weight: 300;">{{ $errors->first('old_password') }}</div>
                    @endif
                  </div>
                    <div class="form-group clrFix mt-4">
                    <label>New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter New Password">
                    @if($errors->has('new_password'))
                      <div class="error" style="color: red;text-align: left;font-weight: 300;">{{ $errors->first('new_password') }}</div>
                    @endif
                  </div>
                    <div class="form-group clrFix mt-4">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Re-enter New Password">
                      @error('confirm_password')
                            <span class="messages">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                  </div>
                  <div  class="button-group justify-content-between">
                    <button type="submit" value="submit" id="updateProfileBtn" class="btn btn-primary blue">Change Password</button>
                  </div>
              </div>
              </form>
            </div>
          </div>
        
         {{--</div>--}}

      </div>
    </div>
  </div>            
</div>
@endsection
@section('js')
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>

 $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
   });
  $(document).on("click", "#buyerChangePasswordForm", function () 
    {
        $('form[name=buyerChangePasswordForm]').validate({            
            rules: {
                old_password:{
                    required:true,
                    minlength:6,
                     remote: 
                    {
                        url: "{{route('buyer-ajax-confirm-old-password')}}",
                        type: "POST",
                        data: {
                           old_password: function() { 
                        return $('#buyerChangePasswordForm :input[name="old_password"]').val();
                        },

                               
                            }                 
                    }     
                }, 
                new_password:{
                    required:true,
                    minlength:6
                }, 
                confirm_password: {
                  required: true,
                  minlength:6,
                  equalTo : "#new_password"  
                },
               
                
            },
            messages: {
                old_password: {
                    required: "Old Password field is required",
                   minlength:"Old Password must be atleast 5 characters long",
                       remote:"Old Password not match"
                },
                new_password: {
                    required: "New Password field is required",
                  minlength:"New Password must be atleast 5 characters long"
                },
                confirm_password: {
                  required: "Confirm Password field is required",
                  minlength:"Confirm Password must be atleast 5 characters long"
              
                },
                 
            },
            submitHandler: function(form) 
            {
                form.submit();
            }
        });
    });

</script>
@endsection
