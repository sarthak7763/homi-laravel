@extends('admin::layouts.master')
@section('title', 'Pending Property List')
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
                                    <h4>Pending Property List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-list')}}">Pending Property List</a> </li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                   
                    {{--<button type="button" class="btn btn-primary btn-round" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Apply Filters</button>--}}

                     
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
                    {{--  <div class="card my-1">
                        <div class="card-block collapse mt-3"  id="collapseExample">
                            <div class="row">
                                
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Deleted :</strong></label>
                                        <select id='delete_status' class="form-control" style="width: 200px">
                                            <option value="">Deleted</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
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
                                        <label><strong>End Date <span class="text-danger"></span></strong></label>
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
                                        <select id='status'  class="form-control">
                                            <option value="">Active</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Country</strong></label>
                                        <select id='country' class="form-control" style="width: 200px" onchange="getState()">
                                            <option value="">All Countries</option>
                                            @foreach($countryList as $cli)
                                            <option value="{{$cli->id}}">{{$cli->name}}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>State</strong></label>
                                        <select id="state" class="form-control" onchange="getCity()">
                                            <option value="">Select</option>
                                            @foreach($stateList as $cli)
                                            <option value="{{$cli->id}}">{{$cli->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>City</strong></label>
                                        <select id="city" multiple class="js-example-placeholder-multiple form-control">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="resetFilter btn btn-inverse" type="button">Reset</button> 
                        </div>
                    </div>--}}
                  
                    <div class="card">
                        <!-- <div class="card-header">
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
                            <div class="dt-responsive table-responsive">
                                <table id="propertytable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                    <thead>
                                    <tr class="table-primary">
                                        <th>S.No</th>
                                        <th>Property Pic</th>
                                        <th>Address </th>
                                        <th>Publish Status</th>
                                        <th>Escrow</th>
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

function getState(){
    $('#state').html('');
    $('#city').html('');
    var countryID =$("#country").val();         
    $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",country_id:countryID}, 
        url: "{{ route('admin-ajax-get-state-list') }}",
         beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
        success:function(result){
            if(result) {
                $('#state').html(result);
            }
            else {
                alert('error');
            }
        }
    });
}
function getCity(){
    var stateID =$("#state").val();         
    $.ajax({
        type: "POST",
        data: {_token: "{{ csrf_token() }}",state_id:stateID}, 
        url: "{{ route('admin-ajax-get-city-list') }}",
         beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
        success:function(result){
            if(result) {
                $('#city').html(result);
            }
            else {
                alert('error');
            }
        }
    });
}

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
            url: "{{ route('admin-pending-property-list') }}",
            type: 'GET',
             data: function (d) {
               // d.status = $('#status').val(),
              //  d.delete_status = $('#delete_status').val(),
                //d.search = $('input[type="search"]').val(),
                //d.start_date = $('#start_date').val(),
                //d.end_date = $('#end_date').val();
               // d.country=$('#country').val(),
              //  d.state=$('#state').val(),
             //   d.city=$('#city').val();
              
            }
        },
        columns: [
          // {
          //  data: 'DT_RowIndex', orderable: false,
          //           searchable: false},
                        {
                    "render": function() {
                         return i++;
                    }
                 },

            { data:"image","bSortable": false,
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
          
            { data: 'title'},
            // {data: 'country'},
            // {data: 'state'},
            // {data: 'city'},
            { data:"status",
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
             {data:"escrow_status",
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
            // {data:"delete_status",
            //     "mRender": function(data, type, full){
            //     return $("<div/>").html(data).text();
            //     }
            // },
            // {data: 'created_at'},
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

        // $('#status').change(function(){
        //    // table.draw();
        //    table_ajax();
        // });
     
        // // $('#delete_status').change(function(){
        // //     table.draw();
        // // });
        
        // $('#start_date, #end_date').change( function() {
        //    // table.draw();
        //     table_ajax();
        // });

       // $('#state, #city').change( function() {
       //     // table.draw();
       //     table_ajax();
       //  });
         
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
                    toastr.success("Property deleted successfully");
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

           table.draw();

        }); 

});

</script>   
@endsection