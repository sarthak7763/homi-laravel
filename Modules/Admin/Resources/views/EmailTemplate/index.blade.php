@extends('admin::layouts.master')
@section('title', 'Email Templates')

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
                                    <h4>Manage Email Templates</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                     <li class="breadcrumb-item">
                                        <a href=""> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-email-template-list')}}">Email Templates List</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-round" href="{{route('admin-email-template-add')}}">Add Email Templates</a>
                   
                    </div>
                <!-- Page-header end -->
                <div class="page-body">
                   
                            <div class="card my-1">
                                <div class="card-block collapse mt-3"  id="collapseExample">
                                    <div class="row">       
                            </div>
                            <button class="resetFilter btn btn-inverse" type="button">Reset</button>          
                                </div>
                            </div>
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
       
                <div class="dt-responsive table-responsive">
                                        <table id="datatable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                            <thead>
                                            <tr class="table-primary">
                                                <th>S.No</th>
                                                <th>Name</th>
                                                <th>Subject</th>
                                                <!-- <th>Message</th> -->
                                                <th>Email Type</th>
                                               <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            <tr>
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

@endsection  
@section('js')
<script type="text/javascript">
  $(function () {
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: false,
            responsive: false,
            autoWidth: false,
            scrollCollapse: true,
            ajax: {
            url: "{{ route('admin-email-template-list') }}",
            type: "GET"
            },
            
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
           
            {data: 'name', name: 'name'},
            {data: 'subject', name: 'subject'},
            // {data: 'message', name: 'message'},
            {data: 'email type', name: 'email type'},
            {data: 'action', name: 'action' , orderable: false, searchable: false},
        ]
        });
    });         

     


</script>   
@endsection


