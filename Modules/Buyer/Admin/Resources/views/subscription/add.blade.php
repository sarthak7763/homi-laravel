@extends('admin::layouts.master')
@section('title', 'Add Subscription')

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
  <style type="text/css">
    .disabled-btn {
        opacity: 0.65; 
        cursor: not-allowed;
        pointer-events: none;
    }
    .permission-cls {
        width: 100%;  
        padding: 0 15px;
    }
    .permission-cls h6 {
        font-size: 20px;
        font-weight: 600;
    }
    .permission-cls ul {
        padding: 0;
        margin: 0;
        list-style: none;
        width: 100%;
    }
    .permission-cls ul li {
        padding: 15px;
        border: 1px solid #ced4da;
    }
    .label-title {
        display: inline-block;
        font-size: 20px;
        border-bottom: 1px solid #ced4da;
        padding-bottom: 10px;
        font-weight: 600;
    }
    .permission-cls ul li.form-group .form-check-wrap input {
        float: left;
        width: 18px;
        margin-top: 5px;
        margin-right: 5px;
    }
    .permission-cls ul li.form-group .form-check-wrap {
        display: inline-block;
        width: 24%;
        vertical-align: middle;
    }
    .permission-cls ul li.form-group .form-check-wrap .form-check-label {
        font-size: 15px;
        display: inline;
        cursor: pointer;
    }
    .error {
      color: red;
    }
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
                                    <h4>Add Subscription</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-subscription-list')}}">Subscription List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-subscription-add')}}">Add Subscription</a> </li>
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
            <form action="{{ route('admin-subscription-save') }}" id="SaveSubForm" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="text-input">Plan Name <span style="color:red;">*</span></label>
                        <input class="form-control" id="name" minlength="1" maxlength="255" name="name" type="text" value="{{ old('name') }}" autocomplete="off">
                        @if ($errors->has('name'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="text-input">Plan Title <span style="color:red;">*</span></label>
                        <input class="form-control" id="title" minlength="1" maxlength="255" name="title" type="text" value="{{ old('title') }}" autocomplete="off">
                        @if ($errors->has('title'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="text-input">Plan Duration <span style="color:red;">*</span></label>
                        <select name="plan_duration" id="plan_duration" class="plan_duration form-control">
                            <option value="">Select</option>
                            <option value="hourly" >Hourly</option>
                            <option value="daiy" >Daily</option>
                            <option value="weekly" >Weekly</option>
                            <option value="monthly" >Monthly</option>
                            <option value="quarterly" >Quarterly</option>
                            <option value="annually" >Annually</option>
                        </select>
                        @if ($errors->has('plan_duration'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('plan_duration') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="text-input">Plan Price <span style="color:red;">*</span></label>
                        <input class="form-control" id="plan_price" minlength="1" value="{{ old('plan_price') }}" maxlength="10" name="plan_price" type="text" title="Price" placeholder="Please Enter Price" autocomplete="off">
                        @if ($errors->has('plan_price'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('plan_price') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="text-input">Allow Product Listing <span style="color:red;">*</span></label>
                        <input class="form-control" id="product_listing" minlength="1" value="{{ old('product_listing') }}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="product_listing" type="text" title="Product Listing" placeholder="Please Enter Product Listing" autocomplete="off">
                        <span>Enter numeric value</span>
                        
                    </div>
                </div>

                
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="text-input">Description <span style="color:red;">*</span></label>
                        <textarea class="form-control" id="plan_description" minlength="3" name="plan_description">{{ old('plan_description') }}</textarea>
                        @if ($errors->has('plan_description'))
                        <div class="invalid-feedback" style="display:block;">{{ $errors->first('plan_description') }}</div>
                        @endif
                    </div>
                </div>

                

                <div class="form-group">
                    <label class="col-md-12" for="text-input">Status</label>
                    <div class="col-md-12">
                        <div class="form-check-sm mr-2">
                            <input type="radio"  class="form-check-input" id="inline-radio1" name="status" value="1" {{ (old('status') == "1")?'checked="checked"':"" }}>
                            <label class="form-check-label" for="inline-radio1">Active</label>
                        </div>
                        <div class="form-check-sm mr-2">
                            <input type="radio" class="form-check-input" id="inline-radio2"" name="status" value="0" {{ (old('status') == "0")?'checked="checked"':"" }}>
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
                    <button class="btn btn-sm btn-primary" id="submitBuyers" type="submit">Save</button>
                    <button class="btn btn-sm btn-danger reset_form" type="reset"> Reset</button>
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
    $("#SaveSubForm").validate({  
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

    $("#submitBuyers").on('click',function(){
        $("#SaveSubForm").submit();
        return false;
    });

CKEDITOR.replace('plan_description');
    jQuery(document).ready(function () {

        jQuery("#permission_name").select2({
            placeholder: "Please Module",
            allowClear: true,
            allowHtml: true
        });


        jQuery(".ckbCheckAll").click(function () {
            var ids = jQuery(this).attr("data-id");
            if (this.checked) {
                jQuery('.' + ids).each(function () {
                    jQuery(this).prop('checked', true);
                });
            } else {
                jQuery('.' + ids).each(function () {
                    jQuery(this).prop('checked', false);
                });
            }
        });
    });

</script>
@endsection
