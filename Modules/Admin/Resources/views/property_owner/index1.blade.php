@extends('admin::layouts.master')
@section('title', 'Buyer List')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header my-2">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Buyer List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-list')}}">Buyer List</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-round" href="{{route('admin-user-add')}}">Add Buyer</a>
                   
                    <button type="button" class="btn btn-primary btn-round" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Apply Filters</button>
                   
                </div>
                <!-- Page-header end -->
                <div class="page-body">
                   
                            <div class="card my-1">
                                <div class="card-block collapse mt-3"  id="collapseExample">
                                    <div class="row">       
                                        <!--  <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Deleted :</strong></label>
                                                <select id='delete_status' class="form-control" style="width: 200px">
                                                    <option value="">All</option>
                                                    <option value="1">Deleted</option>
                                                    <option value="0">Not Deleted</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-md-6">       
                                            <div class="form-group">
                                                <label><strong>Registration Start From <span class="text-danger"></span></strong></label>
                                                <div class="controls">
                                                    <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> 
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">        
                                            <div class="form-group">
                                                <label><strong>To Date <span class="text-danger"></span></strong></label>
                                                <div class="controls">
                                                    <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> 
                                                    <div class="help-block">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>State</strong></label>
                                                <select id="state" class="form-control" onchange="getCity()" style="width: 200px">
                                                    <option value="">Select</option>
                                                     @foreach($stateList as $sli)
                                                    <option value="{{$sli->id}}">{{$sli->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>City</strong></label>
                                                <select id="city" multiple class="js-example-placeholder-multiple form-control"  style="width: 200px">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>--}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Status :</strong></label>
                                                <select id='status'  class="form-control">
                                                    <option value="">All</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Verify Status:</strong></label>
                                                <select id='email_verified'  class="form-control">
                                                    <option value="">All</option>
                                                    <option value="1">Verified</option>
                                                    <option value="0">Not Verified</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Country Code:</strong></label>
                                                <select id='country_code'  class="form-control">
                                                    <option value="">All</option>
                                                    @foreach(@$countryCodelist as $li)
                                                      <option value="{{$li->country_code}}">{{$li->country_code}}</option>
                                                    @endforeach
                                                  
                                                   
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="resetFilter btn btn-inverse" type="button">Reset</button>          
                                </div>
                            </div>
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
                                        <table id="usertable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                            <thead>
                                            <tr class="table-primary">
                                                <th>S.No</th>
                                                <th>Name </th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Status</th>
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



$('.datepicker').datepicker({
  dateFormat: 'yy-mm-dd'
});


    function table_ajax(){
        var i = 1;
        var table = $('#usertable').DataTable({
            processing: true,
            serverSide: false,
            "bDestroy": true,
           //  pageLength:20,
           // render: true,
            ajax: {
                url: "{{ route('admin-user-list') }}",
                 type: 'GET',
                 data: function (d) {
                    d.status = $('#status').val(),
                    
                    d.delete_status = $('#delete_status').val(),
                    d.search = $('input[type="search"]').val(),
                    d.start_date = $('#start_date').val(),
                    d.end_date = $('#end_date').val(),
                  //  d.country=$('#country').val(),
                    d.state=$('#state').val(),
                    d.email_verified=$('#email_verified').val(),
                    d.country_code=$('#country_code').val(),
                    
                    
                    d.city=$('#city').val();

                  
                }
            },
            columns: [
            {
                    "render": function() {
                        return i++;
                    }
                },
               // {data: 'id'},
                 //{data: 'name', name: 'name'},
                   {data:"name",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
            
        
                // {data:"profile_pic",
                //     "mRender": function(data, type, full){
                //     return $("<div/>").html(data).text();
                //     }
                // },
               // {data: 'name'},
               // {data: 'email',name: 'email'},
               {data:"email",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                {data:"mobile_no",
                    "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                    }
                },
                // {data: 'country'},
                // {data: 'state'},
                // {data: 'city'},
                {data:"status",
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

        // var table = $('#usertable').DataTable({
        //     processing: true,
        //     serverSide: false,
        //     // ordering: true,
        //     // searching: true,
        //     ajax: {
        //         url: "{{ route('admin-user-list') }}",
        //          type: 'GET',
        //          data: function (d) {
        //             d.status = $('#status').val(),
        //             d.delete_status = $('#delete_status').val(),
        //             d.search = $('input[type="search"]').val(),
        //             d.start_date = $('#start_date').val(),
        //             d.end_date = $('#end_date').val(),
        //           //  d.country=$('#country').val(),
        //             d.state=$('#state').val(),
        //             d.city=$('#city').val();

                  
        //         }
        //     },
        //     columns: [
        //         {data: 'id'},
        //          {data: 'name', name: 'name'},
        
        //         // {data:"profile_pic",
        //         //     "mRender": function(data, type, full){
        //         //     return $("<div/>").html(data).text();
        //         //     }
        //         // },
        //        // {data: 'name'},
        //         {data: 'email',name: 'email'},
        //         {data: 'mobile_no',name: 'mobile_no'},
        //         // {data: 'country'},
        //         // {data: 'state'},
        //         // {data: 'city'},
        //         {data:"status",
        //             "mRender": function(data, type, full){
        //             return $("<div/>").html(data).text();
        //             }
        //         },
        //         // {data:"delete_status",
        //         //     "mRender": function(data, type, full){
        //         //     return $("<div/>").html(data).text();
        //         //     }
        //         // },
        //         // {data: 'created_at'},
        //         {'data':"action__",
        //                 // "className": "action",
        //                  "mRender": function(data, type, full){
        //                     return $("<div/>").html(data).text();
        //                     }
        //                 },
               
        //     ],
        // });


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
            //table.draw();
            table_ajax();
        });
     
        $('#delete_status').change(function(){
            //table.draw();
            table_ajax();
        });

          $('#email_verified').change(function(){
            //table.draw();
            table_ajax();
        });

            $('#country_code').change(function(){
            //table.draw();
            table_ajax();
        });
        
      $('#start_date, #end_date').change( function() {
            //table.draw();
            table_ajax();
        });

       $('#state, #city').change( function() {
            //table.draw();
            table_ajax();
        });

        $('input[type="search"]').change( function() {
            //table.draw();
            table_ajax();
        });


        $('.resetFilter').on('click', function(){
            $("#status").val("").trigger( "change" );
             $("#email_verified").val("").trigger( "change" );
            $("#state").val("").trigger( "change" );
            $("#city").html("");
            $("#country_code").val("").trigger( "change" );
           $('#start_date,#end_date').val(null);
           
           
           //table.draw();
           table_ajax();

        });

         

    $(document).on('click', '.badge_status_change', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('id');
            var change_btn = $(this);
            var url = "{{ route('admin-user-status-update') }}";
            
            if(status_class == "badge badge-danger badge_status_change")
            {
                var newClass = "badge badge-success badge_status_change";
                var status = 'Active';
            }else
            {
                var newClass = "badge badge-danger badge_status_change";
                var status = 'Inactive';
            }
           var title ='Are you sure to '+status+' this user ?';
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
                        if(data.success==1){
                            change_btn.html(status);
                            change_btn.removeClass(status_class).addClass(newClass);
                           
                            toastr.success("Buyer status updated "+status+" successfully");
                        }
                       
                    }         
                })
            } else {
                swal("Cancelled", "User is not change", "error");
            }
            });         
    }); 


    $(document).on('click', '.badge_delete_status_change', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('id');
            var change_btn = $(this);
            var url = "{{ route('admin-user-delete') }}";
            
            if(status_class == "badge badge-danger")
            {
                var newClass = "badge badge-success badge_delete_status_change";
                var status = 'Not Deleted';
            }else
            {
                var newClass = "badge badge-danger";
                var status = 'Deleted';
            }
           var title ='Are you sure to delete this user ?';
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
                       table_ajax();
                        toastr.success('Buyer deleted successfully!');
                       // change_btn.html(status);
                        //change_btn.removeClass(status_class).addClass(newClass);
                    }         
                })
            } else {
                swal("Cancelled", "User is not change", "error");
            }
            });         
    });   

});





</script>   
@endsection