@extends('admin::layouts.master')
@section('title', 'FAQ List')
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
                                    <h4>FAQ List</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-faq-list')}}">FAQ List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-round" href="{{route('admin-faq-add')}}">Add FAQ</a>
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
                                           <label class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true" style="font-size: 19px; margin-top: -1px;">&times;</span>
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
                                       <span aria-hidden="true" style="font-size: 19px; margin-top: -1px;">&times;</span>
                                    </label>
                                    {{ $message }}
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="faqtable" class="table table table-styling table-bordered nowrap w-100">
                                <thead>
                                    <tr class="table-primary">
                                        <th>ID</th>
                                        <th>Question</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody><tr></tr></tbody>
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
        var table = $('#faqtable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('admin-faq-list') }}",
                error: function(res){
                    console.log(res);
                }
            },
            columns: [
            {data: 'DT_RowIndex'},
            {data: 'question'},

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

    $(document).on('click', '.badge_status_change', function(e) { 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-faq-status-update') }}";
        
        if(status_class == "badge badge-danger badge_status_change")
        {
            var newClass = "badge badge-success badge_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_status_change";
            var status = 'Inactive';
        }
        var title ='Are you sure to '+status+' this FAQ ?';
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
                        toastr.success("FAQ status active successfully");
                    }else{
                          toastr.error("FAQ status inactive successfully");
                    }
                 
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "FAQ is not change:)", "error");
        // }
    });         
  }); 



$(document).on('click', '.delete_status', function(e){ 
    var id = $(this).attr('data-id');
   
    var url = "{{ route('admin-faq-delete') }}";

    var title ='Are you sure to delete this FAQ ?';
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
                setTimeout(function () {
                   
                        location.reload(true);
                    
                    
                  }, 1000);
            },
            success: function (data){
                toastr.error("FAQ deleted successfully");
            }         
        })
    } 
    // else {
    //     swal("Cancelled", "FAQ is not deleted:)", "error");
    // }
});         
});  
</script>   
@endsection