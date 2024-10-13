@extends('admin::layouts.master')
@section('title', 'Add Page')
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
                                    <h4>Add Page</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-notification-list')}}">Notifications List</a> </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-notification-add')}}">Add Notifications</a> </li>
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
                                    <form method="Post" action="{{route('admin-notification-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Notification Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control"  name="notification_image" id="notification_image">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2 text-center">
                                            <img id="notification_image_preview" src="#"
                                                alt="" style="max-width: 50px;">
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Notification Title<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control  @error('title') is-invalid @enderror" name="title" id="title" value="{{old('title')}}" placeholder="Enter Title">
                                                @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Property Owners<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control livesearch" id="vendor_id" name="vendor_id[]" multiple="multiple">
                                                    <option value="">Select Owner</option>
                                                    @foreach($Property_owners as $seller)    
                                                    <option value="{{$seller['id']}}">{{$seller['name']}}</option>
                                                    @endforeach
                                                </select>
                                                @error('vendor_id')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Property Buyers<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control livesearch" id="buyer_id" name="buyer_id[]" multiple="multiple">
                                                    <option value="">Select Buyer</option>
                                                    @foreach($Property_buyers as $buyer)
                                                    <option value="{{$buyer['id']}}">{{$buyer['name']}}</option>
                                                    @endforeach
                                                </select>
                                                @error('buyer_id')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Message<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea rows="5" cols="3" id="notification_message" name="notification_message" class="ck-editor @error('notification_message') is-invalid @enderror">{!! old('notification_message')!!}</textarea>
                                                @error('notification_message')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit"   class="btn btn-primary m-b-0">Save</button>
                                                <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0 reset_form" onclick="clearData();">Reset</button>
                                                <a href="{{route('admin-notification-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                            </div>
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
    CKEDITOR.replace( 'notification_message' );
    function clearData(){
        for ( instance in CKEDITOR.instances ){
            CKEDITOR.instances[instance].updateElement();
        }
        CKEDITOR.instances[instance].setData('');
     
    }
    
    
    if ($("#notification_message").hasClass("is-invalid")) {
      $(".invalid-feedback").show();
    }
</script>
<script type="text/javascript">
    $('.livesearch').select2({});
</script>
<script type="text/javascript">
    $(document).ready(function (e) {
       
    $('#notification_image').change(function(){
    let reader = new FileReader();
    reader.onload = (e) => {
    
    $('#notification_image_preview').attr('src', e.target.result);
    
        }
    
    
    
    reader.readAsDataURL(this.files[0]);
    
     
    
    
    });
    
       });
    
</script>
@endsection