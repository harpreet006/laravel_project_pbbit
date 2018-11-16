@extends('admin.layouts.main')


@section('style')
<link rel="stylesheet" href="{{ asset('public/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}" />
<link rel="stylesheet" href="{{ asset('public/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css')}}" />
<style type="text/css">
	.text-lg-right{
		text-align: left !important;
	}
	.invalid-feedback{
		display: block !important;
	}
</style>
@endsection


@section('content')
<section role="main" class="content-body card-margin">

	<header class="page-header">
        <h2 style="width: 27%">
          <a href="{{url()->previous()}}" class=""> 
          	<i class="fa fa-chevron-left"></i>Back
          </a>
        </h2>
      
        <div class="right-wrapper text-right">
          <ol class="breadcrumbs">
            <li>
              <a href="{{url('/admin/dashboard')}}">
                <i class="fa fa-home"></i>
              </a>
            </li>
            <li><span>Dashboard</span></li>
            <li><span>Add Topics</span></li>
          </ol>
          
          <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

<div class="row">
	<div class="col">
		<section class="card">
			<header class="card-header">
				<div class="card-actions">
					<a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
					<a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
				</div>
				<h2 class="card-title">Create New Coupon</h2>
			</header>
			<div class="card-body">
				<form class="form-horizontal form-bordered" action="{{ action('CouponController@store')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Promotion Code</label>
						<div class="col-lg-6">
							<input type="text" class="form-control{{ $errors->has('promotion_code') ? ' is-invalid' : '' }}" name="promotion_code" value="{{old('promotion_code')}}">
							@if ($errors->has('promotion_code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('promotion_code') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Type</label>
						<div class="col-lg-3">
							<select  class="form-control populate" name="type">
									<option value="fixed_amount">Fixed Amount </option>
									<option value="percentage"> Percentage </option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Value </label>
						<div class="col-lg-3">
							<input type="number" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" name="value" min="1" value="{{old('value')}}" >
							@if ($errors->has('value'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('value') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Apply To</label>
						<div class="col-lg-3">
							<select  class="form-control populate" name="apply_on[]" multiple="true">
								@foreach($courses as $course)
									<option value="{{$course->id}}">{{$course->course_name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Start date </label>
						<div class="col-lg-6">
							<input type="date" class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" name="start_date" min="1" value="{{old('start_date')}}" >
							@if ($errors->has('start_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('start_date') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Expiry Date </label>
						<div class="col-lg-6">
							<input type="date" class="form-control{{ $errors->has('expiry_date') ? ' is-invalid' : '' }}" name="expiry_date" min="1" value="{{old('expiry_date')}}" >
							@if ($errors->has('expiry_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('expiry_date') }}</strong>
                                </span>
                            @endif
						</div>
					</div>


					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Number of Users </label>
						<div class="col-lg-6">
							<input type="number" class="form-control{{ $errors->has('number_of_user') ? ' is-invalid' : '' }}" name="number_of_user" min="1" value="{{old('number_of_user')}}" >
							@if ($errors->has('number_of_user'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('number_of_user') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Max Users </label>
						<div class="col-lg-6">
							<input type="number" class="form-control{{ $errors->has('max_user') ? ' is-invalid' : '' }}" name="max_user" min="0" value="{{old('max_user')}}" >
							@if ($errors->has('max_user'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('max_user') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 control-label text-lg-right pt-2">Apply Options</label>
						<div class="col-lg-6">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="apply_once" value="1"  >
							Apply only once per Order(enen if multiple items qualify)
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" n value="1" > Apply only existing clients only.
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox"  value="1"  > Apply to new signups only (must have no privious active orders)
								</label>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Admin Note </label>
						<div class="col-lg-6">
							<textarea  class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" name="note"  >{{old('note')}}</textarea>
							@if ($errors->has('note'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('note') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					 <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>

				</form>
			</div>
		</section>
	</div>
</div>
</section>
@endsection


@section('script')
<script src="{{ asset('public/vendor/autosize/autosize.js')}}"></script>
<script src="{{ asset('public/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
<script src="{{ asset('public/vendor/bootstrap-markdown/js/markdown.js')}}"></script>
<script src="{{ asset('public/vendor/bootstrap-markdown/js/to-markdown.js')}}"></script>
<script src="{{ asset('public/vendor/bootstrap-markdown/js/bootstrap-markdown.js')}}"></script>
<script type="text/javascript">	
  var active_link = 0;
  active_nav_links(15,active_link);
</script>
@endsection