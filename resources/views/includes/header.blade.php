   <!-- header -->
    <div class="header {{$class}} {{$type}} {{ $type === "innerpage" ? "header-1" : "" }}">
        <div class="container">
            <!-- navbar -->   

            <nav class="navbar navbar-expand-lg navbar-light navi">                  
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <img src="{{ url('public/frontview/images/toggle_icon.png')}}"  alt="toggle"/>
                </button>
                <li class="nav-item mob_icon margn-leftt" style="display:none;">
                    <a class="nav-link" href="#"><i class="fas fa-search"></i></a>
                </li>
                <img src="{{ url('public/frontview/images/logo.png')}}"  class="logo mob_logo"  style="display:none;"alt="logo"  />        
                <li class="nav-item mob_icon" style="display:none;">
                    <a class="nav-link" href="#"><i class="fas fa-user"></i></a>
                </li>
                <li class="nav-item mob_icon" style="display:none;">
                    <a class="nav-link" href="#"> <i class="fas fa-edit"></i></a>
                </li>
                <li class="nav-item mob_icon" style="display:none;">
                    <span class="number">02</span>
                    <a class="nav-link" href="{{url('/cart')}}"><i class="fas fa-shopping-cart"></i></a>
                </li>
                        
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto navs">
                        <li class="nav-item first_link active">                      
                            <a class="nav-link" href="{{url('/')}}">{{__('messages.home_menu')}}<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown coursemeu" id="courseDrop">
                            <a class="nav-link " href="#" id="navbarDropdownCourse" role="button"  aria-haspopup="true" aria-expanded="false">
                              {{__('messages.course_menu')}} <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu drops" aria-labelledby="navbarDropdown">
                        </li>
                        <li class="nav-item dropdown" id="topicsDrop">
                            <a class="nav-link " id="navbarDropdownTopics" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{__('messages.topic_menu')}}  <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu drops" aria-labelledby="navbarDropdown">
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/about')}}">{{__('messages.about_menu')}}</a>
                        </li>
                        <li class="nav-item logo_li">
                            <a class="nav-link" href="{{url('/')}}"><img src="{{ url('public//frontview/images/logo.png')}}"  class="logo" alt="logo" /></a>
                        </li>
                    </ul>
                    <div class="form-inline right_nav">
                        <li class="nav-item">
                            <a class="nav-link" id="opensearchh" data-target="#hsearch"href="#"><i class="fas fa-search"></i></a>
                                @csrf 
                                  <input type="search" name="hsearch" id="hsearch" class="search-header">                            
                        </li>
                        <li class="nav-item">
                            <span class="number"><?php echo App\Helper::get_cart_number(); ?></span>
                            <a class="nav-link" href="{{url('/cart')}}"><i class="fas fa-shopping-cart"></i></a>
                        </li>
                        <div id="searchResponse">
                            <ul class="searchul" id="searchultop"></ul>         
                        </div>
                    </div>
                @if (Auth::guest())

                  <button class="btn login_btnn" id="myBtn" type="submit">{{ __('messages.login_btn') }}</button>
                  <button class="btn sign_btn" id="register" type="submit">{{ __('messages.signup_btn') }}</button>

                @else
                <!--<span class="users"><img src="../frontview/images/download.png" alt="img" class="user_name">{{Auth::user()->name}} <i class="fa fa-angle-down" aria-hidden="true"></i>
                </span>-->  

                <li class="nav-item dropdown users">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu pbit-cust-logout" aria-labelledby="navbarDropdown">          
                        <a class="dropdown-item" href="{{ url('/user-dashboard') }}" >
                            Dashboard
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>            
                @endif                     
                            </div>
                    <div class="dropdown-menu drops" id="navbarDropdowncoursediv" aria-labelledby="navbarDropdown">
                        <div class="vertcal_list">
                            <ul>
                                @php
                                    $i = 1;
                                    $courses= App\Helper::get_header();
                                @endphp
                                @foreach($courses as $course)
                                    <li class="li_tb tb-{{ $i }}" id="{{ $course['name'] }}course"><span>{{ ucfirst($course['name']) }}</span>
                                        <ul class="tab-link" id="{{ $course['name'] }}">
                                        <li>
                                        @foreach($course['topics'] as $value)
                                            @foreach($value as $val)
                                                <ul class="tab-link-2">
                                                <li><a href="{{ url('/course').'/'.$course['name'] }}"><i class="far fa-address-book"></i>{{ ucfirst(substr($val->title, 0, 10)."...") }}</a></li>
                                                </ul>
                                            @endforeach
                                        @endforeach
                                    </li>
                                    </ul>
                                    </li>
                                    @php
                                        $i++
                                    @endphp
                                @endforeach 
                                @if($i >=14)
                                    <a href="{{url('/')}}/course" class="view-btn-all">View All</a>
                                @endif
                                
                            </ul>
                        </div>                  
                    </div>

                    <?php $topics =  App\Helper::get_topic(); ?>
                    <div class="drops-2sect" id="navbarDropdownTopicsdiv" style="display: none;">         
                        <ul class="tab-link">
                            <li>
                            @php
                                $i=0;
                            @endphp
                            @foreach($topics as $topic)
                            
                                <ul class="tab-link-2">
                                    <li><a href="{{url('/topic').'/'.$topic->id}}"><i class="far fa-address-book"></i> 
                                        {{ ucfirst(substr($topic->title, 0, 10)."...") }}
                                    </a></li>
                                    
                                </ul>
                                @php
                                    $i++;
                                @endphp
                            @endforeach 
                            </li>
                            @if($i >=14)
                                <a href="#" class="view-btn-all">View All</a>
                            @endif
                        </ul>               
                    </div>   
            </nav>
            <!-- nav end -->

            @if($class =='home')         
          <div class="banner">
                <h2>{{ __('messages.expert_txt_home') }} <span> {{ __('messages.expert_txt_home') }} </span></h2>
                <p>{{ __('messages.Industry_txt_home') }} <span> {{ __('messages.power_txt_home') }} </span>{{ __('messages.course_txt_home') }}</p>
                <div id="custom-search-input">
                    <div class="input-group">
                     @csrf  
                        <input class="form-control input-lg search userSearch" id="userSearch" placeholder="{{ __('messages.placeholder_search_home')}}" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg btns-serch" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>                     
                    </div>                  
                </div> 
                <div id="searchResponse">
                    <ul class="searchul" id="searchul"></ul>            
                </div>
            </div> 
        @else
        <div class="banner">       
            <h2 >{{ucfirst($class)}}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb nav-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/')}}/course/{{$class}}">{{ucfirst($class)}}</a></li>           
                </ol>
            </nav>
        </div>              
        @endif
        
        </div><!-- nav -->
    </div><!-- header -->