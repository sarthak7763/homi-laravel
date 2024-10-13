@extends('admin::layouts.master')
@section('title', 'Subscription Details')
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
                           <h4>Subscription Details</h4>
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
                           <li class="breadcrumb-item"><a href="{{route('admin-user-list')}}">Subscription list</a> </li>
                           <li class="breadcrumb-item"><a href="{{route('admin-user-details',$plan->id)}}">Subscription Details</a> </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="card">
                              <div class="card-header btn_modify full">
                                 <h5 class="card-header-text">Subscription Info</h5>
                                 <a href="{{route('admin-subscription-edit',$plan->id)}}" id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right wdh-60">
                                 <i class="icofont icofont-edit"></i>
                                 </a>
                              </div>
                              <div class="card-block">
                                 <div class="view-info">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="general-info">
                                             <div class="row">
                                                <div class="col-lg-12 col-xl-12">
                                                   <div class="table-responsive">
                                                      <table id="dataTable" class="table table-striped table-bordered table-hover">
                                                         <tbody>
                                                            <tr>
                                                               <th> Plan Name:</th>
                                                               <td>
                                                                  {{ $plan['name'] }}
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <th> Plan Title:</th>
                                                               <td>
                                                                  {{ $plan['plan_title'] }}
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <th> Plan Duration:</th>
                                                               <td>{{ ($plan["plan_duration"] > 1)?$plan["plan_duration"]." Months":$plan["plan_duration"]." Month" }}</td>
                                                            </tr>
                                                            <tr>
                                                               <th> Plan Price</th>
                                                               <td><?php echo $plan["currency_symbol"] . $plan["plan_price"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                               <th> Status:</th>
                                                               <td>
                                                                  @if($plan['status'] == 1) 
                                                                    <span class="badge badge-success">Active</span>
                                                                  @else 
                                                                    <span class="badge badge-danger">Deactive</span>
                                                                  @endif 
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <th> Created:</th>
                                                               <td>
                                                                  {{ date_format($plan["created_at"],"d M Y h:m")}}
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <th> Plan Description</th>
                                                               <td>{!! $plan["plan_description"] !!}</td>
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

