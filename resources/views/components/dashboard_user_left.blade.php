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
			<img src="{{ $image }}" alt="img" class="dashbord-user" alt="img-here" />
			<h4 class="dash-text">Hello,</h4>
			<h3 class="user_namee"> {{Auth::user()->name}}</h3>
				<ul class="navbar-nav dashboard_nav dash_list">
					@php
					$i = 1
					@endphp
					@foreach($userData->unique('topicId') as $topics)
						<li class="nav-item ">
							<div class="left-dash">
								<span><a href="{{url('/')}}/viewTopic/{{$topics->topicId}}"><span class="spn_number">{{$i}}</span><p>{{ucfirst($topics->title)}}</p>
								<form  class="formcart" method="POST" action="{{url('/')}}/document-download">
									<input type="hidden" name="product_id" value="{{$topics->topicId}}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									@php
										$doc = '' ;
										$disabled = '';
										if(isset($topics->document_url)){
											if(file_exists('public/uploads/documents/'.$topics->document_url.'') && ($topics->document_url != '')){
											  $disabled = ''; 
											}else{
											$disabled = 'disabled'; 
											}
										}else{
											$disabled = 'disabled'; 
										}
														
									@endphp
									<button type="submit" class="btn btn-fefault download_btn" {{$disabled}}>
									  <img src="{{ asset('public/frontview/images/pdf.png') }}"/>Download</span>
										 
									</button>
                                </form>	
							</div>
							<div class="right-dash">
								<span><span class="time ">4:38</span>
								<a href="#" class="float-right checks"><img src="{{ asset('public/frontview/images/checks.png') }}"/></a></span>
							</div>
						</li>
					@php
					$i++;
					@endphp
					@endforeach					
				</ul>
		</div>
	</div>