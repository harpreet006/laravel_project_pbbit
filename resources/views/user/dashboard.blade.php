@extends('layouts.app-user')

@section('title','dashboard')

@section('right-content')

		@if(Session::has('status'))
			<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
		@endif
		
		@if($exist > 0)
		@if(count($UserChapterData) > 0)
				@foreach($UserChapterData as $data)
					<div class="row margin-tp1">
						<div class="col-md-3">
						@php
						$image = '' ;
						if(file_exists('public/uploads/thumnail/'.$data->image.'') && ($data->image !='')){
							 $image = asset('public/uploads/thumnail/'.$data->image.'');
								}else{
								 $image = asset('public/frontview/images/NoPicture.jpg');
						}				
						@endphp
							
								
							<a href="{{url('/')}}/viewChapter/{{$data->id}}"><img src="{{ $image}}" alt="img" class="rounded img-fluid img-chapter"></a>
						</div>
						<div class="col-md-9">
							<div class="chapter_right">
								<a href="{{url('/')}}/viewChapter/{{$data->id}}"><h5 class="demi_text ">{{ucfirst($data->title)}}</h5></a>
								<ul class="chapt-link">
									<li>Best Seller</li>
									<li><i class="far fa-address-book"></i>{{$data->totalTopics}} Lectures</li>
									<li><i class="far fa-building"></i>All Levels</li>
									<li><i class="far fa-clock"></i>43 hours</li>
								</ul>
								<p class="mid-pargh">{{ ucfirst(substr($data->description, 0, 200)."...") }}</p>
								<h5 class="demi_text "><a href="{{url('/')}}/viewChapter/{{$data->id}}">Start Course<a></h5>
						<div class="ration-sectiondash" style="clear:both">	
							<div class="ratingdash selected" method="POST" action="{{url('download')}}">
						
							<input type="radio" id="star5" name="rating" value="5" {{ $average == 5 ? "checked" : "" }} disabled=""=""><label  ratingact="5" class = "full" for="star5" title="Awesome - 5 stars"></label>
							<input type="radio" id="star4half" name="rating" value="4 and a half" {{ $average == 4.5 ? "checked" : "" }} disabled=""=""><label ratingact="4.5" class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
							<input type="radio" id="star4" name="rating" value="4" {{ $average == 4 ? "checked" : "" }} disabled=""=""><label ratingact="4" class = "full" for="star4" title="Pretty good - 4 stars"></label>
							<input type="radio" id="star3half" name="rating" value="3 and a half" {{ $average == 3.5 ? "checked" : "" }} disabled=""=""><label  ratingact="3.5" class="half" for="star3half" title="Meh - 3.5 stars"></label>
							<input type="radio" id="star3" name="rating" value="3" {{ $average == 3 ? "checked" : "" }} disabled=""=""><label  ratingact="3" class = "full" for="star3" title="Meh - 3 stars"></label>
							<input type="radio" id="star2half" name="rating" value="2 and a half" {{ $average == 2.5 ? "checked" : "" }} disabled=""=""><label ratingact="2.5" class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
							<input type="radio" id="star2" name="rating" value="2" {{ $average == 2 ? "checked" : "" }} disabled=""=""><label ratingact="2" class = "full" for="star2" title="Kinda bad - 2 stars" ></label>
							<input type="radio" id="star1half" name="rating" value="1 and a half" {{ $average == 1.5 ? "checked" : "" }} disabled=""=""><label ratingact="1.5" class="half" for="star1half" title="Meh - 1.5 stars"></label>
							<input type="radio" id="star1" name="rating" value="1" {{ $average == 1 ? "checked" : "" }} disabled=""=""><label ratingact="1" class = "full" for="star1" title="Sucks big time - 1 star"></label>
							<input type="radio" id="starhalf" name="rating" value="half" {{ $average == 0.5 ? "checked" : "" }} disabled=""=""><label  ratingact="0.5" class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>

							</div>
						</div>
							</div>		
						</div>
					</div>
				@endforeach 
			@else
			
			@endif				
		@else
		<p>You don't have any item.</p><a href="{{url('/')}}/course">Buy Now!!</a>
		@endif
		
		<div class="paginationd paginationsd">
			  {!!$UserChapterData->render()!!}
        </div>
				
					
@endsection

		
																																												