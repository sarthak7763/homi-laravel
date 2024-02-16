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
                                        <label><strong>Property Type</strong></label>
                                        <select name="property_type" id='property_type' class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="1">Renting</option>
                                            <option value="2">Buying</option>
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
                                        <label><strong>Property Condition</strong></label>
                                        <select name="property_condition" id='property_condition' class="form-control">
                                            <option value="">Select Condition</option>
                                            @foreach($condition as $list)
                                            <option value="{{$list->id}}">{{$list->name}}</option>
                                            @endforeach
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
                                        <th>Title </th>
                                        <th>Type</th>
                                        <th>Category</th>
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

    $('#property_type').on('change',function(){
    var property_type=$(this).val();
    var optionhtml='<option value="">Select price type</option>';
    if(property_type==2)
    {
      optionhtml+='<option value="1">PerSq.Ft</option><option value="2">Fixed </option><option value="3">Persq.yard</option>';
    }
    else{
      optionhtml+='<option value="4">Per night</option>';
    }

    $('#property_price_type').html(optionhtml);

     $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",property_type:property_type}, 
        url: "{{ route('admin-ajax-get-category-list') }}",
        dataType:'json',
        beforeSend: function(){
            $("#loading").show();
        },
        complete: function(){
            $("#loading").hide();
        },
        success:function(result){
            if(result.code==200) {
                $('#property_category').html(result.categoryhtml);
            }
            else {
                alert('error');
            }
        }
    });

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
                d.property_category = $('#property_category').val(),
                d.property_condition = $('#property_condition').val(),
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
              {data:"title",
                "mRender": function(data, type, full){
                
                return $("<div/>").html(data).text();
                }
            },
            {data:"type",
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },

            {data:"category",
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

        $('#status').change(function(){
           table_ajax();
        });

       $('#property_condition').change( function() {
           table_ajax();
        });

        $('#property_category').change( function() {
           table_ajax();
        });

         $('#property_type').change( function() {
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