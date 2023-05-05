@extends('admin::layouts.master')
@section('title', 'Notifications')
@section('css')

@endsection
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
             <div class="page-wrapper">
                <div class="page-body">  
                    <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item">Notifications   
                                {{-- @if(@$unread_notifications->count() > 0)<button id="mark-all" class="float-right mr-3">
                                    Mark all as read
                                </button>
                                @endif --}}
                               <!--  <button href="" id="all" class="float-right mr-3">All</button>
                                --> 
                                @if(count($notifications)>0)
                                <button id="deleteNotifi" class="float-right mr-3">
                                    Remove All Notification
                                </button>
                                @endif
                                <button href="" id="read" class="float-right mr-3">
                                    Read
                                </button>
                                <button href="" id="unread" class="float-right mr-3">
                                    Unread
                                </button>
                               
                            </li>
                            <div class="allNotifDivparent">
                                <div class="ReadDiv" style="display: none;">
                                    @php $str = "";  @endphp
                                    @forelse($read_notifications as $k=>$notification)
                                        @if($notification->type=="App\Notifications\BuyerAddNotification")
                                            @php $routes=route('admin-user-details',$notification->data['user']['id']); @endphp
                                         
                                            @php $str = '<a href="'.$routes.'">New Buyer '.$notification->data['user']['name'].'  has registered.</a>'; @endphp
                                        
                                        @endif
                                        @if($notification->type=="App\Notifications\BuyerAddBidNotification")
                                            @php $routes=route('admin-bid-view',$notification->data['bid']['id']); @endphp
                                            
                                            @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
                                            @php $str = '<a href="'.$routes.'">New Bid of '.$money.' has been place by buyer '.$notification->data['user']['name'].'.</a>'; @endphp
                                        
                                        @endif
                                         @if($notification->type=="App\Notifications\BuyerUpdateBidNotification")
                                            @php $routes=route('admin-bid-view',$notification->data['bid']['id']); @endphp
                                            
                                            @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
                                            @php $str = '<a href="'.$routes.'">Bid price '.$money.' updated by buyer '.$notification->data['user']['name'].'.</a>'; @endphp
                                        
                                        @endif
                                      
                                         @if($notification->type=="App\Notifications\BuyerComplaintNotification")
                                            @php $routes=route('admin-complaint-detail',$notification->data['complaint']['id']); @endphp
                                            
                                         
                                            @php $str = '<a href="'.$routes.'">Buyer '.$notification->data['user']['name'].' placed a complaint.</a>'; @endphp
                                        
                                        @endif

                                         @if($notification->type=="App\Notifications\BuyerEnquiryNotification")
                                            @php $routes=route('admin-enquiry-detail',$notification->data['enquiry']['id']); @endphp
                                            
                                          
                                             @php $str = '<a href="'.$routes.'">Buyer '.$notification->data['user']['name'].' placed an enquiry message.</a>'; @endphp
                                        
                                        @endif



                                        <li class="list-group-item list-group-item-light mb-1 pb-0">
                                            <p>{!!$str!!}<br> 
                                                <small class="notification-time">{{ date('M d, Y g:i A', strtotime($notification->created_at)) }}</small>
                                           
                                            </p>
                                        </li>
                                        @empty
                                         <li class="list-group-item list-group-item-primary mb-2 pb-2">
                                            No Notifications
                                        </li>
                                    @endforelse
                                </div>
                                <div class="UnreadDiv">
                              
                                    @forelse($unread_notifications as $k=>$notification)
                                     @if($notification->type=="App\Notifications\BuyerAddNotification")
                                            @php $routes=route('admin-user-details',$notification->data['user']['id']); @endphp
                                         
                                            @php $str = '<a href="'.$routes.'">New Buyer '.$notification->data['user']['name'].'  has registered.</a>'; @endphp
                                        
                                        @endif
                                        @if($notification->type=="App\Notifications\BuyerAddBidNotification")
                                            @php $routes=route('admin-bid-view',$notification->data['bid']['id']); @endphp
                                            
                                            @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
                                            @php $str = '<a href="'.$routes.'">New Bid of '.$money.' has been place by buyer '.$notification->data['user']['name'].'.</a>'; @endphp
                                        
                                        @endif
                                         @if($notification->type=="App\Notifications\BuyerUpdateBidNotification")
                                            @php $routes=route('admin-bid-view',$notification->data['bid']['id']); @endphp
                                            
                                            @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
                                            @php $str = '<a href="'.$routes.'">Bid price '.$money.' updated by buyer '.$notification->data['user']['name'].'.</a>'; @endphp
                                        
                                        @endif
                                      
                                         @if($notification->type=="App\Notifications\BuyerComplaintNotification")
                                            @php $routes=route('admin-complaint-detail',$notification->data['complaint']['id']); @endphp
                                            
                                         
                                            @php $str = '<a href="'.$routes.'">Buyer '.$notification->data['user']['name'].' placed a complaint.</a>'; @endphp
                                        
                                        @endif

                                         @if($notification->type=="App\Notifications\BuyerEnquiryNotification")
                                            @php $routes=route('admin-enquiry-detail',$notification->data['enquiry']['id']); @endphp
                                            
                                          
                                             @php $str = '<a href="'.$routes.'">Buyer '.$notification->data['user']['name'].' placed an enquiry message.</a>'; @endphp
                                        
                                        @endif
                                        <li class="list-group-item list-group-item-primary mb-1 pb-0">
                                           <p>{!!$str!!}<br> 
                                                <small class="notification-time">{{ date('M d, Y g:i A', strtotime($notification->created_at)) }}</small>
                                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                                    Mark as read
                                                </a>
                                            </p>
                                        </li>
                                    @empty
                                        <li class="list-group-item list-group-item-primary mb-2 pb-2">
                                            No Unread Notifications
                                        </li>
                                    @endforelse
                                   
                                </div>
                               {{-- <div class="AllDiv" style="display: none;"> 
                                    @forelse($notifications as $k=>$notification)
                                        @if($notification->read_at  == Null)
                                            @if($notification->type=="App\Notifications\BuyerAddNotification")
                                            @php $routes=route('admin-user-details',$notification->data['user']['id']); @endphp
                                         
                                            @php $str = '<a href="'.$routes.'">New Buyer '.$notification->data['user']['name'].'  has registered.</a>'; @endphp
                                        
                                        @endif
                                        @if($notification->type=="App\Notifications\BuyerAddBidNotification")
                                            @php $routes=route('admin-bid-view',$notification->data['bid']['id']); @endphp
                                            
                                            @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
                                            @php $str = '<a href="'.$routes.'">New Bid of '.$money.' has been place by buyer '.$notification->data['user']['name'].'.</a>'; @endphp
                                        
                                        @endif
                                         @if($notification->type=="App\Notifications\BuyerUpdateBidNotification")
                                            @php $routes=route('admin-bid-view',$notification->data['bid']['id']); @endphp
                                            
                                            @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
                                            @php $str = '<a href="'.$routes.'">Bid price '.$money.' updated by buyer '.$notification->data['user']['name'].'.</a>'; @endphp
                                        
                                        @endif
                                      
                                         @if($notification->type=="App\Notifications\BuyerComplaintNotification")
                                            @php $routes=route('admin-complaint-detail',$notification->data['complaint']['id']); @endphp
                                            
                                         
                                            @php $str = '<a href="'.$routes.'">Buyer '.$notification->data['user']['name'].' placed a complaint.</a>'; @endphp
                                        
                                        @endif

                                         @if($notification->type=="App\Notifications\BuyerEnquiryNotification")
                                            @php $routes=route('admin-enquiry-detail',$notification->data['enquiry']['id']); @endphp
                                            
                                          
                                             @php $str = '<a href="'.$routes.'">Buyer '.$notification->data['user']['name'].' placed an enquiry message.</a>'; @endphp
                                        
                                        @endif
                                        <li class="list-group-item list-group-item-primary mb-1 pb-0">
                                           <p>{!!$str!!}<br> 
                                                <small class="notification-time">{{ date('M d, Y g:i A', strtotime($notification->created_at)) }}</small>
                                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                                    Mark as read
                                                </a>
                                            </p>
                                        </li>
                                        @else
                                           @if($notification->type=="App\Notifications\BuyerAddNotification")
                                            @php $routes=route('admin-user-details',$notification->data['user']['id']); @endphp
                                         
                                            @php $str = '<a href="'.$routes.'">New Buyer '.$notification->data['user']['name'].'  has registered.</a>'; @endphp
                                        
                                        @endif
                                        @if($notification->type=="App\Notifications\BuyerAddBidNotification")
                                            @php $routes=route('admin-bid-view',$notification->data['bid']['id']); @endphp
                                            
                                            @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
                                            @php $str = '<a href="'.$routes.'">New Bid of '.$money.' has been place by buyer '.$notification->data['user']['name'].'.</a>'; @endphp
                                        
                                        @endif
                                         @if($notification->type=="App\Notifications\BuyerUpdateBidNotification")
                                            @php $routes=route('admin-bid-view',$notification->data['bid']['id']); @endphp
                                            
                                            @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
                                            @php $str = '<a href="'.$routes.'">Bid price '.$money.' updated by buyer '.$notification->data['user']['name'].'.</a>'; @endphp
                                        
                                        @endif
                                      
                                         @if($notification->type=="App\Notifications\BuyerComplaintNotification")
                                            @php $routes=route('admin-complaint-detail',$notification->data['complaint']['id']); @endphp
                                            
                                         
                                            @php $str = '<a href="'.$routes.'">Buyer '.$notification->data['user']['name'].' placed a complaint.</a>'; @endphp
                                        
                                        @endif

                                         @if($notification->type=="App\Notifications\BuyerEnquiryNotification")
                                            @php $routes=route('admin-enquiry-detail',$notification->data['enquiry']['id']); @endphp
                                            
                                          
                                             @php $str = '<a href="'.$routes.'">Buyer '.$notification->data['user']['name'].' placed an enquiry message.</a>'; @endphp
                                        
                                        @endif
                                        <li class="list-group-item list-group-item-light mb-1 pb-0">
                                           <p>{!!$str!!}<br> 
                                                <small class="notification-time">{{ date('M d, Y g:i A', strtotime($notification->created_at)) }}</small>
                                            </p>
                                        </li>
                                        @endif

                                        
                                      
                                    @empty
                                        <li class="list-group-item list-group-item-primary mb-2 pb-2">
                                            No notifications
                                        </li>
                                    @endforelse
                                </div>--}}
                            </div>
                        </ul>
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
$(document).ready(function () {

$("#deleteNotifi").click(function () {
   $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}"}, 
        url: "{{ route('admin-notification-delete-all') }}",
         beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
        success:function(result){
            if(result) {
                toastr.success("Notification Deleted Successfully");
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            } 
        }
    });
});

    $("#read").click(function () {

        $(".ReadDiv").show();
        $(".UnreadDiv").hide();
       // $(".AllDiv").hide();
    });

    $("#unread").click(function () {

        $(".UnreadDiv").show();
       // $(".AllDiv").hide();
        $(".ReadDiv").hide();
    });
});


    function sendMarkRequest(id = null) {
        return $.ajax("{{ route('admin.markNotification') }}", {
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id:id
            }
        });
    }

    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));

            request.done(() => {
                $(this).parents('li').remove();
            });
        });

        $('#mark-all').click(function() {
            let request = sendMarkRequest();

            request.done(() => {
               // $('li').remove();
            })
        });
    });
    </script>
@endsection