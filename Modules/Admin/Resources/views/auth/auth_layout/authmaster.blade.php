<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title',"EV Admin Panel")</title>
    @include('admin::auth.auth_includes.authcss')
    @toastr_css
</head>
<body class="fix-menu">
    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @yield('content')
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section> 
@include('admin::auth.auth_includes.authscript')  
@toastr_js
@toastr_render   
@yield('js')

</body>
</html>