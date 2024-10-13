@extends('admin::layouts.master')
@section('title', 'Edit Country')
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
                                    <h4>Edit Country</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-country-list')}}">Country List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-country-edit',$countryInfo->id)}}">Edit Country</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="page-body">
                    <form method="POST" action="{{route('admin-country-update')}}"  enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$countryInfo->id}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Country Name<span style="color:red;">*</span></label>
                                    <input type="text" value="{{$countryInfo->name}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required="required">
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
                                    <label class="font-weight-bold">Country Abbreviation<span style="color:red;">*</span></label>
                                    <input type="text" value="{{$countryInfo->sortname}}" class="form-control @error('sortname') is-invalid @enderror" name="sortname" id="sortname" required="required">
                                    @error('sortname')
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
                                    <select class="form-control" name="status">
                                        <option value="1" @if($countryInfo->status==1) selected @endif>Enable</option>
                                        <option value="0" @if($countryInfo->status==0) selected @endif>Disable</option>
                                    </select>
                                    <small class="form-text text-muted">Disable it will prevent users set the country preference of this country or creating listings based on this country.</small>
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
                            @if(Auth::user()->hasRole('Admin')) 

                                <button type="submit"  class="btn btn-success">Update</button>
                                <a href="{{route('admin-country-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  

                            @elseif(Auth::user()->hasRole('sub-admin'))

                                @if(auth()->user()->can('admin-country-update'))
                                   
                                   <button type="submit" class="btn btn-success">Update</button>
                               
                                @endif
                                @if(auth()->user()->can('admin-country-list'))
                                    <a href="{{route('admin-country-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
                                @endif
                            @endif
                                              
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
