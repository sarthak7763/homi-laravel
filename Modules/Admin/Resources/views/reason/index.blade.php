@extends('admin::layouts.master')
@section('title', 'Reason List')
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
                                    <h4>Feedback Reason List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-reason-list')}}">Reason List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('admin-reason-add')}}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Reason</a>
                </div>
                <!-- Page-header end -->
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
                                </div>  -->
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
                        <div class="dt-responsive table-responsive">
                            <table id="statetable" class="table table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name </th>
                                      <!--   <th>Type </th>  -->
                                        <!--  <th>Country</th> -->
                                        <th>Status</th>
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
        var table = $('#statetable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('admin-reason-list') }}",
                error: function(res){
                    console.log(res);
                }
            },
            columns: [
            {data: 'DT_RowIndex'},
            {data: 'name'},
            //{data: 'type'},
            // {data: 'country'},
            {data:"status",
            "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
            }
        },
        {'data':"action__","bSortable": false,
                // "className": "action",
                "className": "btn_modify",
                "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                }
            },

            ],
        });
    });


    $(document).on('click', '.badge_status_change', function(e)
    { 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-reason-status-update') }}";
        
        if(status_class == "badge badge-danger badge_status_change")
        {
            var newClass = "badge badge-success badge_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_status_change";
            var status = 'Inactive';
        }
        var title ='Are you sure to '+status+' this reason ?';
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
                    if(status=="Active"){
                            toastr.success("Reason status active successfully");
                        }else{
                              toastr.error("Reason status inactive successfully");
                        }
                    
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "Reason is not change:)", "error");
        // }
    });         
  }); 
</script>   
@endsection