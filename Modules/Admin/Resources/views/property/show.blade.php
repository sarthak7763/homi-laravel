@extends('admin::layouts.master')
@section('title', 'Property Details')
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
                                    <h4>Property Details</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-details',$propertyInfo->slug)}}">Property Details</a></li>
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
                            <span aria-hidden="true" style="font-size: 19px;margin-top: -1px;">&times;</span>
                        </label>

                        {{ $message }}
                    </div>
                </div>
            </div>
            @endif
            <div class="page-body">
                <div class="card">
                    <div class="card-block">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                               <!-- Nav tabs -->
                               <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active"  href="{{route('admin-property-details',$propertyInfo->slug)}}">About</a>
                                    <div class="slide"></div>
                                </li>
                                @if(Auth::user()->hasRole('Admin'))                                     
                                <li class="nav-item">
                                    <a class="nav-link"  href="{{route('admin-property-gallery-view',$propertyInfo->slug)}}" >Gallery</a>
                                    <div class="slide"></div>
                                </li>                                                     
                                @elseif(Auth::user()->hasRole('sub-admin'))
                                @if(auth()->user()->can('admin-property-gallery-list') || auth()->user()->can('admin-upload-gallery-ajax'))
                                <li class="nav-item">
                                    <a class="nav-link"  href="{{route('admin-property-gallery-view',$propertyInfo->slug)}}" >Gallery</a>
                                    <div class="slide"></div>
                                </li>
                                @endif     
                                @endif
                                @if(Auth::user()->hasRole('Admin'))                                     
                                <li class="nav-item">
                                    <a class="nav-link"  href="{{route('admin-property-video-view',$propertyInfo->slug)}}" >Video</a>
                                    <div class="slide"></div>
                                </li>                                                  
                                @elseif(Auth::user()->hasRole('sub-admin'))
                                @if(auth()->user()->can('admin-upload-video-ajax'))
                                <li class="nav-item">
                                    <a class="nav-link"  href="{{route('admin-property-video-view',$propertyInfo->slug)}}" >Video</a>
                                    <div class="slide"></div>
                                </li>
                                @endif     
                                @endif
                                @if(Auth::user()->hasRole('Admin'))                                     
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin-property-documents-view',$propertyInfo->slug)}}">Documents</a>
                                    <div class="slide"></div>
                                </li>                                                
                                @elseif(Auth::user()->hasRole('sub-admin'))
                                @if(auth()->user()->can('admin-upload-gallery-ajax'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin-property-documents-view',$propertyInfo->slug)}}">Documents</a>
                                    <div class="slide"></div>
                                </li>
                                @endif
                                @endif

                                  <li class="nav-item">
                                        <a class="nav-link" href="{{route('admin-property-timer',$propertyInfo->slug)}}" >Timer</a>
                                        <div class="slide"></div>
                                    </li>     
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="AboutTab">
                                    <div class="card col-md-12 o-auto">
                                        <div class="card-header btn_modify full">
                                            <h5 class="card-header-text">About Property</h5>
                                            <a href="{{route('admin-property-edit',$propertyInfo->slug)}}" id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right wdh-60">
                                                <i class="icofont icofont-edit"></i>
                                            </a>
                                        </div>
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row" style="font-size: 12px">
                                                    <div class="col-lg-3">
                                                        <img class="img-thumbnail" src="{{ $propertyInfo->image}}" alt="user-pic" title="Featured Image">
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="general-info">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-xl-12">
                                                                    <dl class="row">
                                                                        <dt class="col-4 col-sm-4">Property Name</dt>
                                                                        <dd class="col-8 col-sm-8">{{ @$propertyInfo->title}}</dd>
                                                                        <dt class="col-4 col-sm-4">Property No. </dt>
                                                                        <dd class="col-8 col-sm-8">{{@$propertyInfo->property_code}}</dd>
                                                                        <dt class="col-4 col-sm-4">Built In Year </dt>
                                                                        <dd class="col-8 col-sm-8">{{ @$propertyInfo->year_from}} {{@$propertyInfo->year_to}}</dd>
                                                                        <dt class="col-4 col-sm-4">Living SqFt</dt>
                                                                        <dd class="col-8 col-sm-8">{{ numberPlaceFormat(@$propertyInfo->property_size)}}</dd>
                                                                        <dt class="col-4 col-sm-4">Lot Size </dt>
                                                                        <dd class="col-8 col-sm-8">{{@$propertyInfo->lot_size ? numberPlaceFormat(@$propertyInfo->lot_size) : "--" }}</dd>
                                                                        <dt class="col-4 col-sm-4">Property Type </dt>
                                                                        <dd class="col-8 col-sm-8">{{ @$propertyInfo->getPropertyType->name}}</dd>
                                                                        <dt class="col-4 col-sm-4">List Price</dt>
                                                                        <dd class="col-8 col-sm-8">{{ moneyFormat($propertyInfo->base_price)}}</dd>
                                                                        <dt class="col-4 col-sm-4">Seller Price</dt>
                                                                        <dd class="col-8 col-sm-8">{{ moneyFormat($propertyInfo->seller_price)}}</dd>
                                                                        <dt class="col-4 col-sm-4">Status</dt>
                                                                        <dd class="col-8 col-sm-8"> 
                                                                        @if(@$propertyInfo->escrow_status == "Sold")
                                                                            <span class="badge badge-danger" data-id="{{$propertyInfo->id}}" style="cursor: pointer;">Closed or in escrow</span>
                                                                        @else
                                                                            @if(@$propertyInfo->escrow_status == "Pending")
                                                                                <span class="badge badge-danger" data-id="{{$propertyInfo->id}}" style="cursor: pointer;">Closed or in escrow</span>
                                                                            @else
                                                                                @if(@$propertyInfo->status==1)
                                                                                <span class="badge badge-success property_status" data-id="{{$propertyInfo->id}}" style="cursor: pointer;">Active</span>
                                                                                @else
                                                                                <span class="badge badge-danger property_status" data-id="{{$propertyInfo->id}}" style="cursor: pointer;">Inactive</span>
                                                                                @endif
                                                                            @endif  
                                                                        @endif 
                                                                        </dd>
                                                                        <dt class="col-4 col-sm-4">
                                                                            Close of Escrow Status
                                                                          
                                                                          
                                                                        </dt>
                                                                        <dd class="col-8 col-sm-8">@if(@$propertyInfo->escrow_status=="Active")
                                                                           <span class="badge badge-success" style="cursor: pointer;">Active</span>
                                                                           @endif
                                                                           @if(@$propertyInfo->escrow_status == "Pending")
                                                                           <span class="badge badge-warning" style="cursor: pointer;">Pending</span>
                                                                           @endif
                                                                           @if(@$propertyInfo->escrow_status=="Cancelled")
                                                                           <span class="badge badge-inverse" style="cursor: pointer;">Cancelled</span>
                                                                           @endif
                                                                           @if(@$propertyInfo->escrow_status=="Sold")
                                                                           <span class="badge badge-danger" style="cursor: pointer;" >Sold</span>
                                                                           @endif
                                                                            @if(!empty($propertyInfo->getBids) &&  ($propertyInfo->award_bid_count  > 0 || $propertyInfo->closed_bid_count  > 0))
                        
                                                                             <span class="badge badge-inverse closeofescrowbtn" data-toggle="modal" data-target="#propertyEscrowModal" data-id="{{$propertyInfo->id}}" title="Escrow Status" style="cursor: pointer;"><i class="fa fa-edit"></i> Update Escrow Status</span>
                                                                             @endif
                                                                       </dd>

                                                                       <dt class="col-4 col-sm-4">Address</dt>
                                                                       <dd class="col-8 col-sm-8">  
                                                                        {{ $propertyInfo->location}}

                                                                    </dd>

                                                                  
                                                                    <dt class="col-4 col-sm-4">State</dt>
                                                                    <dd class="col-8 col-sm-8">  
                                                                        {{ @$propertyInfo->getPropertyState->name}}
                                                                    </dd>
                                                                    <dt class="col-4 col-sm-4">City</dt>
                                                                    <dd class="col-8 col-sm-8">  
                                                                       {{ @$propertyInfo->getPropertyCity->name}}
                                                                   </dd>
                                                                   <dt class="col-4 col-sm-4">No. of Beds</dt>
                                                                   <dd class="col-8 col-sm-8"> 
                                                                     {{ @$propertyInfo->no_of_bedroom ? $propertyInfo->no_of_bedroom  : '--' }}
                                                                 </dd>
                                                                 <dt class="col-4 col-sm-4">No. of Baths</dt>
                                                                 <dd class="col-8 col-sm-8">  
                                                                    {{ @$propertyInfo->no_of_bathroom ? $propertyInfo->no_of_bathroom  : '--' }}

                                                                </dd>
                                                                <dt class="col-4 col-sm-4">EMD Due</dt>
                                                                <dd class="col-8 col-sm-8">  
                                                                    {{ @$propertyInfo->emd_due ? $propertyInfo->emd_due  : '--' }}

                                                                </dd>
                                                                <dt class="col-4 col-sm-4">EST COE</dt>
                                                                <dd class="col-8 col-sm-8">  
                                                                    {{ @$propertyInfo->emd_coe ? date('M d, Y',strtotime($propertyInfo->emd_coe))  : '--' }}

                                                                </dd>
                                                                <dt class="col-4 col-sm-4">EMD Amount</dt>
                                                                <dd class="col-8 col-sm-8">  
                                                                    {{ @$propertyInfo->emd_amount ? moneyFormat($propertyInfo->emd_amount)  : '--' }}
                                                                </dd>
                                                                <dt class="col-sm-12">Description</dt>
                                                                <dd class="col-sm-12">  
                                                                   <div 
                                                                   style="
                                                                   border: 1px inset #ccc;
                                                                   background-color: white;
                                                                   font: small courier, monospace black;
                                                                   width: 100%;
                                                                   height: 120px;padding:5px; 
                                                                   overflow: auto;">
                                                                   {!!  @$propertyInfo->description ? $propertyInfo->description  : '--'
                                                                   !!}
                                                               </div>
                                                           </dd>
                                                       </dl>
                                                   </div>
                                               </div>
                                               <!-- end of row -->
                                           </div>
                                           <!-- end of general info -->
                                       </div>
                                       <!-- end of col-lg-12 -->
                                   </div>
                               </div>
                           </div>
                           <!-- end of card-block -->
                       </div>
                       <div class="card col-md-12 o-auto">
                            <div class="card-header">
                                <h5 class="card-header-text">Bids</h5>
                            </div>
                            <div class="card-body">
                                <div class="data_table_main table-responsive dt-responsive">
                                    <table id="bidTable" class="table table table-styling table-bordered nowrap" style="width:100%"> 
                                        <thead>
                                            <tr class="table-primary">
                                                <th>S.No</th>
                                                <th>Bidder Name</th>
                                                <th>Bid Price</th>
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
                    <div class="card col-md-12 o-auto">
                        <div class="card-header">
                            <h5>Sales Timer</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive dt-responsive">
                                <table id="sales" class="table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Timer Date & Time</th>
                                          
                                            <th>Publish Status</th>
                                            <th>Created At </th>
                                            <th>Last Updated</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(@$offerTimer as $k=>$pli)
                                        <tr>
                                            <td scope="row">{{ $k+ 1 }}</td>
                                            <td>From : {{ date('M d, Y',strtotime($pli->date_start))}} {{ date('g:i A',strtotime($pli->time_start))}}<br>
                                          To: {{ date('M d, Y',strtotime($pli->date_end))}} {{ date('g:i A',strtotime($pli->time_end))}} <br>
                                          @php $remainTime=daysLeftToExpireProperty(@$pli->date_end,@$pli->time_end); @endphp
                                           <span class="badge badge-inverse">{{$remainTime}}</badge>
                                            </td>
                                          
                                            <td>@if($pli->sale_status== 1)
                                               <span class="badge badge-success badge_sale_status_change" style="cursor: pointer;" id="{{$pli->id}}">Published</span>
                                               @else
                                               <span class="badge badge-danger badge_sale_status_change" style="cursor: pointer;" id="{{$pli->id}}">Not Published</span>
                                               @endif
                                           </td>
                                          
                                           <td>{{ date('M d, Y, H:i A',strtotime($pli->created_at))}}</td>
                                           <td>{{ date('M d, Y, H:i A',strtotime($pli->updated_at))}}</td>
                                           <td class="btn_modify">
                                            <a href="{{route('admin-property-sales-edit',$pli->id)}}" title="Edit" class="btn btn-info btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{route('admin-property-sales-detail-show',$pli->id)}}" title="View" class="btn btn-warning btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
                <div class="card col-md-12 o-auto">
                    <div class="card-header">
                        <h5 class="card-header-text">Favorite Property</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dt-responsive">
                            <table id="favPropertyTable" class="table table-bordered" style="width:100%"> 
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Buyer Name</th>
                                        <th>Buyer Email</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(@$favProperty as $key=>$pli)
                                    @foreach(@$pli->favPropertyUsersInfo as $keys=>$li)
                                    <tr class="rem_row_{{$pli->id}}">
                                        <td class="favPropertyCount"><?php echo $key+1; ?></td>
                                        <td><a href="{{route('admin-user-details',$li->slug)}}">{{$li->name}}</td>
                                        <td>{{$li->email}}</td>
                                        <td>{{ date('M d, Y, H:i A',strtotime($li->created_at))}}</td>
                                        <td class="btn_modify">
                                            <a href="{{route('admin-user-details',$li->id)}}" title="View" class="btn btn-warning btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button title="Remove From Favorite Propery" data-id="{{$pli->id}}" class="btn btn-danger btn-sm badge_delete_fav_property">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->
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
<div class="modal fade" id="propertyEscrowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content propertyEscrowContent">
      <div class="modal-header">
        <h5 class="modal-title model_property_title" id="exampleModalLabel">Update Close of Escrow Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="addData">
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_close_of_ecsrow_btn" data-property_id="" data-bidder_id="" data-bid_id="">Update Status</button>
      </div>
    </div>
  </div>
</div>
@endsection   
@section('js') 
<script>
function table_ajax(){
    var i = 1;
    var property_id='{{@$propertyInfo->id}}'; 
    var table = $('#bidTable').DataTable({
        processing: true,
        serverSide: false,
        "bDestroy": true,
        ajax: {
            url: "{{ route('admin-show-property-wise-bid-list') }}",
            type: 'POST',
            data:{property_id:property_id},
            
        },
        columns: [
            //{data: 'DT_RowIndex', orderable: false,
            //searchable: false},
            {
                "render": function() {
                    return i++;
                }
            },
            {   data:"bidder_name", 
                "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                }
            },
            {   data: 'bid_price'},
           
            {   data:"bid_status", "bSortable": false,"className":"dropdown",
                "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                }
            },
            {   data:"bid_type", 
                "mRender": function(data, type, full){
                return $("<div/>").html(data).text();
                }
            },
            {   data:"status", 
                "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                }
            },
            {   data: 'created_at'},
            {   'data':"action__", "bSortable": false,
                "className": "action btn_modify",
                "mRender": function(data, type, full){
                    return $("<div/>").html(data).text();
                }
            },
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          if(aData.bid_status.includes(`btn-awarded`)){
            $('td', nRow).css('background-color', '#2faf');
          } 
        }
    });

}
///
    $('#favPropertyTable').DataTable({
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [4] },
        { "bSearchable": false, "aTargets": [4] }
        ]
    });

    $('#sales').DataTable({
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [5] },
        { "bSearchable": false, "aTargets": [5] }
        ]
    });

    $(document).ready(function() {
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select"
        });

          table_ajax();
    });
    ////////////////////////////////////////////////////

 $('#propertyEscrowModal').on('show.bs.modal', function(e) {   
    var getIdFromRow = $(e.relatedTarget).data('id');
    $('.update_close_of_ecsrow_btn').prop("disabled",false);
    $('.update_close_of_ecsrow_btn').text("Update Status");


$('.check_escrow').attr('data-propid',getIdFromRow); //setter
 $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",property_id:getIdFromRow}, 
        url: "{{ route('admin-ajax-get-property-info') }}",
         beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
        success:function(response){
            if(response.status=="success") {
                 $('.model_property_title').html(response.result.title+"<br><small>Close of Escrow Status Update<small>");

                if(response.result.escrow_status == "Sold"){

                     if(response.bid_status=="Closed" ){
                       // alert();
                        var f=response.bid_info.bid_price; 
                        console.log(response.bid_info);
                        $('.model_property_title').html("Property:"+response.result.title+"<br><small>Set Escrow Status Cancelled for this property.</small>");
                        $('.addData').html('<div class="card"><div class="row"><div class="col-md-12"><div class="card-block px-3"><p class="card-title"><b>You are going to cancel this property to sell to Bidder '+response.bid_info.bidder_info.name+' at bid price of $'+f+'.<br> If you cancelled the escrow for this property the bidder '+response.bid_info.bidder_info.name+' can never place bid on this property and this bid blocked for this property.</b></p><p class="card-text">Bidder Name: '+response.bid_info.bidder_info.name+'</br>Bidder Email: '+response.bid_info.bidder_info.email+'</br>Closed Bid Price to Sold Property: $'+f+'</br> Property Price: $'+response.result.base_price+'</br> </p></div></div></div></div></div><p class="h6">Check Cancelled to update escrow status for this property.</p><label for="sold"><input type="radio" id="sold" name="check_escrow_status" class="check_escrow" value="Cancelled"><b> Cancelled </b></label>');
                        $('.update_close_of_ecsrow_btn').attr('data-property_id',getIdFromRow);
                        $('.update_close_of_ecsrow_btn').attr('data-bid_id',response.bid_info.id);
                        $('.update_close_of_ecsrow_btn').attr('data-bidder_id',response.bid_info.bidder_id);
                        
                        $("input[name=check_escrow_status][value=" + response.result.escrow_status + "]").prop('checked', true);
                    }
                  
                }else if(response.result.escrow_status == "Cancelled"){
                    
                    $('.addData').html('<label><input type="radio" name="check_escrow_status" class="check_escrow" value="Cancelled"> Cancelled</label><br><label><input type="radio" name="check_escrow_status" class="check_escrow" value="Active"> Active</label>');

                    $('.update_close_of_ecsrow_btn').attr('data-property_id',getIdFromRow);
                    $('.update_close_of_ecsrow_btn').attr('data-bid_id',response.bid_info.id);
                    $('.update_close_of_ecsrow_btn').attr('data-bidder_id',response.bid_info.bidder_id);
                        
                    $("input[name=check_escrow_status][value=" + response.result.escrow_status + "]").prop('checked', true);

                    $('.update_close_of_ecsrow_btn').attr('data-property_id',getIdFromRow);
                    $("input[name=check_escrow_status][value=" + response.result.escrow_status + "]").prop('checked', true);
                }else{
                    if(response.bid_status=="Awarded" ){
                        var f=response.bid_info.bid_price; 
                        console.log(response.bid_info);
                        $('.model_property_title').html("Property:"+response.result.title+"<br><small>Set Escrow Status Sold to sell out this property.</small>");
                        $('.addData').html('<div class="card"><div class="row"><div class="col-md-12"><div class="card-block px-3"><p class="card-title"><b>You are going to sold this property to Bidder '+response.bid_info.bidder_info.name+' at bid price of $'+f+' </b></p><p class="card-text">Bidder Name: '+response.bid_info.bidder_info.name+'</br>Bidder Email: '+response.bid_info.bidder_info.email+'</br>Highest Awarded Bid Price : $'+f+'</br> Property Price: $'+response.result.base_price+'</br> </p></div></div></div></div></div><p class="h6">Check Sold to update escrow status for this property.</p><label for="sold"><input type="radio" id="sold" name="check_escrow_status" class="check_escrow" value="Sold"><b> Sold </b></label>');
                        $('.update_close_of_ecsrow_btn').attr('data-property_id',getIdFromRow);
                        $('.update_close_of_ecsrow_btn').attr('data-bid_id',response.bid_info.id);
                        $('.update_close_of_ecsrow_btn').attr('data-bidder_id',response.bid_info.bidder_id);
                        
                        $("input[name=check_escrow_status][value=" + response.result.escrow_status + "]").prop('checked', true);
                    }
                } 
            }
            else {
               // alert('error');
            }
        }
    });

});

  var favorite="";

$('.update_close_of_ecsrow_btn').on('click',function(){
    favorite="";
    var propertyID=$(this).attr("data-property_id");
    var bid_id=$(this).attr("data-bid_id");
    var bidder_id=$(this).attr("data-bidder_id");
    //var parent = $(this).closest('.propertyEscrowContent');
    $.each($("input[name='check_escrow_status']:checked"), function(){
        favorite=$(this).val();
    });
    if(favorite!=""){
        $.ajax({
            type: "POST",
            data:{_token: "{{ csrf_token() }}",property_id:propertyID,bidder_id:bidder_id,bid_id:bid_id,escrow_status:favorite}, 
            url: "{{ route('admin-ajax-set-escrow-status') }}",
            beforeSend: function(){     
                $("#loading").show();
                $('.update_close_of_ecsrow_btn').text("Escrow Status Updating....");
                $('.update_close_of_ecsrow_btn').prop("disabled",true);
            },
            complete: function(){
                $("#loading").hide();
                $('.update_close_of_ecsrow_btn').text("Escrow Status Updated");
                $('.update_close_of_ecsrow_btn').prop("disabled",true);
                if(favorite=="Sold"){
                    $('.escrow_body_message').html("<h4>CONGRATULATIONS!</h4><p>The property has been sold</p>");
                    $('#propertyEscrowModal').modal('hide');
                    $('#escrow_Congratulation').modal('show');

                }else if(favorite=="Cancelled"){
                    $('.escrow_body_message').html('<p class="h4">The property escrow status cancelled</p>');
                    $('#propertyEscrowModal').modal('hide');
                    $('#escrow_Congratulation').modal('show'); 
                }

                location.reload();
            },
            success:function(response){
                if(response.status=="success") {
                    $('#propertyEscrowModal').modal('hide');
                    $.each($("input[name='check_escrow_status']"), function(){
                        $(this).attr('checked', false);
                    }); 
                    toastr.success(response.message);
                }
            }
        });
    }    
       
});
/////////////////////////////////////////////////////////////////
$(document).on('click', '.property_status', function(e)
{ 
        var status_class = $(this).attr('class');
        var id = $(this).attr('data-id');
        var change_btn = $(this);
        var url = "{{ route('admin-property-status-update') }}";
        
        if(status_class == "badge badge-danger property_status")
        {
            var newClass = "badge badge-success property_status";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger property_status";
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
                success: function (response){
                    if(response.status=="success"){
                        change_btn.html(status);
                        change_btn.removeClass(status_class).addClass(newClass);
                        toastr.success("Property status updated successfully");
                    }else{
                        toastr.error("To activate property status you have to upload atleast 5 featured images in gallery section.");
                    }
                   
                }         
            })
        } else {
            swal("Cancelled", "property is not change", "error");
        }
        });         
}); 
/////////////////////////////////////////////////////////////////
$(document).on('click', '.badge_status_change', function(e){ 
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
    var title ='Are you sure to '+status+' this property sale offer ?';
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
    } else {
        swal("Cancelled", "property sale offer is not change", "error");
    }
});         
}); 

$(document).on('click', '.badge_delete_status_change', function(e) { 

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
                 setTimeout(function () {
                   
                        location.reload(true);
                    
                    
                  }, 1000);
            },
            success: function (response){
                if (response.status == "200") {
                    jQuery('.rem_row_' + this_id).remove();
                    swal("Done!", "Row deleted succesfully!", "success");
                   

                } else {
                    swal("Error deleting!", "Please try again", "error");
                }
            }         
        })
    } else {
        swal("Cancelled", "Offer is not change", "error");
    }
});         
});

$(document).on('click', '.badge_delete_fav_property', function(e) { 
    var this_id = $(this).attr('data-id');
  
    var url = "{{ route('admin-fav-property-remove') }}";
    
    var title ='Are you sure to delete this row ?';
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
                     setTimeout(function () {
                   
                        location.reload(true);
                    
                    
                  }, 1000);
                },
                success: function (response){
                    if (response.status == "200") {
                         jQuery('.rem_row_' + this_id).remove();
                        
                          //var rowCount = $('#favPropertyTable tr').length;
                         // alert(rowCount);
                       //  $('.favPropertyCount').html(rowCount-1);
                       // $('#favPropertyTable').DataTable().draw();
                        swal("Done!", "Row deleted succesfully!", "success");
                      
                    } else {
                        swal("Error deleting!", "Please try again", "error");
                    }
                }         
            })
        } else {
            swal("Cancelled", "page is not change", "error");
        }
    });         
});

$(document).on('click', '.badge_delete_bid', function(e){
    var this_id = $(this).attr('id');
    var url = "{{ route('admin-bid-delete') }}";
    
    var title ='Are you sure to delete this row ?';
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
                 setTimeout(function () {
                   
                        location.reload(true);
                    
                    
                  }, 1000);
            },
            success: function (response){
                if (response.success == "1") {
                   // jQuery('.rem_row_' + this_id).remove();
                    //var rowCount = $('#bidTable tr').length;
                    // $('.bidsCount').html(rowCount-1);
                    $('#bidTable').DataTable().draw();
                    swal("Done!", "Row deleted succesfully!", "success");
                      
                } else {
                    swal("Error deleting!", "Please try again", "error");
                }
            }         
        })
    } else {
        swal("Cancelled", "page is not change", "error");
    }
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
                    } else {
                        swal("Cancelled", "Bids is not change", "error");
                    }
                });         
              }); 


                $(document).on('click', '.bid_badge_status_change', function(e)
                { 
                    var status_class = $(this).attr('class');
                    var id = $(this).attr('id');
                    var change_btn = $(this);
                    var url = "{{ route('admin-bid-enable-disable') }}";

                    if(status_class == "badge badge-danger bid_badge_status_change")
                    {
                        var newClass = "badge badge-success bid_badge_status_change";
                        var status = 'Active';
                    }else
                    {
                        var newClass = "badge badge-danger bid_badge_status_change";
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
                    } else {
                        swal("Cancelled", "Bids is not change", "error");
                    }
                });         
              }); 

</script>
@endsection