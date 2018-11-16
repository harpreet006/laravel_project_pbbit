<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	
	<link rel="icon" href="{{ asset('public/frontview/assets/images/favi.png') }}" type="">
	<link rel="stylesheet" href="{{ asset('public/frontview/assets/css/bootstrap.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="{{ asset('public/frontview/assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('public/frontview/assets/css/responsive.css') }}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,300i,400,500,700,900" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    var  BASE_URL = '{{ url("/")}}';
    </script>  
</head>

<title>{{ config('app.name', 'Laravel') }} -  @yield('title') </title>
   
<body>
    <div class="main-container">
    	<div class="dashboard_header">
            <div class="row no-gutters">

                <div class="col-sm-3 left-dashbord">
                    
                @if (Request::is('viewChapter/*') || Request::is('viewTopic/*'))
                    @include('components.dashboard_user_left')
                @else
                    @include('components.dashboard_header_left')
                @endif
                </div>
                            
                <div class="col-sm-9 right-dashbord">
                    @include('components.dashboard_header_right')

                    <div class="dashboard_mid-right">
					  @if (Request::is('user-dashboard'))
						  @else
                        <a href="{{ url('/') }}/user-dashboard" class="back_link"><i class="fas fa-arrow-left"></i>Back</a>
                         @endif
						 @yield('right-content')
                    </div>

                </div>
            </div>
        </div>
    </div>
    
	<script src="{{ asset('public/frontview/assets/js/custom-script.js') }}"></script>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/frontview/assets/js/custom-script.js') }}"></script>
    <script src="{{ asset('public/frontview/assets/js/custom-script-ajax.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
<body>
</html>


