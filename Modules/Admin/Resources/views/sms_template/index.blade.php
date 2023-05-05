@extends('admin::layouts.master')
@section('title', 'Sms Template List')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-4">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Sms Template list</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-sms-template-list')}}">Sms Template List</a> </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                 {{--       @if(Auth::user()->hasRole('Admin'))
                    <a class="btn btn-primary btn-round" href="{{route('admin-sms-template-add')}}">Add Sms Template</a> 
                    @elseif(Auth::user()->hasRole('sub-admin'))
                    @if(auth()->user()->can('admin-sms-template-add'))
                    <a class="btn btn-primary btn-round" href="{{route('admin-sms-template-add')}}">Add Sms Template</a> 
                    @endif
                    @endif --}}

                </div>
                <!-- Page-header end -->

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                   <!--  <h5>Hello Card</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                                    <!-- <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                        </ul>
                                    </div> -->
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
                        <div class="dt-responsive table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered nowrap">    
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Status</th>

                                        {{--<th>Body </th>--}}

                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(@$data as $k=>$li)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$li->name}}</td>
                                        {{--<td>{{$li->body}}</td>--}}
                                        <td>
                                            @if($li->status==1)
                                                <span class="badge badge-success badge_status_change" id="{{$li->id}}" style="cursor: pointer;">Active</span>
                                            @else
                                                <span class="badge badge-danger badge_status_change" id="{{$li->id}}"  style="cursor: pointer;">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="btn_modify">
                                            @if(Auth::user()->hasRole('Admin'))                                            
                                            <a href="{{route('admin-sms-template-edit',$li->id)}}" class="btn btn-info btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{route('admin-sms-template-show',$li->id)}}" class="btn btn-warning btn-sm" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @elseif(Auth::user()->hasRole('sub-admin'))
                                            @if(auth()->user()->can('admin-sms-template-show'))
                                            <a href="{{route('admin-sms-template-show',$li->id)}}" class="btn btn-warning btn-sm" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @endif
                                            @if(auth()->user()->can('admin-sms-template-edit'))
                                            <a href="{{route('admin-sms-template-edit',$li->id)}}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endif

                                            @endif
                                        </td>
                                    </tr>
                                    @empty 

                                    @endforelse    
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
</div>                    
@endsection   
@section('js')
<script type="text/javascript">

   jQuery(function () {
    jQuery("#dataTable").DataTable( {
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 3 ] }, 
        { "bSearchable": false, "aTargets": [ 3 ] }
        ]
    });
});



    $(document).on('click', '.badge_status_change', function(e)
    { 
            var status_class = $(this).attr('class');
            var id = $(this).attr('id');
            var change_btn = $(this);
            var url = "{{ route('admin-sms-template-status-update') }}";
            
            if(status_class == "badge badge-danger badge_status_change")
            {
                var newClass = "badge badge-success badge_status_change";
                var status = 'Active';
            }else
            {
                var newClass = "badge badge-danger badge_status_change";
                var status = 'Inactive';
            }
           var title ='Are you sure to set status as '+status+' for this sms template ?';
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
                           
                            if(status=="Active"){
                            toastr.success("SMS template status active successfully");
                        }else{
                              toastr.error("SMS template status inactive successfully");
                        }
                        }
                       
                    }         
                })
            } 
            // else {
            //     swal("Cancelled", "SMS template status is not change", "error");
            // }
            });         
    }); 

</script>
@endsection