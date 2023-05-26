@extends('admin::layouts.master')
@section('title', 'Add Category')

@section('content')

<style type="text/css">
    label.error {
    color: red;
    font-size: 13px;
}
</style>

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
                                    <li class="breadcrumb-item"><a href="{{route('admin-category-list')}}">Users List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-category-add')}}">Add User</a> </li>
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
                <form  method="POST" action="{{route('admin-category-save')}}" name="saveCategoryForm"  enctype="multipart/form-data" id="saveCategoryForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Name<span style="color:red;">*</span></label>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Type<span style="color:red;">*</span></label>
                                <select class="form-control" name="type" id="type">
                                  <option value="">Select Type</option>
                                  <option value="1">Booking</option>
                                  <option value="2">Renting</option>
                                </select>
                                @if($type_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif

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
                                <textarea rows="5" cols="10" class="form-control" name="description" id="description"></textarea>
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
                                <label class="font-weight-bold">Meta Title </label>
                                <textarea rows="5" cols="10" class="form-control" name="meta_title" id="meta_title"></textarea>
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
                                <label class="font-weight-bold">Meta keywords</label>
                                <textarea rows="5" cols="10" class="form-control" name="meta_keywords" id="meta_keywords"></textarea>
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
                                <textarea rows="5" cols="10" class="form-control" name="meta_description" id="meta_description"></textarea>
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

                            <a href="{{route('admin-category-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
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


   $("#saveCategoryForm").validate({  
        rules: {
            name:{
                required:true
            }, 
            type: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            type: {
                required: "Please select category type",
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
        $("#saveCategoryForm").submit();
        return false;
    });

</script>
@endsection
