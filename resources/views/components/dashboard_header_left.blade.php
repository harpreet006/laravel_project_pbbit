<div class="dashboard_header_left">
	<a href="{{url('/')}}"><img src="{{ asset('public/frontview/images/logo.png') }}"  class="dashbord-logo" alt="logo"></a>
	</div>
	<div class="dashboard_mid_left">
	<div class="user-profile">
		<div class="inner-circle"></div>
	@php
		$image = '' ;
		if(file_exists('public/images/avatar/'.Auth::user()->avtar.'') && (Auth::user()->avtar !='')){ 
			 $image = asset('public/uploads/avatar/'.Auth::user()->avtar.'');
				}else{ 
				 $image = asset('public/frontview/images/NoPicture.jpg');
		}				
	@endphp
					
		<img src="{{$image}}" alt="{{Auth::user()->avtar}}" class="dashbord-user">
		<h4 class="dash-text">Hello,</h4>
		<h3 class="user_namee"> {{Auth::user()->name}}</h3>
			<ul class="navbar-nav dashboard_nav">
				 @if(count($userData)>0)	
					 <li  data-toggle="collapse" data-target="#mycourses" class="nav-item">
							<a href="JavaScript:Void(0);" class="nav-link"><i class="fa fa-cog fa-lg" aria-hidden="true"></i> My Courses <i class="fa fa-angle-down"></i></a>
					</li>
					@php
					$i = 1;
					@endphp
					<ul class="sub-menu collapse" id="mycourses">
						@foreach($userData as $course)
							<li class="nav-item li_tb tb-{{ $i }}">
								<a href="{{url('/')}}/showCourseData/{{$course->id}}" class="nav-link">{{$course->course_name}} </a>
							</li>
						@php
						$i++;
						@endphp
						@endforeach
					</ul>
					@endif

					@php 
						$class = '';
						$userClass = '';
						$passClass = '';
						@endphp
						@if (Request::is('user-profile') || Request::is('user-changePassword'))
							@php 
							$class = 'show';
							@endphp
						@endif
						
					    <li  data-toggle="collapse" data-target="#products" class="nav-item">
							<a href="JavaScript:Void(0);" class="nav-link"><i class="fa fa-cog fa-lg" aria-hidden="true"></i> Settings <i class="fa fa-angle-down"></i></a>
						</li>
						
						
					
						<ul class="sub-menu collapse {{$class}}" id="products">
						@if (Request::is('user-profile'))
							@php 
							$userClass = 'active';
							@endphp
						@endif
						@if (Request::is('user-changePassword'))
							@php 
							$passClass = 'active';
							@endphp
						@endif
							<li  class="nav-item {{$userClass}}"><a class="dropdown-item subdrop" href="{{url('user-profile')}}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> Update Profile</a></li>
							<li  class="nav-item {{$passClass}}"><a class="dropdown-item subdrop" href="{{url('user-changePassword')}}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> Change Password</a></li>
								<li  class="nav-item {{$passClass}}"><a class="dropdown-item subdrop" href="{{url('myorder')}}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> MyOrder</a></li>
						</ul>
						
						 <li  data-toggle="collapse"  class="nav-item">
							<a class="nav-link" href="{{ route('logout') }}" onclick="logout();"> <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i> {{ __('Logout') }}
							</a>
						</li>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
	        </ul>
	</div>
</div>