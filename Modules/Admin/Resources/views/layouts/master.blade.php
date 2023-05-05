<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title','Real Estate Admin Panel')</title>
    <!-- CSS start -->
    @include('admin::includes.css')
    @toastr_css

    <!-- CSS end -->
    @yield('css')

</head>
<body>
 
<div id="loading" style="display: none;background-color:#05060640;  position:fixed;z-index:1000;top: 47px;left: -2px;height:100%;width:100%;"><img src="{{asset('assets_admin/loader.gif')}}" style="position: relative;top: 170px; left:650px; height: 125px;"></div>
<!-- Pre-loader start -->
@include('admin::includes.preloader')
<!-- Pre-loader end -->
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!--HEADER START -->
            @include('admin::includes.header')
            <!--HEADER END -->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                   
                            <!-- navbar start -->
                                @include('admin::includes.navbar')
                                <!-- navbar end-->
                            <!-- Main-body start -->
                                 @yield('content')
                        </div>
                    </div>
                   
                                           
                        <!-- Main-body end -->
                        @include('admin::includes.footer')
                    </div>
                </div>
            </div>
        </div>
<!-- Script start -->

@jquery
@toastr_js
@toastr_render
@include('admin::includes.script')
@yield('js')
<!-- Script end -->
</body>
</html>