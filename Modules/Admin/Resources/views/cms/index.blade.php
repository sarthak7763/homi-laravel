@extends('admin::layouts.master')
@section('title', 'Page List')
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
                                    <h4>Page List</h4>
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
                                    <li class="breadcrumb-item"><a href="{{route('admin-cms-page-list')}}">Page List</a> </li>                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-round" href="{{route('admin-cms-page-add')}}">Add Page</a>
                </div>
                <!-- Page-header end -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <!-- <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div> -->
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
                    </div>
                    <div class="card-block">
                       @if(isset($pageList))
                       <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Page Name</th>
                                    <th>Page Title</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pageList as $k=>$li)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$li->page_name}}</td>
                                    <td>{{$li->page_title}}</td>
                                    <td>
                                        @if($li->status==1)
                                        <label class="badge badge-success badge_status_change" id="{{$li->id}}">Active</label>
                                        @else
                                        <label class="badge badge-danger badge_status_change" id="{{$li->id}}">Inactive</label>
                                        @endif
                                    </td>
                                    <td>{{ date('M d, Y g:i A', strtotime($li->created_at))}}</td>
                                    <td class="btn_modify">
                                        @if(Auth::user()->hasRole('Admin')) 
                                        <a href="{{route('admin-cms-page-detail',$li->page_slug)}}" class="btn btn-warning btn-sm" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{route('admin-cms-page-edit',$li->page_slug)}}" title="Edit" class="btn btn-info btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @elseif(Auth::user()->hasRole('sub-admin'))

                                        @if(auth()->user()->can('admin-cms-page-detail'))
                                        <a href="{{route('admin-cms-page-detail',$li->page_slug)}}" class="btn btn-warning btn-sm" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endif

                                        @if(auth()->user()->can('admin-cms-page-edit'))
                                        <a href="{{route('admin-cms-page-edit',$li->page_slug)}}" title="Edit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endif
                                        @endif
                                    </td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">No Page Found</div>
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
<script>
    var oTable = $('#simpletable').dataTable( {
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 4 ] },
        { "bSearchable": false, "aTargets": [ 4] }
        ]
    });
    $(document).on('click', '.badge_status_change', function(e)
    { 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-page-status-update') }}";
        
        if(status_class == "badge badge-danger badge_status_change")
        {
            var newClass = "badge badge-success badge_status_change";
            var status = 'Active';
        }else
        {
            var newClass = "badge badge-danger badge_status_change";
            var status = 'Inactive';
        }
        var title ='Are you sure to '+status+' this page ?';
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
                        toastr.success("Page status active successfully");
                    }else{
                          toastr.error("Page status inactive successfully");
                    }
                    
                }         
            })
        }
        //  else {
        //     swal("Cancelled", "page is not change", "error");
        // }
    });         
  }); 


    $(document).on('click', '.badge_delete_status_change', function(e)
    { 
        var status_class = $(this).attr('class');
        var id = $(this).attr('id');
        var change_btn = $(this);
        var url = "{{ route('admin-page-delete') }}";

        if(status_class == "badge badge-danger")
        {
            var newClass = "badge badge-success badge_delete_status_change";
            var status = 'Not Deleted';
        }else
        {
            var newClass = "badge badge-danger";
            var status = 'Deleted';
        }
        var title ='Are you sure to delete this page ?';
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
                    toastr.error("Page deleted successfully");
                }         
            })
        } 
        // else {
        //     swal("Cancelled", "page is not change", "error");
        // }
    });
  });
</script>
@endsection