@extends('admin::layouts.master')
@section('title', 'Add State')
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
                                    <h4>Add State</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-state-list')}}"> State List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-state-add')}}">Add State</a> </li>
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
                                        <form method="POST" action="{{route('admin-state-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                      <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Select Country<span style="color:red;">*</span></label>
                                                    <select  class="form-control @error('country') is-invalid @enderror" name="country" id="country">
                                                        @foreach($countryList as $li)
                                                        <option value="{{$li->id}}">{{$li->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('country')
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
                                                    <label class="font-weight-bold">State Name<span style="color:red;">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}">
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
                                                    <small class="form-text text-muted">Disable it will prevent users set the state preference of this state or creating listings based on this state.</small>
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
                                            
                                                <button type="submit" class="btn btn-success">Save</button>
                                                
                                                <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                <a href="{{route('admin-state-list')}}" class="btn btn-inverse m-b-0">Go Back</a>

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