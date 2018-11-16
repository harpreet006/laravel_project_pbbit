@extends('layouts.app-user')

@section('title','dashboard')

@section('right-content')

		@if(Session::has('status'))
			<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
		@endif
		
		
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
							
								
							<img src="{{ $image}}" alt="img" class="rounded img-fluid img-chapter">
						</div>
						<div class="col-md-9">
							<div class="chapter_right">
								<a href="{{url('/')}}/viewChapter/{{$data->id}}"><h5 class="demi_text ">{{ucfirst($data->title)}}</h5></a>
								<ul class="chapt-link">
									<li><a href="#">Best Seller</a></li>
									<li><a href="#"><i class="far fa-address-book"></i>{{$data->totalTopics}} Lectures</a></li>
									<li><a href="#"><i class="far fa-building"></i>All Levels</a></li>
									<li><a href="#"><i class="far fa-clock"></i>43 hours</a></li>
								</ul>
								<p class="mid-pargh">{{ucfirst($data->description)}}</p>
							</div>		
						</div>
					</div>
				@endforeach 	
		@else
		<p>You don't have any item.</p><a href="{{url('/')}}/course">Buy Now!!</a>
		@endif
		
		<div class="paginationd paginationsd">
			  {!!$UserChapterData->render()!!}
        </div>
				
					
@endsection

		
																																												