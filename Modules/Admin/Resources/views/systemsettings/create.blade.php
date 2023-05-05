@extends('admin::layouts.master')
@section('title', 'Add New Option')
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
                                    <h4>System Setting-Add New Option</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-system-settings')}}">System Setting</a> </li>
                                    
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
                                    <form action="{{route('admin-add-system-setting-post')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Setting Option name</label>
                                                    <input class="form-control @error('option_name') is-invalid @enderror" id="option_name" name="option_name" type="text" title="nf-title" placeholder="Please Enter Setting Option Name" autocomplete="option_name">
                                                    @if ($errors->has('option_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('option_name') }}
                                                    </span>
                                                    @endif
                                               
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="font-weight-bold">Value</label>
                                                    <input class="form-control @error('option_value') is-invalid @enderror" id="option_value" name="option_value" type="text" title="nf-title" placeholder="Please Enter Value" autocomplete="option_value">
                                                    @if ($errors->has('option_value'))
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('option_value') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Setting Type</label>
                                                    <select name="setting_type" id="setting_type" class="form-control @error('setting_type') is-invalid @enderror">
                                                        <option value="">Select</option>
                                                        <option value="smtp">SMTP</option>
                                                    <!--     <option value="stripe">Stripe</option> -->
                                                        <option value="footersocialmedia">Footer Social Media</option>
                                                        <option value="sitelogo">Logo</option>
                                                        <option value="sitefavicon">Fav Icons</option>
                                                        <option value="currency">Currency</option>
                                                        <option value="header_content">Header Content</option>
                                                        <option value="footer_content">Footer Content</option>
                                                        <option value="googleservicekeys">Google Serveice Key</option>
                                                        
                                                    </select>
                                                    @if ($errors->has('setting_type'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('setting_type') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Status</label>
                                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                                        <option value="1">Active</option>
                                                         <option value="0">Inactive</option>
                                                    </select>
                                                    @if ($errors->has('status'))
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $errors->first('status') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-success">Save</button>
                                         
                                                <button type="reset"  class="btn btn-warning m-b-0 reset_form">Reset</button>

                                                <a href="{{route('admin-system-settings')}}" class="btn btn-inverse m-b-0">Go Back</a>  
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
<style type="text/css">
    .cke_reset{
        width: 100%;
    }
</style>
<script>
    CKEDITOR.replace('content');
    $(document).ready(function () {
        $(".reset_form").on("click", function () {
            window.location.href = '<?php echo route('admin-system-settings'); ?>';
        });
    });
</script>
@endsection

