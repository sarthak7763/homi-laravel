@extends('admin::layouts.master')
@section('title', 'Property Type List')
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
                                    <h4>Property Type List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-property-type-list')}}">Property Type List</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-round" href="{{route('admin-property-type-add')}}">Add Property type</a>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
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
                    </div>
                    <div class="card-block">
                      @if(isset($propertyTypeList))
                      <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <!--<th>Icon</th>-->
                                    <th>Status</th>
                                    <!--<th>Delete Status</th>-->
                                    <!--<th>Created At</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($propertyTypeList as $k=>$li)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$li->name}}</td>
                                        {{-- <td> <img src="{{$li->icon}}" height="50" width="50" class="img-thumbnail"></td>--}}<td>
                                            @if($li->status==1)
                                            <label class="badge badge-success badge_status_change pointer" id="{{$li->id}}">Active</label>
                                            @else
                                            <label class="badge badge-danger badge_status_change pointer" id="{{$li->id}}">Inactive</label>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if($li->delete_status==1)
                                            <label class="badge badge-danger">Deleted</label>
                                            @else
                                            <label class="badge badge-info badge_delete_status_change" id="{{$li->id}}">Not Deleted</label>
                                            @endif
                                        </td>--}} 
                                        {{-- <td>{{ date('M d, Y g:i A', strtotime($li->created_at))}}</td>--}} 
                                        <td class="btn_modify">
                                            <a href="{{route('admin-property-type-detail',$li->slug)}}" title="View" class="btn btn-warning btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{route('admin-property-type-edit',$li->slug)}}" title="Edit" class="btn btn-info btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" title="Delete" data-id="{{$li->id}}" class="btn btn-danger btn-sm badge_delete_status_change">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                           
                                       </td>
                                       @endforeach
                                   </tbody>
                               </table>
                           </div>
                           @else
                           <div class="alert alert-danger">No property-type Found</div>
                           @endif
                       </div>
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
  var oTable = $('#simpletable').dataTable( {
    "aoColumnDefs": [
    { "bSortable": false, "aTargets": [  3 ] }, 
    { "bSearchable": false, "aTargets": [ 2,3 ] }
    ]
});   

  $(document).on('click', '.badge_status_change', function(e) { 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-property-type-status-update') }}";

        if(status_class == "badge badge-danger badge_status_change")
        {
            var newClass = "badge badge-success badge_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_status_change";
            var status = 'Inactive';
        }
        var title ='Are you sure to '+status+' this Property Type ?';
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
                            toastr.success("Property Type status active successfully");
                        }else{
                              toastr.error("Property Type status inactive successfully");
                        }
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "Property Type is not change:)", "error");
        // }
    });
}); 

$(document).on('click', '.badge_delete_status_change', function(e){ 
    var id = $(this).attr('data-id');
    var change_btn = $(this);
    var url = "{{ route('admin-property-type-delete') }}";

    var title ='Are you sure to delete this Property Type ?';
    e.preventDefault();      
    swal({
      title: title,
    text: "All Properties under this property type and all data related to that property removed and cannot be recovered in future.",
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
                 setTimeout(function () {
                    location.reload(true);
                  }, 1000);
            },
            success: function (data){

                toastr.error("Property type deleted successfully");
               
                
                
            }         
        })
    }
    //  else {
    //     swal("Cancelled", "Property Type is not deleted:)", "error");
    // }
});         
});   
</script>   
@endsection