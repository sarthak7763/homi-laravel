@extends('admin::layouts.master')
@section('title', 'Add User')

@section('content')

 @php 
  $name_error="";
  $email_error="";
  $image_error="";
  $password_error="";
  @endphp

  @if (session()->has('valid_error'))
     @php $validationmessage=session()->get('valid_error'); @endphp
      @if($validationmessage!="" && isset($validationmessage['name']))
      @php $name_error=$validationmessage['name']; @endphp
      @else
      @php $name_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['email']))
      @php $email_error=$validationmessage['email']; @endphp
      @else
      @php $email_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['profile_pic']))
      @php $image_error=$validationmessage['profile_pic']; @endphp
      @else
      @php $image_error=""; @endphp
      @endif
  @endif
 
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Add User</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-list')}}">Users List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-user-add')}}">Add User</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
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
            </div>

            <div class="card-block">
                <form  method="POST" action="{{route('admin-user-save')}}" name="saveBuyerForm"  enctype="multipart/form-data" id="SaveBuyerForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Profile Pic</label>
                                <input type="file" class="form-control"  name="profile_pic" id="profile_pic" onchange="preview_image()">
                                @if($image_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                <strong>{{ $image_error }}</strong>
                                </span>

                                <div id="image_preview"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Full Name<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="{{old('name')}}" name="name" id="name"  placeholder="Enter Full Name">
                                @if($name_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif

                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $name_error }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Email<span style="color:red;">*</span></label>
                                <input type="email" class="form-control" value="{{old('email')}}" name="email" id="email" placeholder="Enter Email">
                                @if($email_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $email_error }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Password</label>
                                <input type="password" class="form-control @error('user_password') is-invalid @enderror" value="{{old('user_password')}}" name="user_password" id="user_password"  placeholder="Enter Password">
                                <small>The password must have a minimum of 7 characters, 1 digit, and 2 special character(!$#%@%&_) </small>
                                @if($password_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $password_error }}</strong>
                                </span>
                            </div>
                        </div>


                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="submitBuyers" class="btn btn-primary m-b-0">Save</button>

                            <a href="{{route('admin-user-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                        </div>
                    </div>
                </form>
            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<script>
$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


   $("#SaveBuyerForm").validate({  
        rules: {
            name:{
                required:true
            }, 
            email: {
                required: true,
                email: true,
                remote: 
                {
                    url: "{{route('admin-ajax-check-email-exist')}}",
                    type: "post",
                    data: {
                        'email': function () { return $('#email').val(); }
                    }                   
                }      
            },
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            email: {
                required: "Please enter email address",
                email: "email address must be in the format of name@domain.com",
                remote:"Email already exist"
            },
        },
        submitHandler: function(form) 
            {
                 
                $("#loading").show();
                $("#submitBuyers").hide();
                 form.submit();
            },
             invalidHandler: function(){
                  $("#submitBuyers").show();
                  $("#loading").hide();
        }
	});

   $("#submitBuyers").on('click',function(){
        $("#SaveBuyerForm").submit();
        return false;
    });

function preview_image() 
{
    
$('#image_preview').html("");
var total_file=document.getElementById("profile_pic").files.length;
for(var i=0;i<total_file;i++)
{

  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' height='150px' width='150px' class='img-fluid  mr-2'>");
 }

}

</script>
@endsection
