@extends('admin::layouts.master')
@section('title', 'Edit Permission')
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
                                    <h4>Edit Permission</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-permission-list')}}">Permission List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-edit-permission',$permissions->id)}}">Edit Permission</a> </li>
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
                                <div class="card-block">
                                    <form method="POST" action="{{route('admin-update-permission',$permissions->id)}}"  enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$permissions->id}}">
                                       
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Permission Name</label>
                                                    <input type="text" value="{{$permissions->name}}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required="required">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-12">
                                               <div class="form-group">
                                                    <strong>Permission:</strong>
                                                    <div class="row srollable_sec">
                                                    @foreach($permission as $value)
                                                        <label class="col-xs-12 col-sm-2 col-md-2 font-weight-normal">{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                        {{ $value->name }}</label>
                                                    <br/>
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            <button type="submit" class="btn btn-success">Update</button>

                                            <a href="{{route('admin-role-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
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
        <div id="styleSelector">

        </div>
    </div>
</div>
@endsection
@section('js')
@endsection