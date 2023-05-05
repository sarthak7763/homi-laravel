@extends('admin::layouts.master')
@section('title', 'Property Type Details')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Property Type-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Property Type Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-type-list')}}">Property Type List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-property-type-detail',$propertyTypeInfo->slug)}}">Property Type Details</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Property Type-header end -->

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
                   <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Property Type Details</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="general-info">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-xl-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-0" style="font-size: 12px">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th scope="row">Property Type Name</th>
                                                                                    <td>{{ $propertyTypeInfo->name}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Property Type Image</th>
                                                                                    <td><img src="{{ $propertyTypeInfo->icon}}" class="img-thumbnail" height="100" width="100"></td>
                                                                                </tr>
                                                                                  <th scope="row">Description</th>
                                                                                    <td style="white-space:pre-wrap; word-wrap:break-word">{{ @$propertyTypeInfo->description}}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                             
                                                            </div>
                                                            <!-- end of row -->
                                                        </div>
                                                        <!-- end of general info -->
                                                    </div>
                                                    <!-- end of col-lg-12 -->
                                                </div>
                                                <!-- end of row -->
                                            </div>
                                        </div>
                                        <!-- end of card-block -->
                                    </div>
                                 
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