@extends('admin::layouts.master')
@section('title', 'Edit Subscription')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">

<style type="text/css">
  label.error{
    color: red;
     font-weight: bold;
    }
 #city-error{
        position: relative;
    top: 66px;
    right: 84px;
    }
</style>
@endsection
@section('content')
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
                                    <h4>Edit Subscription</h4>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-list')}}">Subscription List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-user-edit',$userInfo->id)}}">Edit Subscription</a> </li>
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
                               <!--  <div class="card-header">
                                    <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div>
                                </div> -->
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
                                <form action="{{ route('admin-subscription-update') }}" method="POST" enctype="multipart/form-data" id="editSubForm">
                {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$userInfo->id}}">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="text-input">Plan Name <span style="color:red;">*</span></label>
                        <input class="form-control" id="name" minlength="1" maxlength="255" name="name" type="text" value="{{$userInfo->name}}" title="Name" placeholder="Please Enter Title" autocomplete="off">
                        @if ($errors->has('name'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="text-input">Plan title <span style="color:red;">*</span></label>
                        <input class="form-control" id="title" minlength="1" maxlength="255" name="title" type="text" value="{{$userInfo->plan_title}}" title="Title" placeholder="Please Enter Title" autocomplete="off">
                        @if ($errors->has('title'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="text-input">Plan Duration <span style="color:red;">*</span></label>
                        <select name="plan_duration" id="plan_duration" class="plan_duration form-control">
                            <option value="">Select</option>
                            <option value="hourly" {{ ($userInfo->plan_duration == "hourly")?'selected':"" }} >Hourly</option>
                            <option value="daiy" {{ ($userInfo->plan_duration == "daiy")?'selected':"" }} >Daily</option>
                            <option value="weekly" {{ ($userInfo->plan_duration == "weekly")?'selected':"" }} >Weekly</option>
                            <option value="monthly" {{ ($userInfo->plan_duration == "monthly")?'selected':"" }} >Monthly</option>
                            <option value="quarterly" {{ ($userInfo->plan_duration == "quarterly")?'selected':"" }} >Quarterly</option>
                            <option value="annually" {{ ($userInfo->plan_duration == "annually")?'selected':"" }} >Annually</option>
                        </select>
                        @if ($errors->has('plan_duration'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('plan_duration') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="text-input">Plan Price <span style="color:red;">*</span></label>
                        <input class="form-control" id="plan_price" minlength="1" value="{{$userInfo->plan_price}}" maxlength="10" name="plan_price" type="text" title="Price" placeholder="Please Enter Price" autocomplete="off">
                        @if ($errors->has('plan_price'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('plan_price') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="text-input">Allow Product Listing <span style="color:red;">*</span></label>
                        <input class="form-control" id="product_listing" minlength="1" value="{{$userInfo->product_listing}}" maxlength="10" name="product_listing" type="text" title="Product Listing" placeholder="Please Enter Product Listing" autocomplete="off">
                        <span>Enter numeric value</span>
                        
                    </div>
                </div>

                
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="text-input">Description <span style="color:red;">*</span></label>
                        <textarea class="form-control" id="plan_description" minlength="3" name="plan_description">{{$userInfo->plan_description}}</textarea>
                        @if ($errors->has('plan_description'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('plan_description') }}</div>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-12" for="text-input">Status</label>
                    <div class="col-md-12">
                        <div class="form-check form-check-inline form-check-sm mr-2">
                            <input type="radio"  class="form-check-input" id="inline-radio1" name="status" value="1" {{ ($userInfo->status == "1")?'checked="checked"':"" }}>
                            <label class="form-check-label" for="inline-radio1">Active</label>
                        </div>
                        <div class="form-check form-check-inline form-check-sm mr-2">
                            <input type="radio" class="form-check-input" id="inline-radio2"" name="status" value="0" {{ ($userInfo->status == "0")?'checked="checked"':"" }}>
                            <label class="form-check-label" for="inline-radio2">Deactivate</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @if ($errors->has('status'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                </div>


                <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit">Update</button>
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

<style type="text/css">
    .phone_number_sec .intl-tel-input {
        width: 100%;
    }
    .phone_number_sec .form-group .form-control {
        padding-left: 80px;
    }
    .phone_number_sec .flag-box {
        display: inline-block;
        vertical-align: middle;
    }
    .phone_number_sec .country .country-name, .phone_number_sec .country .country-dial-code {
        overflow: hidden;
        padding-left: 15px;
    }
    .form-check-wrap {
        display: inline-block;
        vertical-align: middle;
        padding: 0 20px 13px 0;
    }
    .form-group .form-check-wrap label {
        width: auto;
    }
    .form-check-wrap input[type="checkbox"], .form-check-wrap input[type="radio"] {
        vertical-align: middle;
    }

</style>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

<script type="text/javascript">
$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
CKEDITOR.replace('plan_description');

$("#editSubForm").validate({  
        rules: {
            name:{
                required:true
            }, 
            title:{
                required:true
            }, 
            plan_duration:{
                required:true
            },
            plan_price:{
                required:true
            },
            plan_description:{
                required:true
            },
            product_listing:{
                required:true

            }
           

        },
        messages: {
            name: {
                required: "Please enter name",
            },
            title: {
                required: "Please enter title",
            },
            plan_duration: {
                required: "Please enter plan duration",
            },
            plan_price: {
                required: "Please enter plan price",
            },
            plan_description: {
                required: "Please enter plan description",
            },
            product_listing: {
                required: "Please enter plan description",
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

</script>
@endsection
