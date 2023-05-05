@extends('admin::layouts.master')
@section('title', 'Mail Template View')
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
                                    <h4>Mail Template View</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-mail-template-list')}}">Mail Template List</a> </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-mail-template-show',[$mail->id])}}">Mail Template View</a> </li>
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
                                    Mail Name
                                </div>
                                <div class="col-md-9">
                                    {{ @$mail->name}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    Mail Subject
                                </div>
                                <div class="col-md-9">
                                    {{ @$mail->subject}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    Mail Body
                                </div>
                                <div class="col-md-9">
                                    {!! @$mail->body !!}
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
<script type="text/javascript"> 
</script>
@endsection