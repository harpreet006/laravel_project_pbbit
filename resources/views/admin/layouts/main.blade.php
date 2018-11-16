<!doctype html>
<html class="fixed sidebar-light">
    <head>
        <!-- Basic -->
        <meta charset="UTF-8">
        <title>App</title>
        <meta name="keywords" content="HTML5 Admin Template" />
        <meta name="description" content="Porto Admin - Responsive HTML5 Template">
        <meta name="author" content="okler.net">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Web Fonts  -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css')}}">
        <!-- Vendor CSS -->
        <link rel="stylesheet" href="{{ asset('public/vendor/bootstrap/css/bootstrap.css')}}" />
        <link rel="stylesheet" href="{{ asset('public/vendor/animate/animate.css')}}">

        <link rel="stylesheet" href="{{ asset('public/vendor/font-awesome/css/font-awesome.css')}}" />
        <link rel="stylesheet" href="{{ asset('public/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}" />
        <!-- Specific Page Vendor CSS -->
        @yield('style')
        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{ asset('public/css/theme.css')}}" />
        <!-- jquery-confirm --> 
        <link rel="stylesheet" href="{{ asset('public/css/jquery-confirm/jquery-confirm.css')}}" />
        <!-- Skin CSS -->
        <link rel="stylesheet" href="{{ asset('public/css/skins/default.css')}}" />
        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="{{ asset('public/css/custom.css')}}">
        <!-- Head Libs -->
        <script src="{{ asset('public/vendor/modernizr/modernizr.js')}}"></script>
    </head>
<body class="loading-overlay-showing show-lock-screen" data-loading-overlay>
        <div class="loading-overlay">
            <div class="bounce-loader">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>

    <section class="body">
<?php $user = Auth::user(); ?>
        <!-- Header-->
        @include('admin.includes.header')
        <!-- Header-->
        <div class="inner-wrapper">
            <!-- Left Panel -->
             @include('admin.includes.left_sidebar')
            <!-- Header-->
            <!-- Body-->
    	     @yield('content')
             <!-- Body-->
        </div>
        <!-- /#right-panel -->
         @include('admin.includes.right_sidebar')
        <!-- Right Panel -->
   </section>

    <!-- Vendor -->
        <script type="text/javascript">
            var BASE_URL =  "{{url('/')}}";
        </script>
        <script src="{{ asset('public/vendor/jquery/jquery.js')}}"></script>
        <script src="{{ asset('public/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
        <script src="{{ asset('public/vendor/popper/umd/popper.min.js')}}"></script>
        <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.js')}}"></script>
        <script src="{{ asset('public/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
        <script src="{{ asset('public/vendor/common/common.js')}}"></script>
        <script src="{{ asset('public/vendor/nanoscroller/nanoscroller.js')}}"></script>
        <script src="{{ asset('public/vendor/jquery-placeholder/jquery-placeholder.js')}}"></script>
        <!-- jquery-confirm -->
        <script  src="{{ asset('public/js/jquery-confirm/jquery-confirm.js')}}"></script>
        <!-- Theme Custom -->
        <script src="{{ asset('public/js/custom.js')}}"></script>
        <?php
            if(session('status')){
                echo '<script type="text/javascript">success_msg("'.session('status').'");</script>';
            }
        ?>
        @yield('script')
        <!-- Theme Base, Components and Settings -->
        <script src="{{ asset('public/js/theme.js')}}"></script>
        
        <!-- Theme Initialization Files -->
        <script src="{{ asset('public/js/theme.init.js')}}"></script>

        <script src="{{ asset('public/js/examples/examples.loading.overlay.js')}}"></script>

        <script type="text/javascript">
                $(document).ready(function(){
                     get_unread_orders();
                     get_notifications();
                    setInterval(function(){
                        get_unread_orders();
                        get_notifications();
                    },30000);
                });
        </script>
        
</body>
</html>
