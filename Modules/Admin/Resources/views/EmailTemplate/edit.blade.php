@extends('admin::layouts.master')
@section('title', 'Edit Page')
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
                                    <h4>Edit Page</h4>
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
                                    <li class="breadcrumb-item"><a href="">Email Template List</a> </li>
                                     <li class="breadcrumb-item"><a href="">Edit Page</a> </li>
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
                                    <!-- h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div> -->
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

                                </div>
                                <div class="card-block">
                                    <form method="post" action="{{route('admin-email-template-update',$templateInfo->id)}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Email Name<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                               <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" value="{{$templateInfo->name}}" placeholder="Enter Email Name">
                                               @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Email Subject<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                               <input type="text" class="form-control  @error('subject') is-invalid @enderror" name="subject" id="subject" value="{{$templateInfo->subject}}" placeholder="Enter Email Subject">
                                               @error('subject')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Email Type<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                               <input type="number" class="form-control  @error('email_type') is-invalid @enderror" name="email_type" id="email_type" value="{{$templateInfo->email_type}}" placeholder="Enter Email Type">
                                               @error('email_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Email Message<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                            <textarea rows="5" cols="3" id="message" name="message" class="ck-editor @error('message') is-invalid @enderror">{{$templateInfo->message}}</textarea>
                                            @error('message')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                            <button type="submit"  class="btn btn-primary m-b-0">Update</button>
                                            
                                            <a href="{{route('admin-email-template-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                            
                                                
                                                
                                                
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
CKEDITOR.replace( 'message' );
function clearData(){
    for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
    CKEDITOR.instances[instance].setData('');
 
}


if ($("#message").hasClass("is-invalid")) {
  $(".invalid-feedback").show();
}
</script>
@endsection