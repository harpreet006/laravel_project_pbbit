@extends('layouts.app-user')

@section('title','dashboard')

@section('right-content')
	<?php $user = Auth::user();

$name=explode(' ', $user->name);
if(!empty($name[0])){$user->first_name=$name[0];}else{$user->first_name="";}
if(!empty($name[1])){$user->last_name=$name[1];}else{$user->last_name="";} 

	 ?>
		<form class="update-profile_pbit" enctype="multipart/form-data" method="POST" action="{{url('/')}}/updateProfile">
		 @csrf
		  <div class="form-group form_1">
			<label for="name">First Name:</label>
			<input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{$user->first_name}}" id="name">
		    @if ($errors->has('first_name'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('first_name') }}</strong>
				</span>
            @endif
		  </div>
		   <div class="form-group form_2">
			<label for="name">Last Name:</label>
			<input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{$user->last_name}}" id="name">
			@if($errors->has('last_name'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('last_name')}}<strong>
				</span>	
			@endif
		  </div>
		  <div class="form-group form_3">
			<label for="pwd">Profile Image:</label>
			@php
			$userImg = '';
			if($user->avtar != ''){
				if(file_exists('public/images/avatar/'.$user->avtar.'')){
					$userImg =   "public/images/avatar/".$user->avtar;		
				}else{
					$userImg = "public/frontview/images/NoPicture.jpg";
				}					
			}else{
				$userImg = "public/frontview/images/NoPicture.jpg";
			}
			@endphp
			<img src="{{$userImg}}" class="profileimg"/>
			<input type="file" class="form-control{{ $errors->has('userimg') ? ' is-invalid' : '' }}"  name="userimg" id="profilepic">
			<input type="hidden" class="form-control" name="old_image" value="{{$user->avtar}}" >
			@if($errors->has('userimg'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('userimg')}}</strong>
				</span>
				
			@endif
		 </div>
		  <button type="submit" class="btn btn-default submit_change_pass">Submit</button>
		</form>
		
@endsection

		
																																												