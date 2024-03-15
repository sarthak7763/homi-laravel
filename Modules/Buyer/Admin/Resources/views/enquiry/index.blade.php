@extends('admin::layouts.master')
@section('title', 'Enquiry List')
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
                                    <h4>Enquiry List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-enquiry-list')}}">Enquiry List</a> </li>
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
                                  
                                    <div class="dt-responsive table-responsive">
                                        <table id="categorytable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                            <thead>
                                            <tr class="table-primary">
                                                <th>S.No</th>
                                                <th>Name</th>
                                                <th>Email</th>
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
  dateFormat: 'yy-mm-dd'
});


    function table_ajax(){
        var i = 1;
        var table = $('#categorytable').DataTable({
            processing: true,
            serverSide: false,
            "bDestroy": true,
           //  pageLength:20,
           // render: true,
            ajax: {
                url: "{{ route('admin-enquiry-list') }}",
                 type: 'GET'
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
           
        });

    $(document).on('click', '.badge_enquiry_status_change', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('id');
            var change_btn = $(this);
            var url = "{{ route('admin-enquiry-status-update') }}";
            
            if(status_class == "badge badge-danger badge_enquiry_status_change")
            {
                var newClass = "badge badge-success badge_enquiry_status_change";
                var status = 'Resolved';
            }else
            {
                var newClass = "badge badge-danger badge_enquiry_status_change";
                var status = 'Unresolved';
            }

           var title ='Are you sure to '+status+' this Enquiry ?';
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
                            if(status=="Read"){
                             toastr.success("Read status active successfully");
                            }else{
                                  toastr.error("Read status inactive successfully");
                            }
                            
                        }
                       
                    }         
                })
            } 
            // else {
            //     swal("Cancelled", "Read status not change", "error");
            // }
            });         
    }); 


    $(document).on('click', '.badge_delete_change', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('id');
            var change_btn = $(this);
            var url = "{{ route('admin-category-delete') }}";
            
            if(status_class == "badge badge-danger")
            {
                var newClass = "badge badge-success badge_delete_category_status_change";
                var status = 'Not Deleted';
            }else
            {
                var newClass = "badge badge-danger";
                var status = 'Deleted';
            }
           var title ='Are you sure to delete this Category ?';
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
                        toastr.error('Category deleted successfully!');
                       // change_btn.html(status);
                        //change_btn.removeClass(status_class).addClass(newClass);
                    }         
                })
            } 
            // else {
            //     swal("Cancelled", "Category not deleted", "error");
            // }
            });         
    });   





</script>   
@endsection  