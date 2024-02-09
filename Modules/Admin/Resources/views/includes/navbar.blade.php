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

            <li class="{{ (\Request::route()->getName() == 'admin-property-list') ? 'active' : '' }}">
                <a href="{{route('admin-property-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-building"></i></span>
                    <span class="pcoded-mtext">Manage Properties</span>
                </a>
            </li>

            <li class="{{ (\Request::route()->getName() == 'admin-cms-page-list') ? 'active' : '' }}">
                <a href="{{route('admin-cms-page-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                    <span class="pcoded-mtext">CMS</span>
                </a>
            </li>

            <li class="{{ (\Request::route()->getName() == 'admin-faq-list') ? 'active' : '' }}">
                <a href="{{route('admin-faq-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                    <span class="pcoded-mtext">FAQ</span>
                </a>
            </li>

            <li class="{{ (\Request::route()->getName() == 'admin-booking-list') ? 'active' : '' }}">
                <a href="{{route('admin-booking-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-book"></i></span>
                    <span class="pcoded-mtext">Manage Bookings</span>
                </a>
            </li>


            <li class="{{ (\Request::route()->getName() == 'admin-enquiry-list') ? 'active' : '' }}">
                <a href="{{route('admin-enquiry-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-book"></i></span>
                    <span class="pcoded-mtext">Manage Enquiry</span>
                </a>
            </li>


            <li class="{{ (\Request::route()->getName() == 'admin-system-settings') ? 'active' : '' }}">
                <a href="{{route('admin-system-settings')}}">
                    <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                    <span class="pcoded-mtext">System Settings</span>
                </a>
            </li>



          <!--  <li class="{{ (\Request::route()->getName() == 'admin-subscription-list') ? 'active' : '' }}">
                <a href="{{route('admin-subscription-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-pagelines"></i></span>
                    <span class="pcoded-mtext">Manage Subscription</span>
                </a>
            </li> -->
           
            <!-- <li class="{{ (\Request::route()->getName() == 'admin-owners-list') ? 'active' : '' }}">
                <a href="#">
                    <span class="pcoded-micon"><i class="fa fa-credit-card"></i></span>
                    <span class="pcoded-mtext">Manage Payments</span>
                </a>
            </li> -->


            <li class="{{ (\Request::route()->getName() == 'admin-seller-subscription-list') ? 'active' : '' }}">
                <a href="{{route('admin-seller-subscription-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-file"></i></span>
                    <span class="pcoded-mtext">Manage Seller Subscription</span>
                </a>
            </li>

            

            <li class="{{ (\Request::route()->getName() == 'admin-reason-list') ? 'active' : '' }}">
                <a href="{{route('admin-reason-list')}}">
                    <span class="pcoded-micon"><i class="fa fa-credit-card"></i></span>
                    <span class="pcoded-mtext">Manage Cancel Reasons</span>
                </a>
            </li>        
        @endif    
        </ul>
    </div>
</nav>