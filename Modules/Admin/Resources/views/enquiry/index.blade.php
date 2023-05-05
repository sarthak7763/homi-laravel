@extends('admin::layouts.master')
@section('title', 'Feedback List')
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
                                    <h4>Feedback List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-enquiry-list')}}">Feedback List</a> </li>
                                    
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
            <div class="col-sm-12">
                <div class="card">
                               <!--  <div class="card-header">
                                    <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div>
                                </div> -->
                                <div class="card-block">
                                    <div class="data_table_main table-responsive dt-responsive">
                                        <table id="enquiryTable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Reason</th>
                                                    <th>Status</th>
                                                    <th>Feedback Date</th>
                                                    <th>Action</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody> <tr> <tr> </tbody>
                                        </table>
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
        <script type="text/javascript">
            $(document).ready(function() {
                var i=1;
                var table = $('#enquiryTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: "{{ route('admin-user-enquiry-list') }}",
                        error: function(res){
                            console.log(res);
                        }
                    },
                    columns: [
                    {
                        "render": function() {
                            return i++;
                        }
                    },

                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'mobile_no', name: 'mobile_no'},
                    {data: 'reason_type', name: 'reason_type'},


            // {data:"attachment",
            //     "mRender": function(data, type, full){
            //     return $("<div/>").html(data).text();
            //     }
            // },
            //   {data:"title",
            //   "className":"no-wrap",
            //     "mRender": function(data, type, full){
            //     return $("<div/>").html(data).text();
            //     }
            // },


            // {data: 'country'},
            // {data: 'state'},
            // {data: 'city'},
            {data:"status",
            "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
            }
        },
            //  {data:"delete_status",
            //     "mRender": function(data, type, full){
            //     return $("<div/>").html(data).text();
            //     }
            // },
            {data: 'created_at'},
            {'data':"action__","bSortable": false,
            "className": "action btn_modify",
            "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
            }
        },

        ],
    });


                $(document).on('click', '.badge_status_change', function(e)
                { 
                    var status_class = $(this).attr('class');
                    var id = $(this).attr('id');
                    var change_btn = $(this);
                    var url = "{{ route('admin-user-enquiry-status-update') }}";

                    if(status_class == "badge badge-danger badge_status_change")
                    {
                        var newClass = "badge badge-success badge_status_change";
                        var status = 'Active';
                    }else
                    {
                        var newClass = "badge badge-danger badge_status_change";
                        var status = 'Inactive';
                    }
                    var title ='Are you sure to '+status+' this enquiry ?';
                    e.preventDefault();      
                    swal({
                      title: title,
                      icon: "warning",
                      buttons: [
                      'No, cancel it!',
                      'Yes, I am sure!'
                      ],
                      dangerMode: true,
                  }).then(function(isConfirm) {
                      if(isConfirm){
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {_token: "{{ csrf_token() }}",id:id},
                            dataType: "json",
                            beforeSend: function(){
                                $("#loading").show();
                            },
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function (data){
                                change_btn.html(status);
                                change_btn.removeClass(status_class).addClass(newClass);
                            }         
                        })
                    } 
                    // else {
                    //     swal("Cancelled", "Feedback is not change:)", "error");
                    // }
                });         
              }); 


                $(document).on('click', '.badge_delete_status_change', function(e)
                { 
                    var status_class = $(this).attr('class');
                    var id = $(this).attr('id');
                    var change_btn = $(this);
                    var url = "{{ route('admin-user-enquiry-delete') }}";

                    if(status_class == "badge badge-danger")
                    {
                        var newClass = "badge badge-success badge_delete_status_change";
                        var status = 'Not Deleted';
                    }else
                    {
                        var newClass = "badge badge-danger";
                        var status = 'Deleted';
                    }
                    var title ='Are you sure to delete this enquiry ?';
                    e.preventDefault();      
                    swal({
                      title: title,
                      icon: "warning",
                      buttons: [
                      'No, cancel it!',
                      'Yes, I am sure!'
                      ],
                      dangerMode: true,
                  }).then(function(isConfirm) {
                      if(isConfirm){
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {_token: "{{ csrf_token() }}",id:id},
                            dataType: "json",
                            beforeSend: function(){
                                $("#loading").show();
                            },
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function (data){
                                change_btn.html(status);
                                change_btn.removeClass(status_class).addClass(newClass);
                            }         
                        })
                    } 
                    // else {
                    //     swal("Cancelled", "enquiry is not change:)", "error");
                    // }
                });         
              });   


            });

        </script>   
        @endsection