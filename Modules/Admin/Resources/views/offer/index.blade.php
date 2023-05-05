@extends('admin::layouts.master')
@section('title', 'Property Sale Timers')

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
                                    <h4>Property Sale Timer list</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-sales-list')}}">Property Sale Timer list</a> </li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                     <a class="btn btn-primary btn-round" href="{{route('admin-property-sales-add')}}">Create Sale Timer</a>
                   
                  
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
                       <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="propertytable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                    <thead>
                                    <tr class="table-primary">
                                        <th>S.No</th>
                                        <th>Property</th>
                                        <th>Timer Schedule</th>
                                        <th>Publish Status</th>
                                       
                                        <th>Created At </th>
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
           serverSide: false,
           
        ajax: {
            url: "{{ route('admin-property-sales-list') }}",
               error: function(res){
                console.log(res);
            }
        //       data: function (d) {
        //     //   //   d.status = $('#status').val(),
        //     //   // //  d.delete_status = $('#delete_status').val(),
        //     //   //   d.search = $('input[type="search"]').val(),
        //     //   //   d.start_date = $('#start_date').val(),
        //     //   //   d.end_date = $('#end_date').val(),
        //     //   //  // d.country=$('#country').val(),
        //     //   //   d.state=$('#state').val(),
        //     //   //   d.city=$('#city').val();
              
        //     // }
        },
        columns: [
          //  {data: 'DT_RowIndex', orderable: false,
                    //searchable: false},
                       {
                    "render": function() {
                        return i++;
                    }
                },

            //{data: 'property_name'},
             {data:"property_name",
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
            {data: 'date_start',
                 "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
            // {data: 'date_end'},
            {data:"sale_status",
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
            // {data:"status",
            //     "mRender": function(data, type, full){
            //     return $("<div/>").html(data).text();
            //     }
            // },
          
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
});
  
   
$(document).on('click', '.badge_status_change', function(e)
{ 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-property-sales-status-update') }}";
        
        if(status_class == "badge badge-danger badge_status_change")
        {
            var newClass = "badge badge-success badge_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_status_change";
            var status = 'Inactive';
        }
       var title ='Are you sure to '+status+' this property timer ?';
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
                            toastr.success("Property Timer status active successfully");
                        }else{
                              toastr.error("Property Timer status inactive successfully");
                        }
                  
                }         
            })
        }
        //  else {
        //     swal("Cancelled", "Property Timer status is not change", "error");
        // }
        });         
}); 

   
$(document).on('click', '.badge_publish_status_change', function(e)
{ 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-property-sales-offer-publish-status') }}";
        
        if(status_class == "badge badge-danger badge_publish_status_change")
        {
            var newClass = "badge badge-success badge_publish_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_publish_status_change";
            var status = 'Inactive';
        }
       var title ='Are you sure to '+status+' this property sale offer publish status ?';
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
                success: function (response){
                    if(response.success==1){
                         change_btn.html(status);
                        change_btn.removeClass(status_class).addClass(newClass);
                        toastr.success("Property Timer publish status updated successfully");
                    }else if(response.error==1){
                        toastr.error("The property has been sold. You cannot publish offer for sold property.");
                    }
                  
                   
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "property sale offer publish status is not change", "error");
        // }
        });         
}); 


$(document).on('click', '.badge_delete_status_change', function(e)
{ 
   
    var this_id = $(this).attr('id');
    var url = "{{ route('admin-property-sales-delete-status') }}";
    
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
                    toastr.error("Property Timer deleted successfully");
                   
                } else {
                    swal("Error deleting!", "Please try again", "error");
                }
            }         
        })
    } 
    // else {
    //     swal("Cancelled", "Offer is not change", "error");
    // }
    });         
}); 


</script>   
@endsection