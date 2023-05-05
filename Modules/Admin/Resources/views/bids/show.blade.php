@extends('admin::layouts.master')
@section('title', 'Bid Details')
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
                                    <h4>Bid Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-bid-list')}}">Bid List</a> </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-bid-view',$bidInfo->id)}}">Bid Details</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
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
                            <div class="card-block">    
                                  <table id="dataTable" class="table table-striped table-bordered table-hover">
                                <tbody>
                            
                                  
                                    <tr>
                                        <th> Bidder Name:</th>
                                        <td><a href="{{route('admin-user-details',$bidInfo->bidder_id)}}">{{ $bidInfo->BidderInfo->name}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Bid Price</th>
                                        <td>{{ moneyFormat($bidInfo->bid_price)}}</td>
                                    </tr>
                                    <tr>
                                         <th>Property</th>
                                       
                                        <td><a href="{{route('admin-property-details',$bidInfo->BidPropertyInfo->slug)}}">{{ $bidInfo->BidPropertyInfo->title}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Bid Status</th>
                                        <td>
                                                {{ @$bidInfo->bid_status}}
                                           
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <th> Created At:</th>
                                        <td>{{ date_format($bidInfo->created_at,"M d, Y")}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th> Status:</th>
                                        <td>
                                            @if($bidInfo->status == 1) 
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