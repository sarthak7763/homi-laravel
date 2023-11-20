@extends('admin::layouts.master')
@section('title', 'Add Property Owner')

@section('content')

 @php 
  $name_error="";
  $email_error="";
  $image_error="";
  $password_error="";
  $mobile_error="";
  $agency_name_error="";
  $owner_type_error="";
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

      @if($validationmessage!="" && isset($validationmessage['owner_type']))
      @php $owner_type_error=$validationmessage['owner_type']; @endphp
      @else
      @php $owner_type_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['agency_name']))
      @php $agency_name_error=$validationmessage['agency_name']; @endphp
      @else
      @php $agency_name_error=""; @endphp
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
                                    <h4>Add Property Owner </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-propertyOwner-list')}}">Property Owner List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-propertyOwner-add')}}">Add Property Owner</a> </li>
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
                <form  method="POST" action="{{route('admin-propertyOwner-save')}}" name="saveBuyerForm"  enctype="multipart/form-data" id="SaveBuyerForm">
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
                                <label class="font-weight-bold">Mobile</label>
                                <input type="text" class="form-control" value="{{old('mobile')}}" name="mobile" id="mobile"  placeholder="Enter Mobile" >
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Owner Type</label>
                                <select name="owner_type" id="owner_type" class="form-control">
                                  <option value="">Choose Owner Type</option>
                                  <option value="1">Agency</option>
                                  <option value="2">Individuals</option>
                                </select>
                                @if($owner_type_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $owner_type_error }}</strong>
                                </span>
                            </div>
                        </div>
                        @if($agency_name_error!="")
                          @php $divstyle="display:block;"; @endphp
                        @else
                          @php $divstyle="display:none;"; @endphp
                        @endif
                        <div class="col-md-6" id="agencynamediv" style="{{$divstyle}}">
                            <div class="form-group">
                                <label class="font-weight-bold">Agency Name</label>
                                <input type="text" class="form-control" name="agency_name" id="agency_name"  placeholder="Enter Agency Name" >
                                <span class="invalid-feedback" style="{{$divstyle}}" role="alert">
                                    <strong>{{ $agency_name_error }}</strong>
                                </span>
                            </div>
                        </div>

                    </div> 

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="submitBuyers" class="btn btn-primary m-b-0">Save</button>

                            <a href="{{route('admin-propertyOwner-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
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

<script type="text/javascript">
  $(document).on('change','#owner_type',function(){
    var owner_type=$(this).val();
    if(owner_type==1)
    {
      $('#agencynamediv').show();
    }
    else{
      $('#agencynamediv').hide();
    }
  });
</script>

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
                email: true   
            },
            mobile:{
                required: true
            },
            owner_type:{
              required: true
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
            mobile: {
                required: "please enter mobile number",
                
            },
            owner_type: {
                required: "please select owner type",
                
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
