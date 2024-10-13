@extends('admin::layouts.master')
@section('title', 'Seller Subscription')

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
                                    <h4>Manage Seller Subscription List</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                     <li class="breadcrumb-item">
                                        <a href=""> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('admin-seller-subscription-list')}}">Seller Subscription List</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->
                <div class="page-body">
                   
                            <div class="card my-1">
                                <div class="card-block collapse mt-3"  id="collapseExample">
                                    <div class="row">       
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
                                        <table id="datatable" class="table table table-styling table-bordered nowrap" style="width:100%">
                                            <thead>
                                            <tr class="table-primary">
                                                <th>S.No</th>
                                                <th>Seller Name</th>
                                                <th>Subscription Plan</th>
                                                
                                                <th>Fund Amount</th>
                                                <th>Fund Screenshot</th>
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
  $(function () {
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: false,
            responsive: false,
            autoWidth: false,
            scrollCollapse: true,
            ajax: {
            url: "{{ route('admin-seller-subscription-list') }}",
            type: "GET"
            },
            
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
           {data: 'seller name', name: 'seller name'},
            {data: 'subscription plan', name: 'subscription plan'},
            
            {data: 'fund amount', name: 'fund amount'},
            {data: 'fund screenshot', name: 'fund screenshot'},
            {data: 'action', name: 'action' , orderable: false, searchable: false},
        ]
        });
    }); 
    
    

    $(document).on('click','.badge_subscription_status_change', function(e)
    { 
        
        var status_class = $(this).attr('class');
        
        var id = $(this).attr('id');
        var change_btn = $(this);
        
        var url = "{{ route('admin-seller-subscription-status-change')}}";

        if(status_class == "badge badge-danger badge_subscription_status_change")
            {
                var newClass = "badge badge-success badge_subscription_status_change";
                var status = 'Active';
                
            }else
            {
                var newClass = "badge badge-danger badge_subscription_status_change";
                var status = 'Pending';
            }
            var title ='Are you sure to '+status+' this Subscription ?';
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
                    url: "{{ route('admin-seller-subscription-status-change')}}",
                    data: {_token: "{{ csrf_token() }}",id:id},
                    dataType: "json",
                
                    success: function (data){
                        

                        
                        if(data.success==1){
                            change_btn.html(status);
                            change_btn.removeClass(status_class).addClass(newClass);
                            if(status=="Active"){
                             toastr.success("Subscription status active successfully");
                            }else{
                                  toastr.error("Subscription status pending successfully");
                            }
                            
                        }
                        
                       
                    }         
                })
            } 
           
            }); 

        });     

     


</script>   
@endsection
