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
			$tid = '';			 
			$user = '';
			$video = '';
			$updated = '';			 
			$producttype="";
			@endphp
			@if(isset($topicData))
				@foreach($topicData as $key => $topics)
					@php
					 
					$courseName = ucfirst($topics->course_name);
					$description = ucfirst($topics->description);
					$title = ucfirst($topics->title);					
					$user = ucfirst($topics->name);
					$tid  = $topics->topicId;
					$video = $topics->url;
					$producttype="topic";
					if($topics->updated_at != ''){
						$updateDate = explode(" ", $topics->updated_at);
						$updated = $updateDate[0];	
					}
					@endphp
				@endforeach
			@else
					@if(count($chapterData) > 0)
						@foreach($chapterData as $key => $chapter)
					@php
						$courseName = ucfirst($chapter->course_name);
						$description = ucfirst($chapter->description);
						$title = ucfirst($chapter->title);
						$user = ucfirst($chapter->userName);						 
						$video = $chapter->video;
					    $producttype="chapter";
					    $chapterId = $chapter->id;
						if($chapter->updated_at != ''){
							$updateDate = explode(" ", $chapter->updated_at);
							$updated = $updateDate[0];	
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
	@if($producttype !="chapter")
	 
			<div class="ration-section" style="clear:both">	
			 			 
			<form class="rating selected{{$rating}}" method="POST" action="{{url('download')}}">
				  <input type="hidden" name="_token" value="{{ csrf_token() }}">		 
				  <input type="text" name="productid" value="{{$tid}}">
				<input type="radio" id="star5" name="rating10" value="5" {{ $rating == 5 ? "checked" : "" }}><label  ratingact="5" class = "full" for="star5" title="Awesome - 5 stars"></label>
				<input type="radio" id="star4half" name="rating9" value="4 and a half" {{ $rating == 4.5 ? "checked" : "" }}><label ratingact="4.5" class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
				<input type="radio" id="star4" name="rating8" value="4" {{ $rating == 4 ? "checked" : "" }}><label ratingact="4" class = "full" for="star4" title="Pretty good - 4 stars"></label>
				<input type="radio" id="star3half" name="rating7" value="3 and a half" {{ $rating == 3.5 ? "checked" : "" }}><label  ratingact="3.5" class="half" for="star3half" title="Meh - 3.5 stars"></label>
				<input type="radio" id="star3" name="rating6" value="3" {{ $rating == 3 ? "checked" : "" }}><label  ratingact="3" class = "full" for="star3" title="Meh - 3 stars"></label>
				<input type="radio" id="star2half" name="rating5" value="2 and a half" {{ $rating == 2.5 ? "checked" : "" }}><label ratingact="2.5" class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
				<input type="radio" id="star2" name="rating4" value="2" {{ $rating == 2 ? "checked" : "" }}><label ratingact="2" class = "full" for="star2" title="Kinda bad - 2 stars" ></label>
				<input type="radio" id="star1half" name="rating3" value="1 and a half" {{ $rating == 1.5 ? "checked" : "" }}><label ratingact="1.5" class="half" for="star1half" title="Meh - 1.5 stars"></label>
				<input type="radio" id="star1" name="rating2" value="1" {{ $rating == 1 ? "checked" : "" }}><label ratingact="1" class = "full" for="star1" title="Sucks big time - 1 star"></label>
				<input type="radio" id="starhalf" name="rating1" value="half" {{ $rating == 0.5 ? "checked" : "" }}><label  ratingact="0.5" class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
			</form>

			</div>
			@endif





				<p class="student_name name_text2"><span>Last updated </span> {{date('F jS, Y', strtotime($updated))}}</p>
				<div class="col-sm-9 col-sm-clas">
					<p class="pargh margin-topp">{{$description}} </p>
				</div>
				
			</div>
							
			<div class="related_video">
				<h3 class="rel-heading">Related Videos</h3>
				<div class="row">
					@foreach($userData->unique('topicId') as $key => $topics)
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
							<a href="{{url('/viewTopic')}}/{{$topics->topicId}}"><img src="{{$image}}" alt="img" class="img-fluid "></a>
							<div class="captions">
								
								<p class="name-time"><i class="fas fa-user"></i>{{$topics->name}}</p>
								<p class="name-time text-right"><i class="far fa-clock"></i>02 Hours</p>
								<p><a href="{{url('/viewTopic')}}/{{$topics->topicId}}" class="username">{{ucfirst($topics->title)}}</a></p>
								<div class="ration-sectiondash" style="clear:both">	
								<div class="ratingdash selected" >
								@if(isset($topics->rating) &&  $topics->rating != '')
								@php
								
									$rating = abs($topics->rating);
								@endphp
								
									
										<input type="radio" id="star5" name="rating10" value="5" {{ $rating == 5 ? "checked" : "" }} disabled=""=""><label  ratingact="5" class = "full" for="star5" title="Awesome - 5 stars"></label>
										<input type="radio" id="star4half" name="rating9" value="4 and a half" {{ $rating == 4.5 ? "checked" : "" }} disabled=""=""><label ratingact="4.5" class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
										<input type="radio" id="star4" name="rating8" value="4" {{ $rating == 4 ? "checked" : "" }} disabled=""=""><label ratingact="4" class = "full" for="star4" title="Pretty good - 4 stars"></label>
										<input type="radio" id="star3half" name="rating7" value="3 and a half" {{ $rating == 3.5 ? "checked" : "" }} disabled=""=""><label  ratingact="3.5" class="half" for="star3half" title="Meh - 3.5 stars"></label>
										<input type="radio" id="star3" name="rating6" value="3" {{ $rating == 3 ? "checked" : "" }} disabled=""=""><label  ratingact="3" class = "full" for="star3" title="Meh - 3 stars"></label>
										<input type="radio" id="star2half" name="rating5" value="2 and a half" {{ $rating == 2.5 ? "checked" : "" }} disabled=""=""><label ratingact="2.5" class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
										<input type="radio" id="star2" name="rating4" value="2" {{ $rating == 2 ? "checked" : "" }} disabled=""=""><label ratingact="2" class = "full" for="star2" title="Kinda bad - 2 stars" ></label>
										<input type="radio" id="star1half" name="rating3" value="1 and a half" {{ $rating == 1.5 ? "checked" : "" }} disabled=""=""><label ratingact="1.5" class="half" for="star1half" title="Meh - 1.5 stars"></label>
										<input type="radio" id="star1" name="rating2" value="1" {{ $rating == 1 ? "checked" : "" }} disabled=""=""><label ratingact="1" class = "full" for="star1" title="Sucks big time - 1 star"></label>		
										<input type="radio" id="starhalf" name="rating1" value="half" {{ $rating == 0.5 ? "checked" : "" }}><label  ratingact="0.5" class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
									@else
										<input type="radio" id="starhalf" name="rating1" value="full" disabled=""><label  ratingact="0.5" class="full" for="starhalf" title="Sucks big time - 0.5 stars"></label>
										<input type="radio" id="starhalf" name="rating1" value="full" disabled=""><label  ratingact="0.5" class="full" for="starhalf" title="Sucks big time - 0.5 stars"></label>
										<input type="radio" id="starhalf" name="rating1" value="full" disabled=""><label  ratingact="0.5" class="full" for="starhalf" title="Sucks big time - 0.5 stars"></label>
										<input type="radio" id="starhalf" name="rating1" value="full" disabled=""><label  ratingact="0.5" class="full" for="starhalf" title="Sucks big time - 0.5 stars"></label>
										<input type="radio" id="starhalf" name="rating1" value="full" disabled=""><label  ratingact="0.5" class="full" for="starhalf" title="Sucks big time - 0.5 stars"></label>
										
										
										
									@endif
									</div> 
								</div>
							
							</div>
						</div>
					</div>
					@if($key == '3')
						@break
					@endif
					@endforeach
				</div>
			</div>
		</div>
					
@endsection

 
 
		
																																												