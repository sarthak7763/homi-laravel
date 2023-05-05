@extends('admin::layouts.master')
@section('title', 'Add Reason')
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
                                    <h4>Add Feedback Reason</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-reason-list')}}"> Reason List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-reason-add')}}">Add Reason</a> </li>
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
                                <!-- <div class="card-header">
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
                                <div class="card-block">
                                        <form method="POST" action="{{route('admin-reason-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                    {{-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Select Reason Type<span style="color:red;">*</span></label>
                                                    <select  class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                                     
                                                        <option value="Complaint">Complaint</option>
                                                        <option value="Enquiry">Enquiry</option>
                                                    </select>
                                                    @error('type')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Reason Name<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" placeholder="Enter Reason Name">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Status</label>
                                                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                                                        <option value="1" {{ old('status') == "1" ? 'selected' : '' }}>Enable</option>
                                                        <option value="0" {{ old('status') == "0" ? 'selected' : '' }}>Disable</option>
                                                    </select>
                                                    <small class="form-text text-muted">Disable it will prevent users set the reason preference of this reason or creating listings based on this reason.</small>
                                                    @error('status')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            
                                                <button type="submit"  class="btn btn-success">Save</button>
                                                
                                                <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

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
@endsection