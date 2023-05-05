@extends('admin::layouts.master')
@section('title', 'Property Sale Timer Detail')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Property Sale Timer Detail</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-sales-list')}}">Sale Timer List</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-property-sales-detail-show',$saleInfo->id)}}">Sale Offer Detail</a> </li>
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
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Sale Timer Detail</h5>
                                           
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
                                                                                    <th scope="row">Property Name</th>
                                                                                    <td><a href="{{route('admin-property-details',$saleInfo->OfferPropertyInfo->slug)}}">{{ $saleInfo->OfferPropertyInfo->title}}</a></td>
                                                                                </tr>
                                                                                  <tr>
                                                                                    <th scope="row">Property Code</th>
                                                                                    <td>{{ $saleInfo->OfferPropertyInfo->property_code}}</td>
                                                                                </tr>
                                                                                 <tr>
                                                                                    <th scope="row">Living SqFt</th>
                                                                                    <td>{{ numberPlaceFormat(@$saleInfo->OfferPropertyInfo->property_size)}}
                                                                                   </td>
                                                                                </tr>
                                                                                 <tr>
                                                                                    <th scope="row">List Price</th>
                                                                                    <td>{{ moneyFormat($saleInfo->OfferPropertyInfo->base_price)}}</td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <th scope="row">Property Sale Timer Start Date</th>
                                                                                    <td>@php echo date('M-d-Y',strtotime($saleInfo->date_start));@endphp  At {{date('h:i A',strtotime($saleInfo->time_start))}}


                                                                                  </td> 
                                                                                </tr>
                                                                                 <tr>
                                                                                    <th scope="row">Property Sale Timer End Date</th>
                                                                                    <td>@php echo date('M-d-Y',strtotime($saleInfo->date_end));@endphp  At {{date('h:i A',strtotime($saleInfo->time_end))}}</td> 
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Sale Timer Detail</th>
                                                                                     <td style="white-space:pre-wrap; word-wrap:break-word">{!!  $saleInfo->offer_details !!}</td> 
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Sale Timer Status</th>
                                                                                    <td>
                                                                                    @if($saleInfo->sale_status == 1)
                                                                                            Published
                                                                                    @else
                                                                                            Not Published
                                                                                    @endif
                                                                                    
                                                                                    </td>
                                                                                </tr>
                                                                                   <tr>
                                                                                    <th scope="row"> Status</th>
                                                                                    <td>
                                                                                    @if($saleInfo->status == 1)
                                                                                            Active
                                                                                    @else
                                                                                            Enactive
                                                                                    @endif
                                                                                    
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Created Date</th>
                                                                                    <td>{{ $saleInfo->created_at->format('M d, Y') }}</td>
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