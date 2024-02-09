@extends('admin::layouts.master')
@section('title', 'Property Owners List')
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
                                    <h4>Property Owners List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-propertyOwner-list')}}">Property Owners List</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-round" href="{{route('admin-propertyOwner-add')}}">Add Property Owner</a>
                   
                    <button type="button" class="btn btn-primary btn-round" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Apply Filters</button>
                   
                </div>
                <!-- Page-header end -->
                <div class="page-body">
                   
                            <div class="card my-1">
                                <div class="card-block collapse mt-3"  id="collapseExample">
                                    <div class="row">       
                                       
                        <div class="col-md-6">       
                            <div class="form-group">
                                <label><strong>Registration Start From <span class="text-danger"></span></strong></label>
                                <div class="controls">
                                    <input type="text" name="start_date" id="start_date" class="form-control datepicker" placeholder="Please select start date"> 
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">        
                            <div class="form-group">
                                <label><strong>To Date <span class="text-danger"></span></strong></label>
                                <div class="controls">
                                    <input type="text" name="end_date" id="end_date" class="form-control datepicker" placeholder="Please select end date"> 
                                    <div class="help-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                                       
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Status :</strong></label>
                                                <select id='status'  class="form-control">
                                                    <option value="">All</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                       {{--  <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Verify Status:</strong></label>
                                                <select id='email_verified'  class="form-control">
                                                    <option value="">All</option>
                                                    <option value="1">Verified</option>
                                                    <option value="0">Not Verified</option>
                                                </select>
                                            </div>
                                        </div>--}}
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
                                        <table id="usertable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                            <thead>
                                            <tr class="table-primary">
                                                <th>S.No</th>
                                                <th>Name </th>
                                                <th>Email</th>
                                                <th>Email Verified</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
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

$('.datepicker').datepicker({
  dateFormat: 'dd/mm/yy'
});


    function table_ajax(){
        var i = 1;
        var table = $('#usertable').DataTable({
            processing: true,
            serverSide: false,
            "bDestroy": true,
           //  pageLength:20,
           // render: true,
            ajax: {
                url: "{{ route('admin-propertyOwner-list') }}",
                 type: 'GET',
                 data: function (d) {
                    d.status = $('#status').val(),
                    d.start_date = $('#start_date').val(),
                    d.end_date = $('#end_date').val();        
                }
            },
            columns: [
            {
                    "render": function() {
                        return i++;
                    }
                },
                   {data:"name",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
               {data:"email",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data:"email_verified",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data:"status",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data: 'created_at'},
                {'data':"action__","bSortable": false,
                     //"className": "action",
                     "className": "btn_modify",
                     "mRender": function(data, type, full){
                        return $("<div/>").html(data).text();
                        }
                    },
               
            ],
        });
    }


    $(document).ready(function() {
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select"
        });

        table_ajax();

        $('#status').change(function(){
            table_ajax();
        });
     
        $('#delete_status').change(function(){
            table_ajax();
        });

        //   $('#email_verified').change(function(){
        //     //table.draw();
        //     table_ajax();
        // });

           
        });
        
      $('#start_date, #end_date').change( function() {
            //table.draw();
            table_ajax();
        });

        $('.resetFilter').on('click', function(){
            $("#status").val("").trigger( "change" );
            // $("#email_verified").val("").trigger( "change" );
           $('#start_date,#end_date').val(null); 
           //table.draw();
           table_ajax();

        });

         

    $(document).on('click', '.badge_status_change', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('id');
            var change_btn = $(this);
            var url = "{{ route('admin-propertyOwner-status-update') }}";
            
            if(status_class == "badge badge-danger badge_status_change")
            {
                var newClass = "badge badge-success badge_status_change";
                var status = 'Active';
            }else
            {
                var newClass = "badge badge-danger badge_status_change";
                var status = 'Inactive';
            }

           var title ='Are you sure to '+status+' this property owner ?';
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
                        if(data.success==1){
                            change_btn.html(status);
                            change_btn.removeClass(status_class).addClass(newClass);
                            if(status=="Active"){
                             toastr.success("Property Owner status active successfully");
                            }else{
                                  toastr.error("Property Owner status inactive successfully");
                            }
                            
                        }
                       
                    }         
                })
            } 
            // else {
            //     swal("Cancelled", "User status not change", "error");
            // }
            });         
    }); 


    $(document).on('click', '.badge_email_status_change', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('id');
            
            var change_btn = $(this);
            var url = "{{ route('admin-propertyOwner-email-status-update') }}";
            
            if(status_class == "badge badge-danger badge_email_status_change")
            {
                var newClass = "badge badge-success badge_email_status_change";
                var status = 'Verified';
            }else
            {
                var newClass = "badge badge-danger badge_email_status_change";
                var status = 'Inverified';
            }
           var title ='Are you sure to '+status+' this Property Owner ?';
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
                        if(data.success==1){
                            change_btn.html(status);
                            change_btn.removeClass(status_class).addClass(newClass);
                            if(status=="Active"){
                             toastr.success("Property Owner verified successfully");
                            }else{
                                  toastr.error("Property Owner not verified successfully");
                            }
                            
                        }
                       
                    }         
                })
            } 
            // else {
            //     swal("Cancelled", "User status not change", "error");
            // }
            });         
    });


    $(document).on('click', '.badge_delete_status_change', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('id');
            var change_btn = $(this);
            var url = "{{ route('admin-propertyOwner-delete') }}";
            
            if(status_class == "badge badge-danger")
            {
                var newClass = "badge badge-success badge_delete_status_change";
                var status = 'Not Deleted';
            }else
            {
                var newClass = "badge badge-danger";
                var status = 'Deleted';
            }
           var title ='Are you sure to delete this property Owner ?';
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
                       table_ajax();
                        toastr.error('Proper Owner deleted successfully!');
                       // change_btn.html(status);
                        //change_btn.removeClass(status_class).addClass(newClass);
                    }         
                })
            } 
            // else {
            //     swal("Cancelled", "User not deleted", "error");
            // }
            });         
    });  
    
    






    $(document).on('click','.status_change', function(e)
    { 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
         var url = "{{ route('admin-propertyowner-pending-status-change')}}";
            
            if(status_class == "badge badge-warning")
            {
                var newClass = "badge badge-success badge_status_change";
                var status = 'Active';
                
            }else
            {
                var newClass = "badge badge-warning";
                var status = 'Pending';
            }


            var title ='Are you sure to '+status+' this property owner ?';
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
                        if(data.success==1){
                           toastr.success("Property Owner status active successfully");
                           window.location.reload();
                            
                        }

                    }         
                })
            } 
           
            }); 

        });     

</script>   
@endsection