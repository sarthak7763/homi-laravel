@extends('admin::layouts.master')
@section('title', 'Booking List')
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
                                    <h4>Booking List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-booking-list')}}">Booking List</a> </li>
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
                                                <th>Booking ID </th>
                                                <th>Property Title</th>
                                                <th>Booking Amount</th>
                                                <th>Payment Mode</th>
                                                <th>Payment Status</th>
                                                <th>Booking Status</th>
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
                url: "{{ route('admin-booking-list') }}",
                 type: 'GET'
            },
            columns: [
            {
                    "render": function() {
                        return i++;
                    }
                },
                   {data:"booking_id",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data:"property_title",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data:"booking_amount",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data:"payment_mode",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data:"payment_status",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data:"booking_status",
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