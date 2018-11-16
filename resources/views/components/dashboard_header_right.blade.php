<div class="dashboard_header_right">
	<div class="row no-gutters">
		<div class="col-sm-12">
		<div class="col-sm-6">
			 @csrf  
				<div class="input-group">
				<i class="fas fa-search search_i"></i>
					<input class="form-control search-dashbord" id="DashboardSearch" placeholder="Type in to Search Course..." name="q" type="text">
			
				</div>
				<div id="dashboardResponse">
				<ul class="responseData" id="responseData">
				</ul>
				
				</div>
	
			</div>
			<div class="col-sm-6">
				<form class="form-inline right_nav float-right">
				<li class="nav-item">
				<span class="number">{{count(Cart::content())}}</span>
					<a class="nav-link" href="{{url('/cart')}}"><i class="fas fa-shopping-cart"></i></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#"><i class="far fa-bell"></i></a>
				</li>	 

				@php
				$image = '' ;
				if(file_exists('public/images/avatar/'.Auth::user()->avtar.'') && (Auth::user()->avtar !='')){ 
					 $image = asset('public/uploads/avatar/'.Auth::user()->avtar.'');
						}else{ 
						 $image = asset('public/frontview/images/NoPicture.jpg');
				}				
				@endphp
				<span class="users">			
				<img src="{{$image}}" alt="img" class="user_name">
				<a href="#" class="username dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</a>
				<div class="dropdown-menu pbit-cust-logout" aria-labelledby="navbarDropdown">          
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="logout();">
						{{ __('Logout') }}
					</a>
				</div>
				</span>								
				</form>
			</div>
		</div>
	</div>
</div>