@extends('admin::layouts.master')
@section('title', 'Complaint List')
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
                                    <h4>Complaint List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-complaint-list')}}">Complaint List</a> </li>
                                    
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
                                        <table id="complaintTable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Complaint No.</th>
                                                    <th>Name</th>
                                                    <!-- <th>Attachment</th> -->
                                                  <!--   <th>Title</th> -->
                                                    <th>Complaint Status</th>
                                                    <th>Status</th>
                                                  <!--   <th>Delete Status</th> -->
                                                    <th>Complaint Date</th>
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

        <div class="modal fade" id="Modal-overflow" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Complaint</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <div class="info">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection   
@section('js')
<script type="text/javascript">
$(document).on('click', '.openModal', function(e){
    var id = $(this).attr('data-id');
    var url= "{{ route('admin-user-complaint-detail') }}";
    $.ajax({
        type: "POST",
        url: url,
        data: {_token: "{{ csrf_token() }}",id:id},
        dataType: "json",
        success:function(result){
        $(".info").html('<h5 class="font-header">'+result.data.title+'</h5><img src="'+result.data.attachment+'" alt="'+result.data.attachment+'" class="img img-fluid" width="200px" height="200px"><div class="overflow-container"><p>'+result.data.description+'</p></div>');
    }});
});


function table_ajax(){
      var i = 1;
     var table = $('#complaintTable').DataTable({
        processing: true,
           serverSide: false,
            "bDestroy": true,
        ajax: {
             url: "{{ route('admin-user-complaint-list') }}",
            type: 'GET',
            //  data: function (d) {
            //     d.status = $('#status').val(),
            //   //  d.delete_status = $('#delete_status').val(),
            //     d.search = $('input[type="search"]').val(),
            //     d.start_date = $('#start_date').val(),
            //     d.end_date = $('#end_date').val(),
            //    // d.country=$('#country').val(),
            //     d.state=$('#state').val(),
            //     d.city=$('#city').val();
              
            // }
        },
        columns: [
          //  {data: 'DT_RowIndex', orderable: false,
                    //searchable: false},
                       {
                    "render": function() {
                        return i++;
                    }
                },

            
            {data: 'complaint_no'},
            
              {data:"add_by","className":"dropdown",
            "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
               
            },
               {data:"complaint_status","className":"dropdown",
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
                "className": "action btn_modify",
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

$(document).on('click', '.complaint_status_btn', function(e)
{ 
    var id = $(this).data('id');
    var status = $(this).data('status');
  
    var url = "{{ route('admin-change-users-complaint-status') }}";
    
    $.ajax({
        type: "POST",
        url: url,
        data: {_token: "{{ csrf_token() }}",id:id,status:status},
        dataType: "json",
        beforeSend: function(){
            $("#loading").show();
        },
        complete: function(){
            $("#loading").hide();
        },
        success: function (data){
         table_ajax(); 
        }         
    })
            
}); 
</script>   
@endsection