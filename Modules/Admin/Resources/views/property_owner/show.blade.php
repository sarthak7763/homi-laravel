@extends('admin::layouts.master')
@section('title', 'Property Owner Details')
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
                                    <h4>Property Owner Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-propertyOwner-list')}}">Property Owners list</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-propertyOwner-details',$userInfo->id)}}">Property Owners Details</a> </li>
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
                        <div class="col-xl-3">
                            <!-- user contact card left side start -->
                            <div class="card">
                                <div class="card-header contact-user">
                                    @if($userInfo->profile_pic!="")
                                    <img class="img-radius img-40" src="{{url('/')}}/images/owners/{{ $userInfo->profile_pic}}" alt="user-pic">
                                    @else
                                     <img class="img-radius img-40" src="{{url('/')}}/no_image/user_pic.png" alt="user-pic">
                                    @endif
                                    <h5 class="m-l-10"> {{$userInfo->name}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header btn_modify full">
                                    <h5 class="card-header-text">Personal Info</h5>
                                </div>
                                <div class="card-block">
                                <div class="view-info">
                                    <div class="row">
                                    <div class="col-lg-12">
                                <table class="table table-styling table-bordered nowrap">
                                    <tbody>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{$userInfo->email}}</td>  
                                    </tr>

                                    <tr>
                                        <th>Mobile:</th>
                                        <td>{{$userInfo->mobile}}</td>  
                                    </tr>

                                    <tr>
                                        <th>Registered Date:</th>
                                        @php
                                            $registerdate=date('d M, Y g:i A', strtotime($userInfo->created_at));
                                        @endphp
                                        <td>{{$registerdate}}</td>  
                                    </tr>

                                    <tr>
                                        <th>Email Verified:</th>
                                        @if($userInfo->email_verified==1)
                                        <td>
                                            <span class="badge badge-success">Verified</span>
                                        </td>
                                        @else
                                        <td>
                                            <span class="badge badge-danger">Unverified</span>
                                        </td> 
                                        @endif  
                                    </tr>

                                    <tr>
                                        <th>Owner Type:</th>
                                        @if($userInfo->owner_type==1)
                                        <td>
                                            <span class="badge badge-success">Agency</span>
                                        </td>
                                        @else
                                        <td>
                                            <span class="badge badge-danger">Individuals</span>
                                        </td> 
                                        @endif  
                                    </tr>

                                    <tr>
                                        <th>Agency Name:</th>
                                        @if($userInfo->owner_type==1)
                                        <td>
                                            {{$userInfo->agency_name}}
                                        </td>
                                        @else
                                        <td>
                                            N.A.
                                        </td> 
                                        @endif  
                                    </tr>

                                     <tr>
                                        <th>Status:</th>
                                        @if($userInfo->status==1)
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        @else
                                        <td>
                                            <span class="badge badge-danger">Suspend</span>
                                        </td> 
                                        @endif  
                                    </tr>
                                        
                                    </tbody>
                                    </table>
                                    </div>
                                    <!-- end of col-lg-12 -->
                                </div>
                                    <!-- end of row -->
                                </div>
                                </div>
                                <!-- end of card-block -->
                                    </div>
                                    
                                </div>
                            </div>
                        </div>                   
                    </div>
                </div>


                <div class="col-md-12">

                    <div id="exTab2" class="container"> 
                        <ul class="nav nav-tabs">
                                <li class="active">
                                    <a  href="#prlist" data-toggle="tab">Property List</a>
                                </li>
                                <li>
                                    <a href="#orlist" data-toggle="tab">Orders</a>
                                </li>
                                </ul>

                                    <div class="tab-content ">
                                    <div class="tab-pane active" id="prlist">
                                    
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
                                        <div class="tab-pane" id="orlist">
                                  <h3>Notice the gap between the content and tab after applying a background color</h3>

                                  <h3>Notice the gap between the content and tab after applying a background color</h3>

                                  <h3>Notice the gap between the content and tab after applying a background color</h3>

                                  <h3>Notice the gap between the content and tab after applying a background color</h3>

                                  <h3>Notice the gap between the content and tab after applying a background color</h3>

                                  <h3>Notice the gap between the content and tab after applying a background color</h3>

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

function table_property_ajax(){
      var i = 1;
      var table = $('#propertytable').DataTable({
        processing: true,
           serverSide: false,
            "bDestroy": true,
        ajax: {
            url: "{{ route('admin-property-list-seller-wise') }}",
            type: 'GET',
             data: function (d) {
                d.owner_id = "{{$userInfo->id}}";
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
   table_property_ajax();
});
</script>
@endsection