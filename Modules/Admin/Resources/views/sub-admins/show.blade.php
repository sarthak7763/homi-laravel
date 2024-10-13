@extends('admin::layouts.master')
@section('title', 'Sub-Admin List')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header my-2">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Sub-admin Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-sub-admins')}}">Sub Admin List</a> </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-view-sub-admin',[$user->slug])}}">Sub Admin Details</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
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
                            <div class="card-block">    
                                  <table id="dataTable" class="table table-striped table-bordered table-hover">
                                <tbody>
                            
                                    <tr>
                                        <th> Profile Picture</th>
                                        <td><img src="{{$user->profile_pic}}" height="100" width="100" alt="img" /></td>
                                    </tr>
                                    {{--<tr>
                                        <th> Username:</th>
                                        <td>{{ $user['username'] }}</td>
                                    </tr>--}}
                                    <tr>
                                        <th> Name:</th>
                                        <td>{{ $user['name'] }}</td>
                                    </tr>
                                  
                                    <tr>
                                        <th> Email Address:</th>
                                        <td>
                                            <b>
                                                <a href="mailto:{{ $user['email'] }}">
                                                    {{ $user['email'] }}
                                                </a>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th> Contact Number:</th>
                                        <td>
                                            <a href="tel:{{ @$user->country_std_code.@$user->mobile_no }}">
                                                {{ getMobileFormat(@$user->mobile_no) }}
                                            </a>
                                        </td>
                                    </tr>
                                
                                   {{--  <tr>
                                        <th> Country Name:</th>
                                        <td>{{ @$user->country_name }}</td>
                                        
                                    </tr>--}}
                                   
                                    <tr>
                                        <th> Assign Modules</th>
                                        <td>
                                        <div class="" style="height:auto; max-height:150px;overflow-y: scroll;">
                                            <?php
                                            $userPrPermitn = [];
                                            if (@$userPr && count($userPr) > 0) {
                                                foreach ($userPr as $key => $userPrEach) {
                                                    if ($key != "default") {
                                                        $userPrPermitn[] = "<li>" . ucwords($key) . "</li>";
                                                    }
                                                }
                                                echo implode(" ", $userPrPermitn);
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th> Created At:</th>
                                        <td>{{ date_format($user->created_at,"M d, Y")}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th> Status:</th>
                                        <td>
                                            @if($user['status'] == 1) 
                                            <span class="badge badge-success">Active</span>
                                            @else 
                                            <span class="badge badge-danger">Deactive</span>
                                            @endif 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         </div>
                    </div>     
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript"> 
</script>
@endsection