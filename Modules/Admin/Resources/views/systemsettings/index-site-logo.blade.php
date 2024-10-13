@extends('admin::layouts.master')
@section('title', 'System Settings: Website Logo & favicons')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>System Settings: Website Logo & favicons</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-system-settings')}}">System Settings: Website Logo & favicons</a> </li>
                                    
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
                                   <!--  <h5>Update Site Logo Or Favicon</h5> -->
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
                                

@if (@$errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ @$error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                                     <form action="{{route('admin.edit.site.logo')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                        <div class="col-md-4">
                                            <input type="file" name="value" class="form-control @error('value') is-invalid @enderror" required="required">
                                          
                                                 <span class="invalid-feedback" role="alert">
                                                    <strong></strong>
                                                </span>
                                         
                                             @if(@$systemSettingData->option_value != "")
                                                <img src="{{ asset('/storage/'.@$systemSettingData->option_value)}}" height="100" width="100" alt="img" class="image-thumbnail">
                                            @endif 
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <button class="btn btn-sm btn-primary" type="submit">Update Logo</button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-block">

                                     <form action="{{route('admin.edit.site.favicon')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                        <div class="col-md-4">
                                            <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror" required="required">
                                          
                                                 <span class="invalid-feedback" role="alert">
                                                    <strong></strong>
                                                </span>
                                         
                                             @if(@$systemfavData->option_value != "")
                                                <img src="{{ asset('/storage/'.@$systemfavData->option_value)}}" height="100" width="100" alt="img" class="image-thumbnail">
                                            @endif 
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <button class="btn btn-sm btn-primary" type="submit">Update Favicon</button>
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
   
</script>
@endsection