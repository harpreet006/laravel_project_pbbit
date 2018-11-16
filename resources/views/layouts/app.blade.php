<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon -->
    <link rel="icon" href="frontview/images/favi.png" type="">
    <!-- Bootstrap CSS -->      
    <link rel="stylesheet" href="{{ asset('public/frontview/assets/css/bootstrap.min.css') }}">        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>             
    <link rel="stylesheet" href="{{ asset('public/frontview/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontview/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">   
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jquery-confirm --> 
    <link rel="stylesheet" href="{{ asset('public/css/jquery-confirm/jquery-confirm.css')}}" />
    @yield('style') 
    <script type="text/javascript">
    var  BASE_URL = '{{ url("/")}}';
    </script>  
</head>
<?php //$base_url=rtrim($app['url']->to('/'),'public'); ?>
<title>{{ config('app.name', 'Laravel') }} -  @yield('title') </title>
   
<body>

    @include('includes.header')
    <div class="main-container">
            @yield('content')
    </div>
    @include('includes.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/frontview/assets/js/custom-script.js') }}"></script>
    <script src="{{ asset('public/frontview/assets/js/custom-script-ajax.js') }}"></script>
    <!-- jquery-confirm -->
    <script  src="{{ asset('public/js/jquery-confirm/jquery-confirm.js')}}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
     @yield('script')
    <script type="text/javascript">
        $(document).ready(function(){

            if(!checkCookie()){

            $.confirm({
                        title : false,
                        columnClass: 'col-md-12',
                        containerFluid: true, // this will add 'container-fluid' instead of 'container'
                        content: 'We use cookies to help our site work, to understand how it is used, and to tailor the adverts presented on our site. By clicking “Accept” below, you agree to us doing so. You can read more in our cookie notice. Or, if you do not agree, you can click Manage below to access other choices.',
                        offsetTop: '38%',
                        buttons: {
                                Accept: {
                                text: 'Accept', // text for button
                                btnClass: 'btn-blue', // class for the button
                                keys: ['enter', 'a'], // keyboard event for button
                                isHidden: false, // initially not hidden
                                isDisabled: false, // initially not disabled
                                action: function(heyThereButton){
                                    setCookie("accept", 'true', 30);
                                }
                            },
                            close:{

                            }
                        }
                    });
            }

            $('.in_progress').on('click',function(){
                 $.alert('<b>Opps!..  This links is under construction</b>');
            });

            $('.view_video').on('click',function(e){
                e.preventDefault();
                that = $(this); 

                if(that.attr('v-url') ==  ''){
                    $.alert('<b>Sorry video not fount.</b>');
                    return ;
                }

                $.confirm({
                    title: '',
                    content: '<video width="400" controls>'+
                                  '<source src="'+that.attr('v-url')+'" type="video/mp4">'+
                                  '<source src="'+that.attr('v-url')+'" type="video/ogg">'+
                                  'Your browser does not support HTML5 video.'+
                              '</video>',
                    animation: 'scale',
                    animationClose: 'top',
                    columnClass:'col-md-6 col-md-offset-3',
                    buttons: {
                      close: function() {
                        // lets the user close the modal.
                      }
                    },
                  });
            });

        });

    </script>

<body>
</html>


