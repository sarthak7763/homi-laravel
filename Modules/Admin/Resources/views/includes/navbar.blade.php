<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        @php  $getRoute=Request::route()->getName(); @endphp
        <ul class="pcoded-item pcoded-left-item">

        @if(Auth::user()->hasRole('Admin'))
            <!-- <li class="{{ (\Request::route()->getName() == 'admin-dashboard') ? 'active' : '' }}">
                <a href="{{route('admin-dashboard')}}">
                    <span class="pcoded-micon"><i class="fa fa-tachometer"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li> -->

            <li class="{{ (\Request::route()->getName() == 'admin-user-list') ? 'active' : '' }}">
                <a href="{{route('admin-user-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                    <span class="pcoded-mtext">Manage Users</span>
                </a>
            </li>

            <li class="{{ (\Request::route()->getName() == 'admin-category-list') ? 'active' : '' }}">
                <a href="{{route('admin-category-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-pagelines"></i></span>
                    <span class="pcoded-mtext">Manage Category</span>
                </a>
            </li>

            <li class="{{ (\Request::route()->getName() == 'admin-propertyOwner-list') ? 'active' : '' }}">
                <a href="{{route('admin-propertyOwner-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                    <span class="pcoded-mtext">Manage Property Owners</span>
                </a>
            </li>

            <!-- <li class="{{ (\Request::route()->getName() == 'admin-owners-list') ? 'active' : '' }}">
                <a href="{{route('admin-owners-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-credit-card"></i></span>
                    <span class="pcoded-mtext">Manage Owners</span>
                </a>
            </li> -->

           <!--  <li class="{{ (\Request::route()->getName() == 'admin-subscription-list') ? 'active' : '' }}">
                <a href="{{route('admin-subscription-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-pagelines"></i></span>
                    <span class="pcoded-mtext">Manage Subscription</span>
                </a>
            </li> -->

            <!-- <li class="pcoded-hasmenu @if(($getRoute == 'admin-property-list') || ($getRoute == 'admin-property-add') ||  ($getRoute == 'admin-pending-property-list')) pcoded-trigger active @endif">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-building"></i></span>
                    <span class="pcoded-mtext">Manage Properties</span>
                </a>
                <ul class="pcoded-submenu">
                  <li class="@if(($getRoute =='admin-property-list' )) active @endif">
                        <a href="{{route('admin-property-list')}}">
                            <span class="pcoded-mtext">All Property</span>
                        </a>
                    </li>
                    <li class="@if(($getRoute == 'admin-pending-property-list') ) active @endif">
                        <a href="{{route('admin-pending-property-list')}}">
                            <span class="pcoded-mtext">Pending Property</span>
                        </a>
                    </li>
                   
                </ul>
            </li> -->

            <li class="{{ (\Request::route()->getName() == 'admin-cms-page-list') ? 'active' : '' }}">
                <a href="{{route('admin-cms-page-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                    <span class="pcoded-mtext">CMS</span>
                </a>
            </li>

            <!-- <li class="{{ (\Request::route()->getName() == 'admin-owners-list') ? 'active' : '' }}">
                <a href="#">
                    <span class="pcoded-micon"><i class="fa fa-bell"></i></span>
                    <span class="pcoded-mtext">Notifications</span>
                </a>
            </li> -->
           
            <!-- <li class="{{ (\Request::route()->getName() == 'admin-owners-list') ? 'active' : '' }}">
                <a href="#">
                    <span class="pcoded-micon"><i class="fa fa-credit-card"></i></span>
                    <span class="pcoded-mtext">Manage Payments</span>
                </a>
            </li>

            <li class="{{ (\Request::route()->getName() == 'admin-owners-list') ? 'active' : '' }}">
                <a href="#">
                    <span class="pcoded-micon"><i class="fa fa-book"></i></span>
                    <span class="pcoded-mtext">Manage Bookings</span>
                </a>
            </li>
            <li class="{{ (\Request::route()->getName() == 'admin-owners-list') ? 'active' : '' }}">
                <a href="#">
                    <span class="pcoded-micon"><i class="fa fa-pagelines"></i></span>
                    <span class="pcoded-mtext">Manage Subscription</span>
                </a>
            </li>
           
            <li class="{{ (\Request::route()->getName() == 'admin-owners-list') ? 'active' : '' }}">
                <a href="#">
                    <span class="pcoded-micon"><i class="fa fa-search"></i></span>
                    <span class="pcoded-mtext">Manage Search</span>
                </a>
            </li>
            
            <li class="{{ (\Request::route()->getName() == 'admin-owners-list') ? 'active' : '' }}">
                <a href="#">
                    <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                    <span class="pcoded-mtext">CMS Screens</span>
                </a>
            </li> -->

       
        
        @elseif(Auth::user()->hasRole('sub-admin'))

            {{--_______SUB ADMIN NAV_________--}}
              @if(auth()->user()->can('admin-dashboard') || 
            auth()->user()->can('admin-revenue-graph-post'))
             <li class="{{ (\Request::route()->getName() == 'admin-dashboard') ? 'active' : '' }}">
                <a href="{{route('admin-dashboard')}}">
                    <span class="pcoded-micon"><i class="fa fa-tachometer"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
             @endif
           {{--_________PROPERTY NAV START_________--}}
            @if(auth()->user()->can('admin-user-details') || 
            auth()->user()->can('admin-user-list') || 
            auth()->user()->can('admin-user-add') || 
            auth()->user()->can('admin-user-edit') || 
            auth()->user()->can('admin-user-delete') ||
            auth()->user()->can('admin-user-save') ||
            auth()->user()->can('admin-user-update') ||  
            auth()->user()->can('admin-user-status-update'))
                
                <li class="{{ (\Request::route()->getName() == 'admin-user-list') ? 'active' : '' }}">
                    <a href="{{route('admin-user-list')}}">
                        <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                        <span class="pcoded-mtext">Buyers</span>
                    </a>
                </li>
            
            @endif

              {{--_________BIDS NAV START___________--}}

            @if(auth()->user()->can('admin-bid-delete') || 
            auth()->user()->can('admin-bid-status-update') || 
            auth()->user()->can('admin-bid-list') ||
            auth()->user()->can('admin-bid-view'))
            <li class="@if($getRoute == 'admin-bid-list')  active @endif">
                <a href="{{route('admin-bid-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-gavel"></i></span>
                    <span class="pcoded-mtext">Bids</span>
                </a>
           </li>
            @endif

            {{--________SALES TIMER NAV START__________--}}

            @if(auth()->user()->can('admin-property-sales-detail-show') || 
            auth()->user()->can('admin-property-sales-delete-status') || 
            auth()->user()->can('admin-property-sales-edit') ||
            auth()->user()->can('admin-property-sales-add') ||
            auth()->user()->can('admin-property-sales-list'))
             <li class="@if($getRoute == 'admin-property-sales-list')  active @endif">
                <a href="{{route('admin-property-sales-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-balance-scale"></i></span>
                    <span class="pcoded-mtext">Property Timer</span>
                </a>
           </li>
            @endif
 
            {{--___________PROPERTY NAV START_______--}}

            @if(auth()->user()->can('admin-property-list') || 
            auth()->user()->can('admin-property-add') || 
            auth()->user()->can('admin-property-edit') || 
            auth()->user()->can('admin-property-delete') || 
            auth()->user()->can('admin-property-details') ||  
            auth()->user()->can('admin-property-status-update'))

            <li class="pcoded-hasmenu @if(($getRoute == 'admin-property-list') || ($getRoute == 'admin-property-add') ||  ($getRoute == 'admin-pending-property-list')) pcoded-trigger active @endif">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-building"></i></span>
                    <span class="pcoded-mtext">Properties</span>
                </a>
                <ul class="pcoded-submenu">
                  <li class="@if(($getRoute =='admin-property-list' )) active @endif">
                        <a href="{{route('admin-property-list')}}">
                            <span class="pcoded-mtext">All Property</span>
                        </a>
                    </li>
                    <li class="@if(($getRoute == 'admin-pending-property-list') ) active @endif">
                        <a href="{{route('admin-pending-property-list')}}">
                            <span class="pcoded-mtext">Pending Property</span>
                        </a>
                    </li>
                   
                </ul>
            </li>

            @endif

            {{--__________PROPERTY TYPE NAV START________--}}
            @if(auth()->user()->can('admin-property-type-list') || 
            auth()->user()->can('admin-property-type-add') || 
            auth()->user()->can('admin-property-type-edit') || 
            auth()->user()->can('admin-property-type-delete') || 
            auth()->user()->can('admin-property-type-detail') ||  
            auth()->user()->can('admin-property-type-status-update'))
            <li class="{{ (\Request::route()->getName() == 'admin-property-type-list') ? 'active' : '' }}">
                <a href="{{route('admin-property-type-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-sitemap"></i></span>
                    <span class="pcoded-mtext">Property Type</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->can('admin-country-list') || 
            auth()->user()->can('admin-country-add') || 
            auth()->user()->can('admin-country-edit') || 
            auth()->user()->can('admin-country-delete-status') || 
            auth()->user()->can('admin-country-status-update')|| auth()->user()->can('admin-state-list') || 
            auth()->user()->can('admin-state-add') || 
            auth()->user()->can('admin-state-edit') || 
            auth()->user()->can('admin-state-delete-status') || 
            auth()->user()->can('admin-state-status-update') || auth()->user()->can('admin-city-list') || 
            auth()->user()->can('admin-city-add') || 
            auth()->user()->can('admin-city-edit') || 
            auth()->user()->can('admin-city-delete-status') || 
            auth()->user()->can('admin-city-status-update'))

             <li class="pcoded-hasmenu @if(($getRoute == 'admin-country-list') || ($getRoute == 'admin-country-add') || ($getRoute == 'admin-state-list')|| ($getRoute == 'admin-state-add')|| ($getRoute == 'admin-city-list')|| ($getRoute == 'admin-city-add')) pcoded-trigger active @endif">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-map-marker"></i></span>
                    <span class="pcoded-mtext">Location</span>
                </a>
                <ul class="pcoded-submenu">
                   {{-- @if(auth()->user()->can('admin-country-list') || 
                    auth()->user()->can('admin-country-add') || 
                    auth()->user()->can('admin-country-edit') || 
                    auth()->user()->can('admin-country-delete-status') || 
                    auth()->user()->can('admin-country-status-update'))

           
                    <li class="@if(($getRoute == 'admin-country-list') || ($getRoute == 'admin-country-add')) active @endif">
                        <a href="{{route('admin-country-list')}}">
                            <span class="pcoded-mtext">Country</span>
                        </a>
                    </li>
                    @endif--}} 
                    @if(auth()->user()->can('admin-state-list') || 
                    auth()->user()->can('admin-state-add') || 
                    auth()->user()->can('admin-state-edit') || 
                    auth()->user()->can('admin-state-delete-status') || 
                    auth()->user()->can('admin-state-status-update'))


                    <li class="@if(($getRoute == 'admin-state-list') || ($getRoute == 'admin-state-add')) active @endif">
                        <a href="{{route('admin-state-list')}}">
                            <span class="pcoded-mtext">State</span>
                        </a>
                    </li>
                    @endif
                    @if(auth()->user()->can('admin-city-list') || 
                    auth()->user()->can('admin-city-add') || 
                    auth()->user()->can('admin-city-edit') || 
                    auth()->user()->can('admin-city-delete-status') || 
                    auth()->user()->can('admin-city-status-update'))

                    <li class="@if(($getRoute == 'admin-city-list') || ($getRoute == 'admin-city-add')) active @endif">
                        <a href="{{route('admin-city-list')}}">
                            <span class="pcoded-mtext">City</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
              @endif

               {{--________EMAIL TEMPLATE NAV START_____--}}

            @if(auth()->user()->can('admin-mail-template-list') || 
            auth()->user()->can('admin-mail-template-add') || 
            auth()->user()->can('admin-mail-template-edit') || 
            auth()->user()->can('admin-mail-template-show'))

             <li class="pcoded-hasmenu @if(($getRoute == 'admin-mail-template-list') || ($getRoute == 'admin-mail-template-add') || ($getRoute == 'admin-sms-template-list') || ($getRoute == 'admin-sms-template-add')) pcoded-trigger active @endif">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-envelope"></i></span>
                    <span class="pcoded-mtext">Templates</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="@if(($getRoute =='admin-mail-template-list') || ($getRoute == 'admin-mail-template-add')) active @endif">
                        <a href="{{route('admin-mail-template-list')}}">
                            <span class="pcoded-mtext">E-Mail</span>
                        </a>
                    </li>
                    <li class="@if(($getRoute == 'admin-sms-template-list') || ($getRoute == 'admin-sms-template-add')) active @endif">
                        <a href="{{route('admin-sms-template-list')}}">
                            <span class="pcoded-mtext">SMS</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->can('admin-global-sms-send-post') || 
            auth()->user()->can('admin-global-sms-send') || 
            auth()->user()->can('admin-get-ajax-sms-template'))
            <li class="{{ (\Request::route()->getName() == 'admin-global-sms-send') ? 'active' : '' }}">
                <a href="{{route('admin-global-sms-send')}}">
                    <span class="pcoded-micon"><i class="fa fa-comments"></i></span>
                    <span class="pcoded-mtext">Send SMS</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->can('admin-global-mail-send-post') || 
            auth()->user()->can('admin-global-mail-send') || 
            auth()->user()->can('admin-get-ajax-mail-template'))
            <li class="{{ (\Request::route()->getName() == 'admin-global-mail-send') ? 'active' : '' }}">
                <a href="{{route('admin-global-mail-send')}}">
                    <span class="pcoded-micon"><i class="fa fa-comments"></i></span>
                    <span class="pcoded-mtext">Send Mail</span>
                </a>
            </li>
            @endif

            
            {{--________CMS PAGE NAV START________--}}
            @if(auth()->user()->can('admin-cms-page-list') || 
            auth()->user()->can('admin-cms-page-add') || 
            auth()->user()->can('admin-cms-page-edit') || 
            auth()->user()->can('admin-cms-page-detail') || 
            auth()->user()->can('admin-page-status-update'))
            <li class="{{ (\Request::route()->getName() == 'admin-cms-page-list') ? 'active' : '' }}">
                <a href="{{route('admin-cms-page-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                    <span class="pcoded-mtext">CMS</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->can('admin-faq-list') || 
            auth()->user()->can('admin-faq-add') || 
            auth()->user()->can('admin-faq-save') || 
            auth()->user()->can('admin-faq-edit') || 
            auth()->user()->can('admin-faq-status-update') || 
            auth()->user()->can('admin-faq-delete') || 
            auth()->user()->can('admin-faq-update'))
            <li class="{{ (\Request::route()->getName() == 'admin-faq-list') ? 'active' : '' }}">
                <a href="{{route('admin-faq-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                    <span class="pcoded-mtext">FAQ</span>
                </a>
            </li>
             @endif
           

            {{--_________REASON NAV START_______--}}

           
            {{--__________ENQUIRY COMPLAINT NAV START___________--}}

            @if(auth()->user()->can('admin-user-complaint-list') || 
            auth()->user()->can('admin-complaint-detail') || 
            auth()->user()->can('admin-user-complaint-delete')||
            auth()->user()->can('admin-user-enquiry-list') || 
            auth()->user()->can('admin-user-enquiry-detail') || 
            auth()->user()->can('admin-reason-list') || 
            auth()->user()->can('admin-reason-add') || 
            auth()->user()->can('admin-reason-edit') || 
            auth()->user()->can('admin-user-enquiry-delete'))
            <li class="pcoded-hasmenu @if(($getRoute == 'admin-user-complaint-list') || ($getRoute == 'admin-user-complaint-add') ||  ($getRoute == 'admin-user-enquiry-add')  || ($getRoute == 'admin-user-enquiry-list') ||  ($getRoute == 'admin-reason-add') ||  ($getRoute == 'admin-reason-list')) pcoded-trigger active @endif">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-volume-control-phone"></i></span>
                    <span class="pcoded-mtext">Support</span>
                </a>
                <ul class="pcoded-submenu">
                    @if(auth()->user()->can('admin-reason-list') || 
                        auth()->user()->can('admin-reason-add') || 
                        auth()->user()->can('admin-reason-edit'))
                        <li class="@if(($getRoute == 'admin-reason-list') || ($getRoute == 'admin-reason-add')) active @endif">
                            <a href="{{route('admin-reason-list')}}">
                                <span class="pcoded-mtext">Reason</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->can('admin-user-complaint-list') || 
                    auth()->user()->can('admin-complaint-detail') || 
                    auth()->user()->can('admin-user-complaint-delete'))
                    {{-- <li class="@if(($getRoute == 'admin-user-complaint-list') || ($getRoute == 'admin-user-complaint-add')) active @endif">
                        <a href="{{route('admin-user-complaint-list')}}">
                            <span class="pcoded-mtext">Complaint</span>
                        </a>
                    </li>--}}
                    @endif
                    @if(auth()->user()->can('admin-user-enquiry-list') || 
                    auth()->user()->can('admin-user-enquiry-detail') || 
                    auth()->user()->can('admin-user-enquiry-delete'))
                    <li class="@if(($getRoute == 'admin-user-enquiry-add') || ($getRoute == 'admin-user-enquiry-list')) active @endif">
                        <a href="{{route('admin-user-enquiry-list')}}">
                            <span class="pcoded-mtext">Enquiry</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif    
          

            @if(auth()->user()->can('admin-user-restore') || 
            auth()->user()->can('admin-destroy-user') || 
            auth()->user()->can('admin-soft-deleted-user-list') || auth()->user()->can('admin-property-restore') || 
            auth()->user()->can('admin-destroy-property') || 
            auth()->user()->can('admin-soft-deleted-property-list'))
              <li class="softDeleteNav pcoded-hasmenu @if(($getRoute == 'admin-soft-deleted-user-list')||($getRoute == 'admin-soft-deleted-property-list')) pcoded-trigger active @endif">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fa fa-trash"></i></span>
                    <span class="pcoded-mtext">Soft Delete</span>
                </a>
                <ul class="pcoded-submenu">
                 @if(auth()->user()->can('admin-user-restore') || 
            auth()->user()->can('admin-destroy-user') || 
            auth()->user()->can('admin-soft-deleted-user-list'))
                  <li class="@if(($getRoute =='admin-soft-deleted-user-list' )) active @endif">
                        <a href="{{route('admin-soft-deleted-user-list')}}">
                            <span class="pcoded-mtext">Buyers</span>
                        </a>
                    </li>
                      @endif  
                          @if(auth()->user()->can('admin-property-restore') || 
            auth()->user()->can('admin-destroy-property') || 
            auth()->user()->can('admin-soft-deleted-property-list'))
                    <li class="@if(($getRoute == 'admin-soft-deleted-property-list') ) active @endif">
                        <a href="{{route('admin-soft-deleted-property-list')}}">
                            <span class="pcoded-mtext">Property</span>
                        </a>
                    </li>
                     @endif  
                </ul>
            </li>
             @endif    
        @endif    
        </ul>
    </div>
</nav>