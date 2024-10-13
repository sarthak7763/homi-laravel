@extends('admin::layouts.master')
@section('title', 'City List')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-6">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>City List</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-city-add')}}">City List</a> </li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-round" href="{{route('admin-city-add')}}">Add City</a>                  
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <!-- <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div> -->

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

                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="citytable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                            <thead>
                                            <tr class="table-primary">
                                                <th>ID</th>
                                                <th>Name </th>
                                                <th>State</th>
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
        </div>
    </div>
</div>
@endsection   
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#citytable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('admin-city-list') }}",
            error: function(res){
                console.log(res);
            }
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'name'},
            {data: 'state'},
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

 
$(document).on('click', '.badge_status_change', function(e){ 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-city-status-update') }}";
        
        if(status_class == "badge badge-danger badge_status_change")
        {
            var newClass = "badge badge-success badge_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_status_change";
            var status = 'Inactive';
        }
       var title ='Are you sure to '+status+' this city ?';
        e.preventDefault();      
        swal({
          title: title,
          text:"If you disbale this city, All properties disabled related to this city.",
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
                        toastr.success("City status active successfully");
                    }else{
                          toastr.error("City status inactive successfully");
                    }
                    
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "City is not change:)", "error");
        // }
    });         
}); 


$(document).on('click', '.badge_delete_status_change', function(e){ 
    var id = $(this).attr('data-id');
    var change_btn = $(this);
    var url = "{{ route('admin-city-delete') }}";

    var title ='Are you sure to delete this City ?';
    e.preventDefault();      
    swal({
      title: title,
    text: "All Properties under this city and all data related to this city removed and cannot be recovered in future.",
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
                setTimeout(function () {
                   
                        location.reload(true);
                    
                    
                  }, 1000);
            },
            success: function (data){

                toastr.error("City deleted successfully");
               
               
                
            }         
        })
    } else {
        swal("Cancelled", "City is not deleted:)", "error");
    }
});         
});   
</script>   
@endsection