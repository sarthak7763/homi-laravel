@extends('admin::layouts.master')
@section('title', 'User Details')
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
                                    <h4>User Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-list')}}">User list</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-user-details',$userInfo->id)}}">User Details</a> </li>
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
                   <div class="row">
                        <div class="col-xl-3">
                            <!-- user contact card left side start -->
                            <div class="card">
                                <div class="card-header contact-user">
                                    @if($userInfo->profile_pic!="")
                                    <img class="img-radius img-40" src="{{url('/')}}/images/user/{{ $userInfo->profile_pic}}" alt="user-pic">
                                    @else
                                     <img class="img-radius img-40" src="{{url('/')}}/images/user-img.png" alt="user-pic">
                                    @endif
                                    <h5 class="m-l-10"> {{$userInfo->name}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header btn_modify full">
                                    <h5 class="card-header-text">Personal Info</h5>
                                </div>
                                <div class="card-block">
                                <div class="view-info">
                                    <div class="row">
                                    <div class="col-lg-12">
                                <table class="table table-styling table-bordered nowrap">
                                    <tbody>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{$userInfo->email}}</td>  
                                    </tr>

                                    <tr>
                                        <th>Mobile:</th>
                                        @if($userInfo->country_id!="")
                                            <td>{{$userInfo->country_id}}{{$userInfo->mobile}}</td>
                                        @else
                                            <td>{{$userInfo->mobile}}</td>
                                        @endif  
                                    </tr>

                                    <tr>
                                        <th>Registered Date:</th>
                                        @php
                                            $registerdate=date('d M, Y g:i A', strtotime($userInfo->created_at));
                                        @endphp
                                        <td>{{$registerdate}}</td>  
                                    </tr>

                                    <tr>
                                        <th>Email Verified:</th>
                                        @if($userInfo->email_verified==1)
                                        <td>
                                            <span class="badge badge-success">Verified</span>
                                        </td>
                                        @else
                                        <td>
                                            <span class="badge badge-danger">Unverified</span>
                                        </td> 
                                        @endif  
                                    </tr>

                                     <tr>
                                        <th>Status:</th>
                                        @if($userInfo->status==1)
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        @else
                                        <td>
                                            <span class="badge badge-danger">Suspend</span>
                                        </td> 
                                        @endif  
                                    </tr>
                                        
                                    </tbody>
                                    </table>
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