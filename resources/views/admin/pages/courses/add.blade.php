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
            <li><span>Add Course</span></li>
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
				<h2 class="card-title">Add Course</h2>
			</header>
			<div class="card-body">
				<form class="form-horizontal form-bordered" action="{{ action('CourseController@store')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Course Name</label>
						<div class="col-lg-6">
							<input type="text" class="form-control{{ $errors->has('course_name') ? ' is-invalid' : '' }}" name="course_name" value="{{old('course_name')}}">
							@if ($errors->has('course_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('course_name') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Title</label>
						<div class="col-lg-6">
							<input type="text" class="form-control{{ $errors->has('course_title') ? ' is-invalid' : '' }}" name="course_title" value="{{old('course_title')}}">
							@if ($errors->has('course_title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('course_title') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText"><span style="text-decoration: line-through;"> Price</span> / Actual Price</label>
						<div class="col-lg-3">
							<input type="number" class="form-control{{ $errors->has('course_price') ? ' is-invalid' : '' }}" name="course_price" value="{{old('course_price')}}">
							@if ($errors->has('course_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('course_price') }}</strong>
                                </span>
                            @endif
						</div>

						<div class="col-lg-3">
							<input type="number" class="form-control{{ $errors->has('actual_price') ? ' is-invalid' : '' }}" name="actual_price" value="{{old('actual_price')}}">
							@if ($errors->has('actual_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('actual_price') }}</strong>
                                </span>
                            @endif
						</div>

					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Description</label>
						<div class="col-lg-10">
							<textarea name="course_description" data-plugin-markdown-editor rows="10">{{old('course_description')}}</textarea>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Upload Image</label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input">
										<i class="fa fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-default btn-file">
										<span class="fileupload-exists">Change</span>
										<span class="fileupload-new">Select file</span>
										<input type="file" name="image" accept="image/png, image/jpeg,image/jpg" >
									</span>
									<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
								@if ($errors->has('thumnail'))
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $errors->first('thumnail') }}</strong>
	                                </span>
	                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Upload Video</label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input">
										<i class="fa fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-default btn-file">
										<span class="fileupload-exists">Change</span>
										<span class="fileupload-new">Select file</span>
										<input type="file" name="video" accept="video/mp4, video/ogg,video/wmv,video/avi" >
									</span>
									<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
									
								</div>
							</div>
							@if($errors->has('video'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('video') }}</strong>
                                </span>
		                    @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Upload Trailer Video</label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input">
										<i class="fa fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-default btn-file">
										<span class="fileupload-exists">Change</span>
										<span class="fileupload-new">Select file</span>
										<input type="file" name="trailer_video" accept="video/mp4, video/ogg,video/wmv,video/avi" >
									</span>
									<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
							@if($errors->has('trailer_video'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('trailer_video') }}</strong>
                                </span>
		                    @endif
						</div>
					</div>


					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Upload Document
							<small>(optional)</small></label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input">
										<i class="fa fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-default btn-file">
										<span class="fileupload-exists">Change</span>
										<span class="fileupload-new">Select file</span>
										<input type="file" name="document[]" accept="" >
									</span>
									<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
								@if ($errors->has('document'))
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $errors->first('document') }}</strong>
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
  var active_link = 1;
  active_nav_links(2,active_link);

</script>
@endsection