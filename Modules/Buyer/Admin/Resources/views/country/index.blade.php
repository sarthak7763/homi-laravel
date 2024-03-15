@extends('admin::layouts.master')
@section('title', 'Country List')
@section('content')
 
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header my-0">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Country List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-country-list')}}">Country List</a> </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->
                 {{--<a class="btn btn-primary btn-round" href="{{route('admin-country-add')}}">Add Country</a>--}}
                   
                    
                <div class="page-body mt-2">
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
                            <table id="countrytable" class="table table-bordered nowrap" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name </th>
                                    <th>Abbr </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                </tr>
                                </tbody>
                            </table>
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
    var table = $('#countrytable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('admin-country-list') }}",
            error: function(res){
                console.log(res);
            }
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'name'},
            {data: 'sortname'},
            {data:"status",
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
            {'data':"action__","bSortable": false,
                    // "className": "action",
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
        var url = "{{ route('admin-country-status-update') }}";
        
        if(status_class == "badge badge-danger badge_status_change")
        {
            var newClass = "badge badge-success badge_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_status_change";
            var status = 'Block';
        }
       var title ='Are you sure to '+status+' this country ?';
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
                    toastr.success("Country status updated successfully");
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "country is not change:)", "error");
        // }
        });         
}); 


</script>   
@endsection