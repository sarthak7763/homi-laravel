@php $pic=getProfilePic(); @endphp

<div class="container">
<div class="row pt-2 headDiv">  
    <div class="col-md-2 leftDive"> 
      <a href="{{route('buyer-search-property') }}"><img class="mt-2" src="{{asset('storage'.getLogo())}}" width="148" /></a>  
    </div>  
    <div class="col-md-8 midDive">
      <nav class="navbar navbar-expand-lg p-0 mt-3">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            
            <li class="nav-item">
              <a class="nav-link" href="{{route('buyer-search-property')}}">Marketplace</a>
            </li>
          
              <li class="nav-item">
                <a class="nav-link" href="{{route('buyer-faq-page')}}">FAQ’s</a>
              </li>
           

            <li class="nav-item">
              <a class="nav-link" href="{{route('buyer-contact-us')}}">Contact Us</a>
            </li>
          </ul>
        </div>
      </nav>  
    </div>
    {{--   @php $notif=getNotification();@endphp
     <div class="col col-md-4 text-right BellIcon">
      <a href="#" class="text-center bell-sign" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell"></i>
        <label class="badge badge-info count_noifi_badge">@if($notif['count_unread_notification']>0) {{$notif['count_unread_notification']}} @endif</label>
      </a>--}}
   {{--    @if($notif['count_unread_notification']>0)
      <div class="dropdown-menu dropdown-menu-right">
         <ul class="navbar-nav">
          @php $str = "";  @endphp
          @forelse($notif['unread_notification'] as $k=>$notification)

             @if($notification->type=="App\Notifications\AdminAwardBidNotification")
                
              @php $routes=route('buyer-property-detail',$notification->data['property']['slug']); @endphp
        
              @php  $str = '<a href="'.$routes.'">Admin award bid</a>'; @endphp
          
            @endif

            @if($notification->type=="App\Notifications\AdminCancelledPropertyNotification")
              
              @php $routes=route('buyer-property-detail',$notification->data['property']['slug']); @endphp
              
              @php $str = '<a href="'.$routes.'">Admin '.$notification->data['user']['name'].' cancelled property.</a>'; @endphp
          
            @endif

            @if($notification->type=="App\Notifications\AdminCloseBidNotification")
              @php $routes=route('buyer-property-detail',$notification->data['property']['slug']); @endphp
              
              @php $money=moneyFormat($notification->data['bid']['bid_price']); @endphp
              @php $str = '<a href="'.$routes.'">Admin close bid</a>'; @endphp
          
            @endif

             @if($notification->type=="App\Notifications\AdminComplaintResponseNotification")
                @if(@$notification->data['complaint']['response_type']=="complaint")
                    @php $str = 'Admin respond the complaint please check your mail.'; @endphp
                @else
                    @php $str = 'Admin respond the enquiry please check your mail.'; @endphp
                @endif
          
          @endif

            @if($notification->type=="App\Notifications\AdminComplaintStatusNotification")
                
              
              @php $str = 'The complaint No.-'.$notification->data['complaint']['complaint_no'].' status is '.$notification->data['complaint']['complaint_status']; @endphp
          
          @endif


          @if($notification->type=="App\Notifications\AdminPublishPropertyNotification")

             @php $routes=route('buyer-property-detail',$notification->data['property']['slug']); @endphp
            @php $str = '<a href="'.$routes.'">Admin publish a property '.$notification->data['property']['title'].'</a>'; @endphp
          
          @endif

          @if($notification->type=="App\Notifications\AdminRejectBidNotification")
           @php $routes=route('buyer-property-detail',$notification->data['property']['slug']); @endphp
            @php $str = '<a href="'.$routes.'">Bid Rejected By Admin</a>'; @endphp
          
          @endif
           
          @if($notification->type=="App\Notifications\AdminSoldPropertyNotification")
                
              @php $routes=route('buyer-property-detail',$notification->data['property']['slug']); @endphp
              @php $str = '<a href="'.$routes.'">Admin award bid.</a>'; @endphp
          
          @endif

             <li class="nav-item border-bottom text-height-0">
                <div class="row rowmob">
                  <div class="col-md-10">
                    <p class="notifi-message small text-height-0">
                      {!!$str!!}<br> 
                      <small class="notification-time small">{{ $notification->created_at }}</small>
                    </p>
                  </div>
                  <div class="col-md-2">
                    <label class="badge badge-info notifi_time small mark-as-read" data-id="{{ $notification->id }}" title="Mark As Read">
                      <i class="fa fa-envelope"></i>
                    </label>
                  </div>
                </li>
              @empty--}}
               {{--<li class="list-group-item list-group-item-primary mb-2 pb-2">
                 There are no new notifications
              </li>--}}
          {{-- @endforelse
        </ul>
      </div>
      @endif
    </div>
    --}}

    <div class="col-md-2 text-right mt-2 rightDive">
      <a href="#" class="userCricle text-center text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{@$pic}}" class="userCricle"></a>
      <div class="dropdown-menu dropdown-menu-right">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{route('buyer-profile')}}">My Profile</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="{{route('buyer-search-property')}}">Marketplace</a></li>

          <li class="nav-item"><a class="nav-link" href="{{route('buyer-faq-page')}}">FAQ’s</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('buyer-contact-us')}}">Contact Us</a></li>
          @if(Auth::check())
          <li class="nav-item">
            <a class="nav-link logoutBtnA" href="{{ route('buyer_logout') }}" onclick="event.preventDefault(); document.getElementById('logout-forms').submit();">
                <i class="feather icon-log-out"></i>Logout
            </a>  
            <form id="logout-forms" action="{{ route('buyer_logout') }}" method="POST" style="display: none;">@csrf</form>  
          </li>
          @endif
         
        </ul>
      </div>
    </div>
  </div>
</div>
