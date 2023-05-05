@extends('admin::layouts.master')
@section('title', 'Permission List')
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
                                    <h4>Permission List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-permission-list')}}">Permission List</a> </li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                      <a class="btn btn-primary btn-round" href="{{route('admin-add-permission')}}">Add Permission</a> 
                </div>
                <!-- Page-header end -->

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                   <!--  <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                                    <!-- <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div> -->
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
                                    <div class="dt-responsive table-responsive">
                                        <table id="dataTable" class="table table-bordered nowrap">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Permission Name </th>
                                                <th>Guard Name</th>
                                                <th>Controller</th>
                                               
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($permissions as $li)
                                            <tr>
                                            <td>{{$li->id}}</td>
                                            <td>{{$li->name}}</td>
                                            <td>{{$li->guard_name}}</td>
                                              <td>{{$li->controller}}</td>
                                            
                                            {{--<td><a href="{{route('admin-edit-role',$li->id)}}"><i class="fa fa-edit"></i></a></td>
                                            
                                            <tr>--}}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
    jQuery("#dataTable").DataTable();
</script>
@endsection