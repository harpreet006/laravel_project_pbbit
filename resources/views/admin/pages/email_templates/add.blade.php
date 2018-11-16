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
            <li><span>Add Email Templates</span></li>
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
				<h2 class="card-title">Create Template</h2>
			</header>
			<div class="card-body">
				<form class="form-horizontal form-bordered" action="{{ action('EmailTemplateController@store')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Name</label>
						<div class="col-lg-6">
							<input type="text" class="form-control{{ $errors->has('template_name') ? ' is-invalid' : '' }}" name="template_name" value="{{old('template_name')}}">
							@if ($errors->has('template_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('template_name') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Template Body</label>
						<div class="col-lg-10">
							<textarea name="template" data-plugin-markdown-editor rows="10">{{old('template')}}</textarea>
						</div>
					</div>

					
					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Use Template For</label>
						<div class="col-lg-6">
							<select  class="form-control populate" name="template_for">
								<option value="">Select Event</option>
								@foreach($events as $key => $event)
									<option value="{{$key}}">{{$event}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Available Variables in templates</label>
						<div class="col-lg-10 forarea-box">
							@foreach($available_virables as $virables)
							<ul class="foraria-ul">
							 	@foreach($virables as $coll)
							 	<li>{${{$coll}}}</li>
							 	@endforeach
							</ul>
						   @endforeach
					    </div>
					</div>


					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Status</label>
						<div class="col-lg-6">
							<select  class="form-control populate" name="status">
									<option value="active">active</option>
									<option value="inactive">Inactive</option>
							</select>
						</div>
					</div>

					 <div class="form-group row mb-0" style="float: right;">
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
  active_nav_links(11,active_link);

</script>
@endsection