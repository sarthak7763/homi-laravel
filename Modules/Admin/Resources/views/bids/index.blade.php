@extends('admin::layouts.master')
@section('title', 'Bids')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header mb-0">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4> Bids</h4>
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
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-bid-list')}}">Bids</a>
                                    </li>
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
                       <label class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 19px;margin-top: -1px;">&times;</span>
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
          <button type="button" class="btn btn-primary btn-round mb-4" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Apply Filters</button>

          <div class="card my-1">
            <div class="card-block collapse mt-3" id="collapseExample">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Bidder Name</strong></label>
                            <select id="bidder_id" class="form-control">
                                <option value="">All Bidders</option>
                                @foreach($bidderList as $bli)
                                <option value="{{$bli->bidder_id}}">#{{$bli->bidder_id}}-{{$bli->BidderInfo->name}}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Property Name</strong></label>
                            <select id="property_id" class="form-control" onchange="getMinMaxBidPrice()">
                                <option value="">All Property</option>
                                @foreach($propertyList as $pli)
                                <option value="{{$pli->property_id}}">{{$pli->BidPropertyInfo->property_code}}-{{$pli->BidPropertyInfo->title}}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Property Offers</strong></label>
                            <select id="property_offer" class="form-control">
                                <option value="">All Property Offer</option>
                                @foreach($offerList as $oli)
                                <option value="{{$oli->id}}">
                                    {{date('d M, Y', strtotime($oli->date_start))}}, {{date('g:i a', strtotime($oli->time_start));}} To {{date('d M, Y', strtotime($oli->date_end))}}, {{date('g:i a', strtotime($oli->time_end))}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Bid Status :</strong></label>
                                <select id='bid_status'  class="form-control">
                                    <option value="">All Bid Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Awarded">Awarded</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Blocked">Blocked</option>                                           
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">       
                            <div class="form-group">
                                <label><strong>Bid Start Date <span class="text-danger"></span></strong></label>
                                <div class="controls">
                                    <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> 
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">        
                            <div class="form-group">
                                <label><strong>Bid End Date <span class="text-danger"></span></strong></label>
                                <div class="controls">
                                    <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> 
                                    <div class="help-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Status :</strong></label>
                                <select id='status' class="form-control">
                                    <option value="">Both Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Bid type :</strong></label>
                                <select id='bid_type' class="form-control">
                                    <option value="">Both </option>
                                    <option value="Old">Old</option>
                                    <option value="New">New</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">       
                            <div class="form-group">
                                <label><strong>Bid Price From <span class="text-danger"></span></strong></label>
                                <div class="controls">
                                    <input type="text" name="bid_price_from" id="bid_price_from" class="form-control" placeholder="Please select bid price start from" value="{{$getMin}}"> 
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">        
                            <div class="form-group">
                                <label><strong>Bid Price To <span class="text-danger"></span></strong></label>
                                <div class="controls">
                                    <input type="text" name="bid_price_to" id="bid_price_to" class="form-control" placeholder="Please select bid price to" value="{{$getMax}}"> 
                                    <div class="help-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="resetFilter btn btn-inverse" type="button">Reset</button> 
                </div>
            </div>
            <div class="card">
                       <div class="card-header">
                            <span>Active: New bid added by bidders (Default Status)<br>
                            Awarded: Highest Selected Price Bid By Admin (Approved Bid) <br>
                            Rejected: If something wrong with the bid Admin can reject it. Rejected Bid converted in Active Bid when bidder update bid price before offer expire.<br>
                            Cancelled: All other bids of same property cancelled when a bid awarded. <br>
                            
                            Blocked: when sold property cancelled because of some reason, Bid blocked and bidder cannot place bid on same property and escrow set as Cancelled.<br>

                            Closed: when property sold to bidder, Bid Closed and escrow set as Sold.<hr>
                            </span> 
                           
                        </div> 
                        <div class="card-block">
                            <div class="data_table_main table-responsive dt-responsive">
                                <table id="bidTable" class="table table table-styling table-bordered nowrap" style="width:100%"> 
                                    <thead>
                                        <tr class="table-primary">
                                            <th>S.No</th>
                                            <th>Bidder Name</th>
                                            <th>Bid Price</th>
                                            <th>Property</th>
                                            <th>Bid Status</th>
                                            <th>Bid Type</th>
                                            <th>Status</th>
                                            <th>Bid Date </th>
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
            function getMinMaxBidPrice(){
                $('#bid_price_from').val('');
                $('#bid_price_to').val('');
                var property_id =$("#property_id").val();         
                $.ajax({
                    type: "POST",
                    data:{_token: "{{ csrf_token() }}",property_id:property_id}, 
                    url: "{{ route('admin-ajax-get-min-max-bid-price') }}",
                    beforeSend: function(){
                        $("#loading").show();
                    },
                    complete: function(){
                        $("#loading").hide();
                    },
                    success:function(result){

                        if(result) {
                            $('#bid_price_from').val(result.min);
                            $('#bid_price_to').val(result.max);
                        }
                        else {
                            $('#bid_price_from').val('');
                            $('#bid_price_to').val('');
                        }
                    }
                });
            }
            function table_ajax(){
                var i = 1;
                var table = $('#bidTable').DataTable({

                    processing: true,
                    serverSide: false,
                    "bDestroy": true,
                    ajax: {
                        url: "{{ route('admin-bid-list') }}",
                        type: 'GET',
                        data: function (d) {
                            d.status = $('#status').val(),
            // d.delete_status = $('#delete_status').val(),
            d.search = $('input[type="search"]').val(),
            d.start_date = $('#start_date').val(),
            d.end_date = $('#end_date').val(),
            d.bid_price_from = $('#bid_price_from').val(),
            d.bid_price_to = $('#bid_price_to').val(),
            d.bid_status=$('#bid_status').val(),
            d.property_id=$('#property_id').val(),
            d.property_offer=$('#property_offer').val(),
            d.bidder_id=$('#bidder_id').val();
            d.bid_type=$('#bid_type').val();

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


                    {data:"bidder_name", 
                    "mRender": function(data, type, full){
                        return $("<div/>").html(data).text();
                    }
                },

                {data: 'bid_price'},
                {data:"property_name", 
                "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                }
            },
            @if(Auth::user()->hasRole('sub-admin') && auth()->user()->can('admin-bid-status-update'))
            {
                data:"bid_status", "bSortable": false,"className":"dropdown",
                "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                }

            },
            @else
            {data:"bid_status", "bSortable": false,"className":"dropdown",
            "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
            }

        },
        @endif
        {data:"bid_type", 
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
{'data':"action__", "bSortable": false,
"className": "action btn_modify",
"mRender": function(data, type, full){
    return $("<div/>").html(data).text();
}
},

],
});

            }

            $('.resetFilter').on('click', function(){
                $("#status").val("").trigger( "change" );
                $("#bid_status").val("").trigger( "change" );
                $("#property_id").val("").trigger( "change" );
                $("#bidder_id").val("").trigger( "change" );
                $("#bid_price_from").val("");
                $("#bid_price_to").val("");
                $("#property_offer").val("").trigger( "change" );
                $("#bid_type").val("").trigger( "change" );
                $('#start_date,#end_date').val(null);
                table.draw();
            }); 

            $(document).ready(function() {
                $(".js-example-placeholder-multiple").select2({
                    placeholder: "Select"
                });
                table_ajax();

                $('#status').change(function(){
           // table.draw();
           table_ajax();
       });

               
                $('#bid_type').change(function(){
                   table_ajax();
               });

                $('#start_date, #end_date').change( function() {
           // table.draw();
           table_ajax();
       });

                $('#bidder_id, #property_id, #bid_status').change( function() {
           // table.draw();
           table_ajax();
       });

                $('#bid_price_from, #bid_price_to').keyup( function() {
           // table.draw();
           table_ajax();
       });

                $('#property_offer').change( function() {
           // table.draw();
           table_ajax();
       });





                $(document).on('click', '.badge_status_change', function(e)
                { 
                    var status_class = $(this).attr('class');
                    var id = $(this).attr('id');
                    var change_btn = $(this);
                    var url = "{{ route('admin-bid-enable-disable') }}";

                    if(status_class == "badge badge-danger badge_status_change")
                    {
                        var newClass = "badge badge-success badge_status_change";
                        var status = 'Active';
                    }else
                    {
                        var newClass = "badge badge-danger badge_status_change";
                        var status = 'Inactive';
                    }
                    var title ='Are you sure to '+status+' this bid ?';
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
                                     toastr.success("Bid status active successfully");
                                 }else{
                                      toastr.error("Bid status inactive successfully");
                                 }
                               
                            }         
                        })
                    } 
                    // else {
                    //     swal("Cancelled", "Bids is not change", "error");
                    // }
                });         
              }); 


                $(document).on('click', '.badge_delete_status_change', function(e)
                { 

                    var this_id = $(this).attr('id');
                    var url = "{{ route('admin-bid-delete') }}";

                    var title ='Are you sure to delete this Offer ?';
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
                            data: {_token: '{{ csrf_token() }}', id: this_id},
                            dataType: "json",
                            beforeSend: function(){
                                $("#loading").show();
                            },
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function (response){
                                if (response.status == "200") {
                                    jQuery('.rem_row_' + this_id).remove();
                                    swal("Done!", "Row deleted succesfully!", "success");
                                    toastr.error("Bid deleted successfully");
                                } else {
                                    swal("Error deleting!", "Please try again", "error");
                                }
                            }         
                        })
                    } 
                    // else {
                    //     swal("Cancelled", "Bid is not change", "error");
                    // }
                });         
              });   

                $(document).on('click', '.bid_status_btn', function(e)
                { 
                    var idss = $(this).data('id');
                    var statuss = $(this).data('status');

                    var url = "{{ route('admin-bid-status-update') }}";

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {_token: "{{ csrf_token() }}",id:idss,status:statuss},
                        dataType: "json",
                        beforeSend: function(){
                            $("#loading").show();
                        },
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function (data){
                            if(statuss=="Awarded"){
                                 toastr.success("Bid Awarded Successfully");
                            }
                            if(statuss=="Rejected"){
                                 toastr.error("Bid Rejected Successfully");
                            }
                       
                        table_ajax();
                     }         
                 })

                }); 


            });
        </script>   
        @endsection