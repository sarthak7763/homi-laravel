@extends('admin::layouts.master')
@section('title', 'Edit Reason')
@section('content')

<style type="text/css">
    label.error {
    color: red;
    font-size: 13px;
}
</style>

@php 
  $name_error="";
  $description_error="";
  $status_error="";
  @endphp

  @if (session()->has('valid_error'))
     @php $validationmessage=session()->get('valid_error'); @endphp
      @if($validationmessage!="" && isset($validationmessage['name']))
      @php $name_error=$validationmessage['name']; @endphp
      @else
      @php $name_error=""; @endphp
      @endif

      @if($validationmessage!="" && isset($validationmessage['status']))
      @php $status_error=$validationmessage['status']; @endphp
      @else
      @php $status_error=""; @endphp
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
                                    <h4>Edit Cancel Reason</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-reason-list')}}">Reason List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-reason-edit',$reasonInfo->id)}}">Reason Edit</a> </li>
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

            <div class="card-block">
                  <form method="POST" action="{{route('admin-reason-update')}}"  enctype="multipart/form-data" name="saveReasonForm" id="saveReasonForm">
                    @csrf
                    <input type="hidden" name="id" value="{{$reasonInfo->id}}">
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Reason Name<span style="color:red;">*</span></label>
                                <input type="text" value="{{$reasonInfo->reason_name}}" class="form-control" name="name" id="name">
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
                                <label class="font-weight-bold">Description</label>
                                <textarea rows="5" cols="10" class="form-control" name="description" id="description">{{$reasonInfo->reason_description}}</textarea>
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
                    </div>
                   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" @if($reasonInfo->reason_status==1) selected @endif>Active</option>
                                    <option value="0" @if($reasonInfo->reason_status==0) selected @endif>Inactive</option>
                                </select>
                            
                                @if($status_error!="")
                                @php $style="display:block;"; @endphp
                                @else
                                @php $style="display:none;"; @endphp
                                @endif

                                <span class="invalid-feedback" role="alert" style="{{$style}}">
                                    <strong>{{ $status_error }}</strong>
                                </span>  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <button type="submit" id="submitdata"  class="btn btn-success">Update</button>

                     
                            <a href="{{route('admin-reason-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
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


   $("#saveReasonForm").validate({  
        rules: {
            name:{
                required:true
            }, 
            status: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            status: {
                required: "Please select status",
            },
        },
        submitHandler: function(form) 
            {
                 
                $("#loading").show();
                $("#submitdata").hide();
                 form.submit();
            },
             invalidHandler: function(){
                  $("#submitdata").show();
                  $("#loading").hide();
        }
    });

   $("#submitdata").on('click',function(){
        $("#saveReasonForm").submit();
        return false;
    });

</script>

@endsection
