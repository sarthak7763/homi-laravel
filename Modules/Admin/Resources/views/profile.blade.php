@extends('admin::layouts.master')
@section('title', 'Real Estate Admin Profile')
@section('content')

<style type="text/css">
  label.error{
    color: red;
}


.update-table .profile-box {
    max-width: 160px;
}

.card {
    max-width: calc(100% - 160px);
    width: 100%;
    display: flex;
    box-shadow: none;
}

table td, table th {font-size: 16px;padding: 10px 20px;line-height: 26px;height: auto;border: 1px solid #ddd;/* border-top: 0; */}

.card a.edit-btn {
    text-align: end;
    background: #111c4e;
    display: inline-block;
    width: auto;
    flex: 0 0 auto;
    color: #fff;
    max-width: fit-content;
    border-radius: 5px;
    margin-bottom: 10px !important;
    float: right;
    margin-left: auto;
    padding: 3px 13px 5px;
    font-weight: bold;
}   
.card a.edit-btn:hover {color: #fff}
</style>
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
                                    <h4>
                                    @if(Auth::user()->hasRole('sub-admin'))
                                    Sub Admin
                                    @else
                                    Admin
                                    @endif
                                     Profile</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-profile')}}">@if(Auth::user()->hasRole('sub-admin'))
                                    Sub Admin
                                    @else
                                    Admin
                                    @endif Profile</a> </li>
                                  
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

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
                <div class="page-body">
                   <div class="row justify-content-center">
                      
                        <div class="col-xl-8 update-table d-flex ">
                            <div class="profile-box w-100 bg-white">
                                <label class="mb-0 p-2 w-100" id="profile_pic_label">
                                <img  class="img-radius img-fluid" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png"  id="previewHolder" width="150px"/>
                            </label>                           
                            </div>
                                    <div class="card mb-0 h-100 p-3">
                                        <a href="{{route('admin-profile-edit')}}" class="edit-btn btn">Edit</a>
                                            <table class="table-responsive">
                                                <tbody>

                                                <tr>
                                                    <th>
                                                        Name : 
                                                    </th>
                                                    <td>
                                                        {{$adminInfo->name}}
                                                    </td>
                                                </tr>
                                                    
                                                <tr>
                                                    <th>
                                                        Email : 
                                                    </th>
                                                    <td>
                                                       {{$adminInfo->email}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Mobile : 
                                                    </th>
                                                    @if($adminInfo->country_id!="")
                                                    <td>
                                                        {{$adminInfo->country_id}}{{$adminInfo->mobile}}
                                                    </td>
                                                    @else
                                                    <td>{{$adminInfo->mobile}}</td>
                                                    @endif
                                                </tr>
                                                </tbody>
                                            </table>
                                        

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

 $("#profile_pic").bind("change", function () {
        //Get reference of FileUpload.
        var fileUpload = $("#profile_pic")[0];
 
        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.JPEG|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
                //Initiate the FileReader object.
                var reader = new FileReader();
                //Read the contents of Image File.
                reader.readAsDataURL(fileUpload.files[0]);
               
                reader.onload = function (e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    $('#previewHolder').attr('src', e.target.result);
                    image.onload = function () {
                        //Determine the Height and Width.
                        var height = this.height;
                        var width = this.width;
                        if (height > 1000 || width > 1000) {
                            alert("Height and Width must not exceed 1000px.");
                            return false;
                        }

                        //alert("Uploaded image has valid Height and Width.");
                        return true;
                    };
                }
            } else {
                alert("This browser does not support HTML5.");
                return false;
            }
        } else {
            alert("Please select a valid Image file.");
            return false;
        }
    });


$('#mobile_no').focusout(function () {
    var mobile_num=$(this).val();
    var phoneRegex =/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
    if (phoneRegex.test(mobile_num)) {
     
    } else {
         $(this).val("");
    }
});


   $(document).on("click", "#submitAdminInfo", function () 
    {
        $('form[name=adminProfileUpdate]').validate({            
            rules: {
                name:{
                    required:true,
                    maxlength:30
                }, 
                email: {
                  required: true,
                  email: true,
                  remote: 
                    {
                        url: "{{route('admin-ajax-check-exist-email')}}",
                        type: "post",
                        data: {
                            'email': function () { return $('#email').val(); },
                            'id':function () { return $('#id').val(); },
                        }   
                    }      
                },
                mobile_no: {
                    required: true,
                    maxlength:12,
                    minlength:12,
                   
                    remote: 
                    {
                        url: "{{route('admin-ajax-check-exist-phone')}}",
                        type: "post",
                        data: {
                            'mobile_no': function () { return $('#mobile_no').val(); },
                            'id':function () { return $('#id').val(); },
                            }  
                    }
              
            },
             profile_pic:{
                    required: true,
                    accept: "jpg|jpeg|png",
                    extension: "jpg|jpeg|png"
                }  
          
        },
            messages: {
                name: {
                    required: "Please enter name",
                    maxlength:"Name length should be maximum 30 characters long"
                },
                email: {
                  required: "Please enter email address",
                  email: "Email address must be in the format of name@domain.com",
                  remote:"Email already exist"
                },
                 mobile_no: {
                  required: "Please enter mobile number",
                
                  remote:"Mobile number already exist",
                },
                  profile_pic: {
                  required: "Select Profile Pic",
                  extension: "Please upload file in these format only (jpg, jpeg, png).",
                  accept: "Please upload file in these format only jpg,jpeg,png"
   
                 
                },
               
            },
            submitHandler: function(form) 
            {
                 
                  $("#loading").show();
                 $("#submitAdminInfo").hide();
                 form.submit();
            },
             invalidHandler: function(){
                  $("#submitAdminInfo").show();
                  $("#loading").hide();
              }
        });
   
 });



function switchVisible() {
    if (document.getElementById('viewAdmin')) {

        if (document.getElementById('viewAdmin').style.display == 'none') {
            document.getElementById('viewAdmin').style.display = 'block';
            document.getElementById('editAdmin').style.display = 'none';
        }
        else {
            //for="profile_pic"
            var label = $("#profile_pic_label").attr("for", "profile_pic");
             $("#profile_pic_label").attr("title", "Click Image to Edit");
            $("#profile_pic_label").css({"background":"red","border-radius":'72px'}); 

            document.getElementById('viewAdmin').style.display = 'none';
            document.getElementById('editAdmin').style.display = 'block';
        }
    }
}



function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#previewHolder').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  } else {
    alert('select a file to see preview');
    $('#previewHolder').attr('src', '');
  }
}

$("#profile_pic").change(function() {
  readURL(this);
});


//PASSWORD CUSTOM VALIDATIONS
$.validator.addMethod("strong_password", function (value, element) {
    let password = value;
    if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!$#%@%&_])(.{8,20}$)/.test(password))) {
        return false;
    }
    return true;
}, function (value, element) {
    let password = $(element).val();
    if (!(/^(.{7,20}$)/.test(password))) {
        return 'Password must be between 7 to 20 characters long.';
    }
    else if (!(/^(?=.*[A-Z])/.test(password))) {
        return 'Password must contain at least one uppercase.';
    }
    else if (!(/^(?=.*[a-z])/.test(password))) {
        return 'Password must contain at least one lowercase.';
    }
    else if (!(/^(?=.*[0-9])/.test(password))) {
        return 'Password must contain at least one digit.';
    }
    else if (!(/^(?=.*[!$#%@%&_])/.test(password))) {
        return "Password must contain special characters from @#$%&.";
    }
    return false;
});
//
   $(document).on("click", "#changePassword", function () 
    {
        $('form[name=admin-change-password]').validate({            
            rules: {
                password: {
                    required:true,
                    minlength: 7,
                    strong_password:"#password",
                },
                confirm_password : {
                    required:true,
                    minlength : 7,
                    equalTo : "#password",
                    strong_password:"#confirm_password",
                }
            },
            messages: {
                password: {
                    required:"Password is required",
                    minlength:"Password must be atleast 7 characters long"
                },
                confirm_password: {
                    required:"Confirm Password is required",
                    equalTo: "Confirm password must be same as password",
                }
            },
            submitHandler: function(form) 
            {
                $("#loading").show();
                $("#changePassword").hide();
                form.submit();
            },
             invalidHandler: function(){
                $("#changePassword").show();
                $("#loading").hide();
              }
        });
    });

</script>   
@endsection