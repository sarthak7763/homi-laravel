@extends('admin::layouts.master')
@section('title', 'Edit Profile')

@section('content')

 @php 
  $name_error="";
  $email_error="";
  $image_error="";
  $password_error="";
  $mobile_error="";
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

      @if($validationmessage!="" && isset($validationmessage['mobile']))
      @php $mobile_error=$validationmessage['mobile']; @endphp
      @else
      @php $mobile_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['password']))
      @php $password_error=$validationmessage['password']; @endphp
      @else
      @php $password_error=""; @endphp
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
                                    <h4>Edit Admin Profile</h4>
                                </div>
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
                <form  method="POST" action="{{route('admin-profile-update')}}" name="updateBuyerForm"  enctype="multipart/form-data" id="updateBuyerForm">
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

                                <div id="image_preview">
                                  @if(Auth()->user()->profile_pic!="")
                                  <img src="{{url('/')}}/images/user/{{ Auth()->user()->profile_pic}}" class="img-radius" alt="User">
                                  @else
                                  <img  class="img-radius img-fluid" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png"  id="previewHolder" width="150px"/>
                                  @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Full Name<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="{{$adminInfo->name}}" name="name" id="name"  placeholder="Enter Full Name">
                                <input type="hidden" name="id"  value="{{$adminInfo->id}}">
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
                                <input type="email" class="form-control" value="{{$adminInfo->email}}" name="email" id="email" placeholder="Enter Email">
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
                           <div class="form-group country-select">
                                <label class="font-weight-bold">Mobile</label>
                                
                                <select id="country_id" name="country_id" class=" form-control">
                                  @foreach($country_list as $list)
                                  @if($adminInfo->country_id==$list)
                                  @php $selected="selected"; @endphp
                                  @else
                                  @php $selected=""; @endphp
                                  @endif
                                      <option {{$selected}} value="{{$list}}">
                                      {{$list}}</option>
                                  @endforeach
                                    </select>
                                <input type="text" class="form-control" value="{{$adminInfo->mobile}}" name="mobile" id="mobile"  placeholder="Enter Mobile">
                                @if($mobile_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $mobile_error }}</strong>
                                </span>
                            </div>
                        </div>


                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="submitBuyers" class="btn btn-primary m-b-0">Update</button>

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


   $("#updateBuyerForm").validate({  
        rules: {
            name:{
                required:true
            }, 
            email: {
                required: true,
                email: true   
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
        $("#updateBuyerForm").submit();
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
