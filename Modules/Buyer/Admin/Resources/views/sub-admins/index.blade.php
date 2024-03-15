@extends('admin::layouts.master')
@section('title', 'Sub-Admin List')
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
                                    <h4>Sub Admin List</h4>
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
                                <li class="breadcrumb-item"><a href="{{route('admin-sub-admins')}}">Sub Admin List</a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary btn-round" href="{{route('admin-add-sub-admin')}}">Add Sub Admin</a>
            </div>
            <!-- Page-header end -->
            <div class="page-body">
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
            <div class="card-block">     
                <div class="dt-responsive table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th scope="col" class="sr-no">S.No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Pic</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($subadmin as $key => $user)
                            <tr class="rem_row_{{$user->id}}">
                                <th scope="row" class="sr-no">{{ $key +1 }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><img src="{{$user->profile_pic}}" height="50" width="50" alt="img" /></td>
                                {{--<td>
                                    <?php
                                    $arr = [];
                                    if (@$user->roles && count($user->roles) > 0) {
                                        foreach ($user->roles as $roles) {
                                            $arr[] = "<b>" . strtoupper($roles->name) . "</b>";
                                        }
                                    }
                                    echo implode(",", $arr);
                                    ?>
                                </td>--}}
                                <td>
                                    {{ date_format($user->created_at,"M d, Y")}}
                                </td>
                                <td scope="col">
                                    @if($user->status == 1) 
                                    <a onclick="" class="actions status_update" href="javascript:void(0);" data-status="0" data-slug="{{ $user->slug }}">
                                        <span class="badge badge-success">Active</span>
                                    </a> 
                                    @else 
                                    <a  onclick="" class="actions status_update" href="javascript:void(0);" data-status="1" data-slug="{{ $user->slug }}">
                                        <span class="badge badge-danger">Inactive</span>
                                    </a> 
                                    @endif 
                                </td>
                                <td class="action btn_modify">
                                    <a class="btn btn-sm btn-primary" href="{{ route('admin-view-sub-admin', [$user->slug]) }}" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('admin-edit-sub-admin',[$user->slug]) }}" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" id="{{$user->id}}" class="actions badge_delete_status_change btn btn-danger btn-sm" data-slug="{{ $user->slug }}" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                         @php $i++; @endphp
                         @endforeach 
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
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).on('click', '.badge_delete_status_change', function(e)
    { 
        var dataSlug = $(this).attr('data-slug');
        var this_id = $(this).attr('id');
        var url = "{{ route('admin-delete-sub-admin') }}";

        var title ='Are you sure to delete this user  ?';
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
                data: {_token: '{{ csrf_token() }}', slug: dataSlug},
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
                        swal("Done!", "User deleted succesfully!", "success");
                    } else {
                        swal("Error deleting!", "Please try again", "error");
                    }
                }         
            })
        } else {
            swal("Cancelled", "User is not change", "error");
        }
    });         
  });   

    jQuery(function () {
        jQuery("#dataTable").DataTable({
            'columnDefs': [{
                    'targets': [3,6], // column index (start from 0)
                    'orderable': false, // set orderable false for selected columns
                }]
            });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery(document).on("click", ".status_update", function () {
            var status = jQuery(this).attr("data-status");
            var slug = jQuery(this).attr("data-slug");
            var this_id = jQuery(this);
            jQuery.ajax({
                url: '{{ route("admin-sub-admin-status") }}',
                type: "POST",
                data: {_token: '{{ csrf_token() }}', status: status, slug: slug},
                dataType: "json",
                beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
                success: function (response) {
                    console.log(response);
                    if (response.status == "200") {
                        jQuery(this_id).attr("data-status", "0");
                        jQuery(this_id).html('<span class="badge badge-success">Active</span>');
                        swal("Done!", "Status update succesfully!", "success");
                    } else if (response.status == "201") {
                        jQuery(this_id).attr("data-status", "1");
                        jQuery(this_id).html('<span class="badge badge-danger">Deactive</span>');
                        swal("Done!", "Status update succesfully!", "success");
                    } else {
                        swal("Error deleting!", "Please try again", "error");
                    }
                    jQuery(".loading-box").hide();
                },
                error: function (xhr) {
                    swal("Error deleting!", "Please try again", "error");
                    //alert(xhr.statusText + xhr.responseText);
                    jQuery(".loading-box").hide();
                }
                
            });
        });

       
        jQuery(".reset-frm").on("click", function () {
            window.location.href = '<?php echo route('admin-sub-admins'); ?>';
        });
    });
</script>
@endsection