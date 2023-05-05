@extends('admin::layouts.master')
@section('title', 'Add Feedback')
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
                                    <h4>Add Feedback</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-enquiry-list')}}">Feedback List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-user-enquiry-add')}}">Add Feedback</a> </li>
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
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div> -->
                                </div>
                                <div class="card-block">
                                    <form method="POST" action="{{route('admin-user-enquiry-save')}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Feedback Title</label>
                                            <div class="col-sm-10">
                                               <input type="text" class="form-control  @error('title') is-invalid @enderror" name="title" id="title">
                                               @error('title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Feedback Add By</label>
                                            <div class="col-sm-10">
                                            <select name="add_by" class="form-control @error('add_by') is-invalid @enderror">
                                                <option value="">Select User</option>>
                                                @foreach($userList as $li)
                                                    <option value="{{$li->id}}">{{$li->name}}</option>
                                                @endforeach
                                            </select>
                                               @error('add_by')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{--<div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Feedback Attachments</label>
                                            <div class="col-sm-10">
                                               <input type="file" class="form-control  @error('attachment') is-invalid @enderror" name="attachment" id="attachment"  accept="image/*" onchange="loadFile(event)">
                                              @error('attachment')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <img id="output"/>
                                            </div>
                                        </div>--}}
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Description</label>
                                            <div class="col-sm-10">
                                            <textarea rows="5" cols="3" name="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                                            @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit"  class="btn btn-primary m-b-0">Save</button>
                                               
                                                <button type="reset" name="reset" value="reset" class="btn btn-warning m-b-0">Reset</button>

                                                <a href="{{route('admin-user-enquiry-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                                
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
