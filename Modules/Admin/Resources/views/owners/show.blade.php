@extends('admin::layouts.master')
@section('title', 'Owners Details')
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
                                    <h4>Owners Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-user-list')}}">Owners list</a> </li>
                                     <li class="breadcrumb-item"><a href="{{route('admin-user-details',$userInfo->id)}}">Owners Details</a> </li>
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
                                    <img class="img-radius img-40" src="{{ $userInfo->profile_pic}}" alt="user-pic">
                                    <h5 class="m-l-10"> {{$userInfo->name}}</h5>
                                </div>
                                <div class="card-block groups-contact">
                                    <ul class="nav nav-tabs list-group list-contacts">
                                        <li>
                                            <a href="#favProperty" class="list-group-item active justify-content-between" data-toggle="tab">Favorite Property <span class="badge badge-primary badge-pill favPropertyCount">{{$favPropertyCount}}</span></a>
                                            
                                        </li>
                                        <li>
                                            <a href="#AllBids" class="list-group-item justify-content-between" data-toggle="tab">All Bids <span class="badge badge-success badge-pill bidsCount">{{$bidsCount}}</span></a>  
                                            
                                        </li>
                                        {{--<li>
                                            <a href="#Notifications" class="list-group-item justify-content-between" data-toggle="tab">Notifications <span class="badge badge-info badge-pill">30</span></a>
                                            
                                        </li>--}}

                                        <li>
                                            <a href="#Complaints" class="list-group-item justify-content-between" data-toggle="tab">Feedback <span class="badge badge-danger badge-pill complaintCount">{{$complaintCount}}</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header btn_modify full">
                                            <h5 class="card-header-text">Personal Info</h5>
                                            <a href="{{route('admin-owners-edit',$userInfo->id)}}" id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right wdh-60">
                                                <i class="icofont icofont-edit"></i>
                                            </a>
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="general-info">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-xl-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table m-0" style="font-size: 12px">
                                                                            <tbody>
                                                                            <tr>
                                                                             <th scope="row">Buyer ID</th>
                                                                                    <td>{{ $userInfo->buyer_id}}</td>
                                                                                    <th>Email Varified</th>
                                                                                    <td>@if($userInfo->email_verified==1)
                                                                                    Yes
                                                                                    @else
                                                                                    No
                                                                                    @endif</td>
                                                                            </tr>
                                                                                <tr>
                                                                                    <th scope="row">Full Name</th>
                                                                                    <td>{{ $userInfo->name}}</td>
                                                                                     <th scope="row">Email</th>
                                                                                    <!-- <td><span class="__cf_email__" data-cfemail="{{$userInfo->email}}">{{$userInfo->email}}<span></td> -->
                                                                                    <td>{{$userInfo->email}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Mobile Number</th>
                                                                                    <td>{{  getMobileFormat(@$userInfo->mobile_no)}}</td>

                                                                                    <th scope="row">Registered Date</th>
                                                                                    <td>{{ $userInfo->created_at->format('M d, Y') }}</td>
                                                                                </tr>

                                                                                    <tr>
                                                                                       {{-- <th> Country Name:</th>
                                                                                        <td>{{ @$userInfo->country_name }}</td>--}}
                                                                                        <!-- <th>Country Code</th>
                                                                                        <td>{{ @$userInfo->country_code }}</td> -->
                                                                                    </tr>
                                                                                
                                                                                 {{--  <tr>
                                                                                   <th scope="row">Country</th>
                                                                                    <td>{{ @$userInfo->getUserCountry->name}}</td>

                                                                                    <th scope="row">State</th>
                                                                                    <td>{{ @$userInfo->getUserState->name}}</td>

                                                                                   
                                                                                </tr>
                                                                                 <tr>
                                                                                  <th scope="row">City</th>
                                                                                    <td>{{ @$userInfo->getUserCity->name}}</td>
                                                                                    <th scope="row">Address</th>
                                                                                    <td>{{ $userInfo->location}}</td>
                                                                                </tr>
                                                                                --}}
                                                                                <tr>
                                                                                    <th>Intrested City</th>
                                                                                    <td colspan="4">
                                                                                    @php $hasComma = false; @endphp
                                                                                    @foreach(@$intrestedCity as $li)
                                                                                        @if ($hasComma)
                                                                                            ,
                                                                                        @endif
                                                                                        {{ @$li->getIntrestedCity->name}} 
                                                                                      @php $hasComma = true; @endphp
                                                                                      @endforeach
                                                                                    </td>
                                                                                </tr>
                                                                                  {{--<tr>
                                                                                     <th scope="row"> Address </th>
                                                                                    <td colspan="4">{{ $userInfo->location}}</td>
                                                                                </tr>--}}
                                                                             
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                             
                                                            </div>
                                                            <!-- end of row -->
                                                        </div>
                                                        <!-- end of general info -->
                                                    </div>
                                                    <!-- end of col-lg-12 -->
                                                </div>
                                                <!-- end of row -->
                                            </div>
                                        </div>
                                        <!-- end of card-block -->
                                    </div>
                                    <!-- contact data table card start -->
                                    <div class="tab-content">
                                    <div id="favProperty" class="tab-pane active">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-header-text">Favorite Property</h5>
                                                </div>
                                                <div class="card-block contact-details">
                                                    <div class="table-responsive dt-responsive">
                                                        <table id="favPropertyTable" class="table table-styling table-bordered nowrap" style="width:100%"> 
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No</th>
                                                                    <th>Property Code</th>
                                                                    <th>Property Title</th>
                                                                    <th>Property Price</th>                                                                   
                                                                    <th>Action</th>                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                             
                                                            @foreach($favProperty as $key=>$pli)
                                                             <tr>
                                                                <td scope="row" class="sr-no">{{$key +1}}</td>                 
                                                                <td>#{{$pli->getFavPropertyInfo->property_code}}</td>
                                                                <td>{{$pli->getFavPropertyInfo->location}}</td>
                                                                <td>{{ moneyFormat($pli->getFavPropertyInfo->base_price)}}
                                                                </td>             
                                                                <td class="btn_modify">
                                                                    <a href="{{route('admin-property-details',$pli->getFavPropertyInfo->slug)}}" 
                                                                        title="View" 
                                                                        class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>

                                                                <button title="Remove From Favorite Propery" id="{{$pli->id}}" class="btn btn-danger btn-sm badge_delete_fav_property" onclick="badge_delete_fav_property(this,{{$pli->id}})"><i class="fa fa-trash"></i></button>
                                                                </td>                                                                
                                                            </tr>                                                          
                                                          @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div id="AllBids" class="tab-pane">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-header-text">Bids</h5>
                                                </div>
                                                <div class="card-block contact-details">
                                                    <div class="table-responsive dt-responsive">
                                                        <table id="bidTable" class="table table table-styling table-bordered nowrap" style="width:100%"> 
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No</th>
                                                                    <th>Bid Price</th>
                                                                    <th>Property</th>
                                                                    <th>Bid Status</th>
                                                                    <th>Bid Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>                                                            
                                                             @foreach($bids as $k=>$pli)                                                           
                                                               <tr>
                                                                <td scope="row">{{ $k +1 }}</td>                                                               
                                                                <td>{{moneyFormat(@$pli->bid_price)}}</td>
                                                                <td>{{@$pli->BidPropertyInfo->location}}</td>
                                                                <td>{{@$pli->bid_status}}</td>
                                                                <td>{{date('M d,Y',strtotime(@$pli->created_at))}}</td>
                                                                <td class="btn_modify">
                                                                    <a href="{{route('admin-bid-view',$pli->id)}}" title="View" class="btn btn-warning btn-sm">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <button title="Remove Bid" id="{{$pli->id}}" class="btn btn-danger btn-sm badge_delete_bid" onclick="badge_delete_bid(this,{{$pli->id}})">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>                                      
                                    <div id="Complaints" class="tab-pane">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-header-text">Feedback</h5>
                                                </div>
                                                <div class="card-block contact-details">
                                                    <div class="table-responsive dt-responsive">
                                                          <table id="complaintTable" class="table table-bordered nowrap" style="width: 100%; font-size:12px">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No.</th>
                                                                    <th>Feedback Reason</th>
                                                                    <th>Added Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                          <tbody>
                                                           @php $c=1; @endphp
                                                            @foreach($complaint as $k=>$pli)                                                          
                                                                <tr>
                                                                <td scope="row" class="sr-no">{{ $k +1 }}</td>                 
                                                                <td>{{$pli->getReasonType->name}}</td>
                                                                <td>
                                                                {{date('M d,Y',strtotime(@$pli->created_at))}}</td>
                                                                <td class="btn_modify">
                                                                    <a href="{{route('admin-enquiry-detail',$pli->id)}}" title="View" class="btn btn-warning btn-sm">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <button title="Remove Feedback" id="{{$pli->id}}" class="btn btn-danger btn-sm badge_delete_complaint" onclick="badge_delete_complaint(this,{{$pli->id}})">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>   
                                                            </tr>
                                                              @php $c++; @endphp  
                                                            @endforeach
                                                            </tbody>                                                      
                                                        </table>                                                       
                                                    </div>
                                                </div>
                                            </div>
                                    </div>                                      
                                    </div>
                                    <!-- contact data table card end -->
                                </div>
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
            <div class="modal-body"><div class="info"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light ">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection   
@section('js')
<script type="text/javascript">

$('#favPropertyTable').DataTable({
"aoColumnDefs": [
{ "bSortable": false, "aTargets": [4] },
{ "bSearchable": false, "aTargets": [4] }
]
});

$('#bidTable').DataTable({
"aoColumnDefs": [
{ "bSortable": false, "aTargets": [5] },
{ "bSearchable": false, "aTargets": [5] }
]
});
$('#complaintTable').DataTable({
"aoColumnDefs": [
{ "bSortable": false, "aTargets": [4] },
{ "bSearchable": false, "aTargets": [4] }
]
});


   $('#favPropertyTable').DataTable();

    $('#bidTable').DataTable();

    $('#complaintTable').DataTable();
    
   $('a[data-toggle="tab"]').on('click', function (e) {
      //var activated_tab = e.target // activated tab
      var hrefTab=$(this).attr('href');
      //var previous_tab = e.relatedTarget // previous tab
      if(hrefTab === '#AllBids') {
        $('#AllBids').css('display', 'block');
        $('#Notifications').css('display', 'none');
        $('#Complaints').css('display', 'none');
         $('#favProperty').css('display', 'none');
      
      };
      if(hrefTab === '#Notifications') {
        $('#AllBids').css('display', 'none');
        $('#Notifications').css('display', 'block');
        $('#Complaints').css('display', 'none');
         $('#favProperty').css('display', 'none');
       
      }
      if(hrefTab === '#Complaints') {
        $('#AllBids').css('display', 'none');
        $('#Notifications').css('display', 'none');
        $('#Complaints').css('display', 'block');
        $('#favProperty').css('display', 'none');
       
      }
       if(hrefTab === '#favProperty') {
        $('#AllBids').css('display', 'none');
        $('#Notifications').css('display', 'none');
        $('#Complaints').css('display', 'none');
        $('#favProperty').css('display', 'block');
       
      }
     
      
    });

$(document).on('click', '.openModal', function(e){
    var id = $(this).attr('data-id');
    var url= "{{ route('admin-user-complaint-detail') }}";
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
        success:function(result){
        $(".info").html('<h5 class="font-header">'+result.data.title+'</h5><img src="'+result.data.attachment+'" alt="'+result.data.attachment+'" class="img img-fluid" width="100" height="100"><div class="overflow-container"><p>'+result.data.description+'</p></div>');
    }});
});


    // $(".nav-tabs a").click(function(){
      
    //     $(this).closest('li').addClass('list-group-item active justify-content-between').siblings().removeClass('active');
        
    // });

    $(document).ready(function() {
    $("div.groups-contact>div.list-contacts>li").click(function(e) {
        e.preventDefault();
        $(this).siblings('li.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.groups-contact>div.list-contacts>li").removeClass("active");
        $("div.groups-contact>div.list-contacts>li").eq(index).addClass("active");
    });
});


$(document).ready(function() {


$(document).on('click', '.bid_status_btn', function(e)
{ 
    var id = $(this).data('id');
    var status = $(this).data('status');
  
    var url = "{{ route('admin-bid-status-update') }}";
    
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
          tablebid.draw();  
        }         
    })
            
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
          table.draw();  
        }         
    })
            
}); 



});



// $(document).on('click', '.badge_delete_complaint', function(e)
function badge_delete_complaint(event,id){ 
    var this_id = id;
    
    var url = "{{ route('admin-user-enquiry-delete') }}";
    
    var title ='Are you sure to delete this row ?';
    //e.preventDefault();      
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
                if (response.success == "1") {
                    // jQuery('.rem_row_' + this_id).remove();
                    //  var rowCount = $('#complaintTable tr').length;
                    // $('.complaintCount').html(rowCount-1);
                    // alert(rowCount);

                    swal("Done!", "Row deleted succesfully!", "success");
                      window.location.reload();
                } else {
                    swal("Error deleting!", "Please try again", "error");
                }
            }         
        })
    } 
    // else {
    //     swal("Cancelled", "page is not change", "error");
    // }
    });         
}   


// $(document).on('click', '.badge_delete_fav_property', function(e)
function badge_delete_fav_property(event,id){ 
   
    var this_id = id;
    var url = "{{ route('admin-fav-property-remove') }}";
    
    var title ='Are you sure to delete this row ?';
   // e.preventDefault();      
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
                    // jQuery('.rem_row_' + this_id).remove();
                    
                    //  var rowCount = $('#favPropertyTable tr').length;
                    // $('.favPropertyCount').html(rowCount-1);
                      window.location.reload();
                   // $('#favPropertyTable').DataTable().draw();
                    swal("Done!", "Row deleted succesfully!", "success");
                } else {
                    swal("Error deleting!", "Please try again", "error");
                }
            }         
        })
    }
    //  else {
    //     swal("Cancelled", "page is not change", "error");
    // }
    });         
}   


// $(document).on('click', '.badge_delete_bid', function(e)
function badge_delete_bid(event,id){ 
   
    var this_id = id;
    var url = "{{ route('admin-bid-delete') }}";
    
    var title ='Are you sure to delete this row ?';
  //  e.preventDefault();      
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
                if (response.success == "1") {
                   // jQuery('.rem_row_' + this_id).remove();
                    //var rowCount = $('#bidTable tr').length;
                    // $('.bidsCount').html(rowCount-1);
                     $('#bidTable').DataTable().draw();
                      window.location.reload();
                    swal("Done!", "Row deleted succesfully!", "success");
                } else {
                    swal("Error deleting!", "Please try again", "error");
                }
            }         
        })
    } 
    // else {
    //     swal("Cancelled", "page is not change", "error");
    // }
    });         
}   


</script>   
@endsection