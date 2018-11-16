@extends('layouts.app-user')

@section('title','dashboard')

	@section('right-content')
	@foreach($profiledata as $user)
	@if(Session::has('status'))
			<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</p>
		@endif
		<form method="POST" action="{{url('/')}}/update-password" id="change-password">
		 @csrf
		    <div class="form-group">
				<label for="name">Password:</label>
				<input type="password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" value="" id="name">
				@if ($errors->has('old_password'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('old_password') }}</strong>
					</span>
				@endif
		    </div>
		    <div class="form-group">
			<label for="name">New Password:</label>
			<input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="" id="name">
		    @if ($errors->has('password'))
				<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
			@endif		
			</div>
			
		    <div class="form-group">
			<label for="name">Confirm Password:</label>
			<input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" value="" id="password-confirm">
			@if($errors->has('password_confirmation'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('password_confirmation')}}<strong>
				</span>	
			@endif
		    </div>
		    <button type="submit" class="btn btn-default submit_change_pass">Submit</button>
		</form>
	@endforeach				
@endsection



		

																																												