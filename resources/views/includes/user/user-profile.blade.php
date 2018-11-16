@extends('layouts.app-user')

@section('title','dashboard')

@section('right-content')
	<?php $user = Auth::user(); ?>
		<form enctype="multipart/form-data" method="POST" action="{{url('/')}}/updateProfile">
		 @csrf
		  <div class="form-group">
			<label for="name">First Name:</label>
			<input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{$user->first_name}}" id="name">
		    @if ($errors->has('first_name'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('first_name') }}</strong>
				</span>
            @endif
		  </div>
		   <div class="form-group">
			<label for="name">Last Name:</label>
			<input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{$user->last_name}}" id="name">
			@if($errors->has('last_name'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('last_name')}}<strong>
				</span>	
			@endif
		  </div>
		  <div class="form-group">
			<label for="pwd">Profile Image:</label>
			<img src="{{ asset('public/images/avatar') }}/{{$user->avtar}}"/>
			<input type="file" class="form-control{{ $errors->has('userimg') ? ' is-invalid' : '' }}"  name="userimg" id="profilepic">
			<input type="hidden" class="form-control" name="old_image" value="{{$user->avtar}}" >
			@if($errors->has('userimg'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('userimg')}}</strong>
				</span>
				
			@endif
		 </div>
		  <button type="submit" class="btn btn-default">Submit</button>
		</form>
		
@endsection

		
																																												