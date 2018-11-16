@extends('layouts.app-user')

@section('title','dashboard')

@section('right-content')
		@if(Session::has('status'))
			<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
		@endif
		
		<div class="dashboard_mid-right">	
			<div class="bx-right">
			@php
			$courseName = '';
			$description = '';
			$title = '';
			$user = '';
			$video = '';
			@endphp
			@if(isset($topicData))
				@foreach($topicData as $key => $topics)
					@php
					$courseName = ucfirst($topics->course_name);
					$description = ucfirst($topics->description);
					$title = ucfirst($topics->title);
					$user = ucfirst($topics->name);
					$video = $topics->url;
					@endphp
				@endforeach
			@else
				@if(!empty($userData))
				@foreach($userData as $key => $topics)
				    @php
					if($key == '0'){
						$courseName = ucfirst($topics->course_name);
						$description = ucfirst($topics->description);
						$title = ucfirst($topics->title);
						$user = ucfirst($topics->name);
						$video = $topics->url;
					}
					@endphp
				@endforeach
				@endif
				
			@endif
				<h2 class="begin_text">{{$courseName}} </h2>
				<video class="vide"  controls controlsList='nodownload'>
						<source src="{{url('public/uploads/videos/')}}/{{$video}}" type="video/mp4">
						<source src="movie.ogg" type="video/ogg">
						  Your browser does not support the video tag.
				</video>
				<p class="demi_text margin-tp">{{$title}} </p>
				<p class="student_name name_text11"><span>Created by</span> {{$user}}</p>
				<p class="student_name name_text2"><span>Last updated </span> Sep 22, 2018</p>
				<div class="col-sm-9 col-sm-clas">
					<p class="pargh margin-topp">{{$description}} </p>
				</div>
				
			</div>
							
			<div class="related_video">
				<h3 class="rel-heading">Related Videos</h3>
				<div class="row">
					@foreach($userData as $key => $topics)
					@php
						$image = '' ;
						if(file_exists('public/uploads/thumnail/'.$topics->thumb_url.'') && ($topics->thumb_url != '')){
							 $image = asset('public/uploads/thumnail/'.$topics->thumb_url.'');
								}else{
								 $image = asset('public/frontview/images/NoPicture.jpg');
						}				
						@endphp
					<div class="col-lg-3 col-12 col-sm-6">
						<div class="video-rel">
							<img src="{{$image}}" alt="img" class="img-fluid ">
							<div class="captions">
								
								<a href="#" class="name-time"><i class="fas fa-user"></i>{{$topics->name}}</a>
								<a href="#"  class="name-time text-right"><i class="far fa-clock"></i>02 Hours</a>
								<p>{{$topics->title}}</p>
							</div>
						</div>
					</div>
					@if($key == '3')
						@break
					@endif
					@endforeach
					<!-- <div class="col-lg-3 col-12 col-sm-6">
						<div class="video-rel">
							<img src="images/chapt-2.jpg" alt="img" class="img-fluid ">
							<div class="captions">
								
								<a href="#" class="name-time"><i class="fas fa-user"></i>Jonas</a>
								<a href="#"  class="name-time text-right"><i class="far fa-clock"></i>02 Hours</a>
								<p>iOS 11 & Swift 4 - the Complete Development Bootcamp</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-12 col-sm-6">
						<div class="video-rel">
							<img src="images/chapt-3.jpg" alt="img" class="img-fluid ">
							<div class="captions">
								
								<a href="#" class="name-time"><i class="fas fa-user"></i>Jonas</a>
								<a href="#"  class="name-time text-right"><i class="far fa-clock"></i>02 Hours</a>
								<p>iOS 11 & Swift 4 - the Complete Development Bootcamp</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-12 col-sm-6">
						<div class="video-rel">
							<img src="images/chapt-4.jpg" alt="img" class="img-fluid ">
							<div class="captions">
								
								<a href="#" class="name-time"><i class="fas fa-user"></i>Jonas</a>
								<a href="#"  class="name-time text-right"><i class="far fa-clock"></i>02 Hours</a>
								<p>iOS 11 & Swift 4 - the Complete Development Bootcamp</p>
							</div>
						</div>
					</div >-->
				</div>
			</div>
		</div>
					
@endsection

		
																																												