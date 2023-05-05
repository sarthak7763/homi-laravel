@extends('admin::layouts.master')
@section('title', 'Add Property Type')
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
                                    <h4>Add Property Type</h4>
                                    <span></span>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> 
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-type-list')}}">Property Type</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-property-type-add')}}">Add Property Type</a> </li>
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
                                   <!--  <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                          <!--   <li><i class="feather icon-trash-2 close-card"></i></li> -->
                                        </ul>
                                    </div>
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
                                     <form method="POST" action="{{route('admin-property-type-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label font-weight-bold">Property Type Name<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                               <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter property-type Name">
                                               @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label font-weight-bold">Property Type Icon</label>
                                            <div class="col-sm-9">
                                               <input type="file" class="form-control  @error('icon') is-invalid @enderror" name="icon" id="icon"  accept="image/*" onchange="loadFile(event)">
                                            @error('icon')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <img id="output"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label font-weight-bold">Description</label>
                                            <div class="col-sm-9">
                                            <textarea rows="5" cols="3" name="description" class="form-control  @error('description') is-invalid @enderror"></textarea>
                                            @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3"></label>
                                            <div class="col-sm-9">
                                                <button type="submit"  class="btn btn-primary m-b-0">Save</button>
                                                <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>
                                                <a href="{{route('admin-property-type-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
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
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    $("#output").css("width", 200);
    $("#output").css("height", 150);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>
@endsection
