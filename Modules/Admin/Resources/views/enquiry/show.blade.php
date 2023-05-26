@extends('admin::layouts.master')
@section('title', 'Enquiry Details')

<style type="text/css">
	.carousel-item img {
    height: 300px;
    object-fit: cover;
    object-position: center;
}
</style>
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
                                    <h4>Enquiry Details</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-enquiry-list')}}">Enquiry List</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-enquiry-details',$enquiryinfo->id)}}">Enquiry Details</a></li>
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
                            <label class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="font-size: 19px; margin-top: -1px;">&times;</span>
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
                <div class="card">
                    <div class="card-block">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                               <!-- Nav tabs -->
                               <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active"  href="{{route('admin-enquiry-details',$enquiryinfo->id)}}">About</a>
                                    <div class="slide"></div>
                                </li>   
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="AboutTab">
                                    <div class="card col-md-12 o-auto">

                                        <div class="card-header btn_modify full">
                                            <h5 class="card-header-text">About Enquiry</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row" style="font-size: 12px">

                          <div class="col-lg-9">
                            <div class="general-info">
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-lg-12 col-xl-12">
                                    <dl class="row">
                                        <dt class="col-4 col-sm-4">Name</dt>
                                        <dd class="col-8 col-sm-8">{{$enquiryinfo->name}}</dd>

                                        <dt class="col-4 col-sm-4">Email</dt>
                                        <dd class="col-8 col-sm-8">{{$enquiryinfo->email}}</dd>

                                        <dt class="col-4 col-sm-4">Message</dt>
                                        <dd class="col-8 col-sm-8">{{$enquiryinfo->message}}</dd>

                                        <dt class="col-4 col-sm-4">Status</dt>
                                        <dd class="col-8 col-sm-8"> 
                                            @if($enquiryinfo->status==0)
                                            <span class="badge badge-warning" style="cursor: pointer;">Unread</span>
                                            @elseif($enquiryinfo->status==1)
                                            <span class="badge badge-success" style="cursor: pointer;">Read</span>
                                            @else
                                            <span class="badge badge-danger" style="cursor: pointer;">N.A.</span>
                                            @endif 
                                        </dd>

                                    
                       </dl>
                   </div>
               </div>
               <!-- end of row -->
                                           </div>
                                           <!-- end of general info -->
                                       </div>
                                       <!-- end of col-lg-12 -->
                                   </div>
                               </div>
                           </div>
                           <!-- end of card-block -->
                       </div>
                </div> 
            </div>
        </div>
    </div>
    <!-- Row end -->
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
	$('.carousel').carousel({
  interval: 2000
})
</script>

@endsection