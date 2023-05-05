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
                                    <li class="breadcrumb-item"><a href="{{route('admin-cms-page-list')}}">Page List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-cms-page-edit',$cmsInfo->page_slug)}}">Edit Page</a> </li>
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
                                     <form method="POST" action="{{route('admin-cms-page-update')}}">
                                        @csrf
                                        <input type="hidden" name="page_slug" value="{{$cmsInfo->page_slug}}">
                                         <input type="hidden" name="id" value="{{$cmsInfo->id}}">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Page Name<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                               <input type="text" class="form-control @error('page_name') is-invalid @enderror" name="page_name" value="{{$cmsInfo->page_name}}" id="page_name">
                                               @error('page_name')
                                                     <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Page Title<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                               <input type="text" class="form-control @error('page_title') is-invalid @enderror" name="page_title" value="{{$cmsInfo->page_title}}" id="page_title">
                                               @error('page_title')
                                                     <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                
                                            </div>
                                        </div>
                                        {{--<div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Page Slug<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                               <input type="text" class="form-control @error('page_slug') is-invalid @enderror" name="page_slug" value="{{$cmsInfo->page_slug}}" id="page_slug">
                                               @error('page_slug')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>--}}
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label font-weight-bold">Description<span style="color:red;">*</span></label>
                                            <div class="col-sm-10">
                                            <textarea rows="5" cols="3" id="page_description" name="page_description" class="ck-editor @error('page_description') is-invalid @enderror">{{$cmsInfo->page_description}}</textarea>
                                             @error('page_description')
                                                     <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                @if(Auth::user()->hasRole('Admin')) 
                                                    
                                                    <button type="submit" class="btn btn-primary m-b-0">Update</button>
                                                    
                                                    <a href="{{route('admin-cms-page-list')}}" class="btn btn-inverse m-b-0">Go Back</a>
                                            
                                                
                                                @elseif(Auth::user()->hasRole('sub-admin'))

                                                    @if(auth()->user()->can('admin-cms-page-update'))
                                                       
                                                        <button type="submit" class="btn btn-primary m-b-0">Update</button>
                                                    

                                                    @endif
                                                    @if(auth()->user()->can('admin-cms-page-list'))
                                                        <a href="{{route('admin-cms-page-list')}}" class="btn btn-inverse m-b-0">Go Back</a>  
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
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
CKEDITOR.replace( 'page_description' );


if ($("#page_description").hasClass("is-invalid")) {
  $(".invalid-feedback").show();
}
</script>
@endsection
