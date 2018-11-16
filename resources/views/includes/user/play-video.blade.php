@extends('layouts.app-user')

@section('title','dashboard')

@section('right-content')
		@if(Session::has('status'))
			<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
		@endif
		
		@foreach($userData as $data)
		<div class="row margin-tp1">
			<div class="col-md-3">
				<img src="{{ asset('public/frontview/images/') }}/{{$data->image}}" alt="img" class="rounded img-fluid img-chapter">
			</div>
			<div class="col-md-9">
				<div class="chapter_right">
					<h5 class="demi_text ">{{ucfirst($data->title)}}</h5>
					<ul class="chapt-link">
						<li><a href="#">Best Seller</a></li>
						<li><a href="#"><i class="far fa-address-book"></i>364 Lectures</a></li>
						<li><a href="#"><i class="far fa-building"></i>All Levels</a></li>
						<li><a href="#"><i class="far fa-clock"></i>43 hours</a></li>
					</ul>
					<p class="mid-pargh">{{$data->description}} </p>
				</div>		
			</div>
		</div>
		@endforeach
		<div class="paginationd paginationsd">
			{!! $userData->render() !!}
        </div>		
					
@endsection

		
																																												