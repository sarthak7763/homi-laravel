@extends('admin::layouts.master')
@section('title', 'Property List')
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
                                    <h4>Property List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-list')}}">Property List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->hasRole('Admin'))                            
                        <a class="btn btn-primary btn-round" href="{{route('admin-property-add')}}">Add Property</a>
                   
                    <button type="button" class="btn btn-primary btn-round" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Apply Filters</button>

                   @endif

                     
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
                     <div class="card my-1">
                        <div class="card-block collapse mt-3"  id="collapseExample">
                            <div class="row">
                                <div class="col-md-6">       
                                    <div class="form-group">
                                        <label><strong>Start Date <span class="text-danger"></span></strong></label>
                                        <div class="controls">
                                            <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> 
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Property Type</strong></label>
                                        <select name="property_type" id='property_type' class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="1">Rent</option>
                                            <option value="2">Sell</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Property Category</strong></label>
                                        <select name="property_category" id='property_category' class="form-control">
                                           
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Publish Status :</strong></label>
                                        <select name="status" id='status' class="form-control">
                                            <option value="">Select</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div>
                                </div>                        

                                 <div class="col-md-6">        
                                    <div class="form-group">
                                        <label><strong>Property Location</strong></label>
                                            <input type="text" name="property_location" id="property_location" class="form-control" placeholder="Property Location"> 
                                            <div class="help-block">
                                            </div>                                     
                                    </div>
                                </div>
                            </div>
                            <button class="resetFilter btn btn-inverse" type="button">Reset</button> 
                        </div>
                    </div>
                  
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="propertytable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                    <thead>
                                    <tr class="table-primary">
                                        <th>S.No</th>
                                        <th>Property Pic</th>
                                        <th>Title </th>
                                        <th>Publish Status</th>
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
<!-- Button trigger modal -->
<div class="modal fade" id="escrow_Congratulation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="card">
           <div class="card-body text-center"> 
                <img src="https://img.icons8.com/bubbles/200/000000/trophy.png">
                <div class="escrow_body_message"></div> 
                <button class="btn btn-out btn-square" data-dismiss="modal" aria-label="Close">CONTINUE</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@endsection   
@section('js')
<script type="text/javascript">

    // set a common class for both id
    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd'
    });

function table_ajax(){
      var i = 1;
      var table = $('#propertytable').DataTable({
        processing: true,
           serverSide: false,
            "bDestroy": true,
        ajax: {
            url: "{{ route('admin-property-list') }}",
            type: 'GET',
             data: function (d) {
                d.status = $('#status').val(),
                d.search = $('input[type="search"]').val(),
                d.start_date = $('#start_date').val(),
                d.end_date = $('#end_date').val(),
                d.base_price_from=$('#base_price_from').val(),
                d.base_price_to=$('#base_price_to').val(),
                d.property_location=$('#property_location').val(),
                d.property_type=$('#property_type').val();

            }
        },
        columns: [
          //  {data: 'DT_RowIndex', orderable: false,
                    //searchable: false},
                       {
                    "render": function() {
                        return i++;
                    }
                },

            {data:"image","bSortable": false,
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
              {data:"title",
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
                // "className": "action",
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
  
        //  $.fn.dataTable.ext.search.push(
        //     function( settings, data, dataIndex ) {
        //         console.log('data');
        //         var min = $('#start_date').datepicker('getDate');
        //         var max = $('#end_date').datepicker('getDate');
        //         var startDate = new Date(data[5]);
        //         if (min == null && max == null) return true;
        //         if (min == null && startDate <= max) return true;
        //         if (max == null && startDate >= min) return true;
        //         if (startDate <= max && startDate >= min) return true;
        //         return false;
        //     }
        // );

        $('#status').change(function(){
           // table.draw();
           table_ajax();
        });
     
        // $('#delete_status').change(function(){
        //     table.draw();
        // });
        
        $('#start_date, #end_date').change( function() {
           // table.draw();
            table_ajax();
        });

       $('#state, #city').change( function() {
           // table.draw();
           table_ajax();
        });

        $('#escrow_status').change( function() {
           // table.draw();
           table_ajax();
        });

         $('#property_type').change( function() {
           // table.draw();
           table_ajax();
        });

        $('#base_price_from, #base_price_to').keyup( function() {
          
           table_ajax();
        });

          $('#property_location').keyup( function() {
          
           table_ajax();
        });

        
         
    // $('#btnFiterSubmitSearch').click(function(){
    //    table.draw();
    // }); 

$(document).on('click', '.badge_status_change', function(e)
{ 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-property-status-update') }}";
        
        if(status_class == "badge badge-danger badge_status_change")
        {
            var newClass = "badge badge-success badge_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_status_change";
            var status = 'Inactive';
        }
       var title ='Are you sure to '+status+' this property ?';
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
                data: {_token: "{{ csrf_token() }}",property_id:id},
                dataType: "json",
                 beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
                success: function (response){
                    if(response.status=="success"){
                        change_btn.html(status);
                        change_btn.removeClass(status_class).addClass(newClass);
                        if(status=="Active"){
                             toastr.success("Property status active successfully");
                        }else{
                              toastr.error("Property status inactive successfully");
                        }

                     }else{
                            toastr.error(response.message);
                        }
                   
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "property is not change", "error");
        // }
        });         
}); 


$(document).on('click', '.badge_publish_status_change', function(e)
{ 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var url = "{{ route('admin-property-publish-status-update') }}";
        
       var title ='Are you sure to publish this property ?';
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
                data: {_token: "{{ csrf_token() }}",property_id:id},
                dataType: "json",
                 beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
                success: function (response){
                    if(response.status=="success"){
                        toastr.success("Property published successfully");
                        window.location.reload();

                 }else{
                        toastr.error("Something went wrong.");
                    }
                   
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "property is not change", "error");
        // }
        });         
}); 


$(document).on('click', '.badge_delete_status_change', function(e)
{ 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-property-delete') }}";
        
        if(status_class == "badge badge-danger")
        {
            var newClass = "badge badge-success badge_delete_status_change";
            var status = 'Not Deleted';
        }else
        {
            var newClass = "badge badge-danger";
            var status = 'Deleted';
        }
       var title ='Are you sure to delete this property ?';
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
                data: {_token: "{{ csrf_token() }}",property_id:id},
                dataType: "json",
                 beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
                success: function (data){
                    table_ajax();
                    toastr.error("Property deleted successfully");
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "property is not change", "error");
        // }
        });         
});  

$('.resetFilter').on('click', function(){
        $("#status").val("").trigger( "change" );
        $("#state").val("").trigger( "change" );
        $("#city").html("");
        $('#start_date,#end_date').val(null);
        $('#base_price_from,#base_price_to').val(null);
        $('#property_location').val(null);
         $("#property_type").val("").trigger( "change" );
           $("#escrow_status").val("").trigger( "change" );
       table.draw();

    });
});

</script>
@endsection