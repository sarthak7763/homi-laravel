@extends('admin::layouts.master')
@section('title', 'Add User')

@section('content')

 @php 
 $name_error="";
  $type_error="";
  $description_error="";
  $meta_title_error="";
  $meta_description_error="";
  $meta_keywords_error="";
  @endphp

  @if (session()->has('valid_error'))
     @php $validationmessage=session()->get('valid_error'); @endphp
      @if($validationmessage!="" && isset($validationmessage['name']))
      @php $name_error=$validationmessage['name']; @endphp
      @else
      @php $name_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['type']))
      @php $type_error=$validationmessage['type']; @endphp
      @else
      @php $type_error=""; @endphp
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
                                    <h4>Edit Category </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-category-list')}}">Category List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-category-add')}}">Add Category</a> </li>
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
                <form  method="POST" action="{{route('admin-category-update')}}" name="updateBuyerForm"  enctype="multipart/form-data" id="updateBuyerForm">
                    @csrf
                    <div class="row">
                    <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Name<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" value="{{$catInfo->name}}" name="name" id="name"  placeholder="Enter Name">
                                <input type="hidden" name="id"  value="{{$catInfo->id}}">
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
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Type<span style="color:red;">*</span></label>
                                <input type="hidden" name="id"  value="{{$catInfo->id}}">
                                <select class="form-control" name="type" id="type">
                                <option value="1" <?php if(( $catInfo->category_type)=='1'){echo "selected";} ?>>Booking</option>
                                <option value="2" <?php if(( $catInfo->category_type)=='2'){echo "selected";} ?>>Renting</option>
                                @if($type_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                </select>

                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $type_error }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Description</label>
                                <textarea type="description" class="form-control" name="description" id="description" placeholder="Enter description">{{$catInfo->description}}</textarea>
                                @if($description_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $description_error }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group">
                                <label class="font-weight-bold">Meta Title</label>
                                <textarea rows="5" cols="10" class="form-control" name="meta_title" id="meta_title">{{$catInfo->meta_title}}</textarea>
                                @if($meta_title_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $meta_title_error }}</strong>
                                </span>
                            </div>
                        </div>


                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Meta Keywords<span style="color:red;">*</span></label>
                                <textarea rows="5" cols="10" class="form-control" name="meta_keywords" id="meta_keywords">{{$catInfo->meta_keywords}}</textarea>
                                @if($meta_keywords_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $meta_keywords_error }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group">
                                <label class="font-weight-bold">Meta Description</label>
                                <textarea rows="5" cols="10" class="form-control" name="meta_description" id="meta_description">{{$catInfo->meta_description}}</textarea>
                                @if($meta_description_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif
                                <span class="invalid-feedback" style="{{$style}}" role="alert">
                                    <strong>{{ $meta_description_error }}</strong>
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
