@extends('admin::layouts.master')
@section('title', 'Sms Template View')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header my-2">
                    <div class="row align-items-end">
                        <div class="col-lg-4">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Sms Template View</h4>
                                    <span></span>

                                </div>

                            </div>

                        </div>
                        <div class="col-lg-8">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                     <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-sms-template-list')}}">Sms Template List</a> </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-sms-template-show',[$sms->id])}}">Sms Template View</a> </li>
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
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    Sms Name
                                </div>
                                <div class="col-md-9">
                                    {{ @$sms->name}}
                                </div>
                            </div>
                             <div class="row mb-2">
                                <div class="col-md-3">
                                    Sms Body
                                </div>
                                <div class="col-md-9">
                                    {!! $sms->body !!}
                                </div>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
        </div>
        <div id="styleSelector">
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript"> 
</script>
@endsection