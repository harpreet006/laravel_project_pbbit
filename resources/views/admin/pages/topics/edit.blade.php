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
	ul.thumd-list {
    margin: 0;
    padding: 0;
}
ul.thumd-list li {
    margin: 0 4px;
    padding: 0;
    float: left;
    list-style: none;
    position: relative;
    font-size : 16px;
}

ul.thumd-list li i{
	display: inline-block;
	padding-right: 0px;
	vertical-align: top;
	top: -8px;
	position: absolute;
	right: 0px;
	color: #d2312d;
	text-shadow: 0px 0px 2px #0009;
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
            <li><span>Edit Topics</span></li>
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
				<h2 class="card-title">Edit {{ $topic->title}}</h2>
			</header>
			<div class="card-body">
				<form class="form-horizontal form-bordered" id="edit-topic-form" action="{{ action('TopicController@update',[$topic->id])}}" method="post" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Title</label>
						<div class="col-lg-6">
							<input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ $topic->title}}">
							@if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Description</label>
						<div class="col-lg-10">
							<textarea name="description" data-plugin-markdown-editor rows="10">{{ $topic->description}}</textarea>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Select Course</label>
						<div class="col-lg-6">
							<select  class="form-control populate" name="course_id"  id="course_id">
								@foreach($courses as $course)
								<?php $selected = ($course->id == $topic->course_id)?true:false;?>
									<option value="{{$course->id}}" selected="{{$selected}}">{{$course->course_name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Select Chapter</label>
						<div class="col-lg-6">
							<select  class="form-control populate" name="chapter_id" id="chapter_id">
							        <option value="" > select chapter </option>
								@foreach($chapters as $chapter)
								<?php $selected2 = ($chapter->id == $topic->chapter_id)?'selected=selected':'';?>
									<option value="{{$chapter->id}}" {{$selected2}}>{{$chapter->title}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Price </label>
						<div class="col-lg-6">
							<input type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" min="1" value="{{ $topic->price}}" >
							@if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
						</div>
					</div>


					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Upload Thumnail</label>
						<div class="col-lg-5">
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
								@if ($errors->has('image'))
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $errors->first('image') }}</strong>
	                                </span>
	                            @endif
						</div>
						<div class="col-lg-5">
							<ul class="thumd-list">
								@if($topic->image)
								<li>
									<i class="fa fa-remove remove_file" file-type="thumnail_id" file-id="{{$topic->image}}"  aria-hidden="true"></i>
									<img src="{{ url('public/uploads/thumnail').'/'.$topic->image}}" width="50" height="50" class="view_image" >
								</li>
								@endif
							</ul>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Upload Video</label>
						<div class="col-lg-5">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input">
										<i class="fa fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-default btn-file">
										<span class="fileupload-exists">Change</span>
										<span class="fileupload-new">Select file</span>
										<input type="file" name="video[]" accept="video/mp4, video/ogg,video/wmv,video/avi" >
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
							<div class="col-lg-5">
								<ul class="thumd-list">
									@if(count($topic->video))
										@foreach($topic->video as $video)
										<li>
											<i class="fa fa-remove remove_file" file-type="video_ids" file-id="{{$video->id}}" aria-hidden="true"></i>
											<img src="{{url('public/uploads/videos/thumb').'/'.$video->thumb_url}}" v-url="{{url('public/uploads/videos').'/'.$video->url}}" class="view_video" width="50" height="50">
										</li>
										@endforeach
									@endif
								</ul>
							</div>
					</div>


					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Upload Trailer Video</label>
						<div class="col-lg-5">
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
                                <span class="invalid-feedback" role="trailer_video">
                                    <strong>{{ $errors->first('trailer_video') }}</strong>
                                </span>
		                    @endif
						</div>

						<div class="col-lg-5">
							<ul class="thumd-list">
								@if(count($topic->trailer_video))
									@foreach($topic->trailer_video as $trail_video)
									<li> 
										<i class="fa fa-remove remove_file" file-type="trailer_id" file-id="{{$trail_video->id}}"  aria-hidden="true"></i>
										<img src="{{url('public/uploads/videos/thumb').'/'.$trail_video->trailer_thumb_url}}" v-url="{{url('public/uploads/videos').'/'.$trail_video->trailer_url}}" class="view_video" width="50" height="50">
									</li>
									@endforeach
								@endif
							</ul>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2">Upload Document
							<small>(optional)</small></label>
						<div class="col-lg-5">
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

						<div class="col-lg-5">
								<ul class="thumd-list">
									@if(count($topic->document))
										@foreach($topic->document as $doc)
										<li>
											<i class="fa fa-remove remove_file" file-type="document_ids"  file-id="{{$doc->id}}" aria-hidden="true"></i>
											<img src="{{url('public/img/pdf.png')}}" pdf-src="{{url('public/uploads/documents').'/'.$doc->document_url}}" class="view_pdf" width="50" height="50">
										</li>
										@endforeach
									@endif
								</ul>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 control-label text-lg-right pt-2" for="inputHelpText">Publish</label>
						<div class="col-lg-6">
							<?php 
						    $options = ['0' => 'Unpublish' , '1' => 'published'] ;
						     ?>
							{!! Form::select('publish', $options, $topic->publish ,  ['class' => 'form-control', ]) !!}
						</div>
					</div>


					<input type="hidden" name="thum_id" >
					<input type="hidden" name="video_ids" >
					<input type="hidden" name="document_ids" >
					<input type="hidden" name="trailer_id" >
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
$(document).ready(function(){


  var active_link = 0;

  active_nav_links(6,active_link);

  
var that = null;

$("#edit-topic-form input[type='hidden']").not( $( "#edit-topic-form input[type='hidden']" )[ 0 ]).not( $( "#edit-topic-form input[type='hidden']" )[ 1 ] ).val('');

	$('.view_image').on('click',function(){
        
         that = $(this); 

		$.confirm({
		    title: '',
		    content: '<img src="'+that.attr('src')+'">',
		    animation: 'scale',
		    animationClose: 'top',
		    columnClass:'col-md-6 col-md-offset-3',
		    buttons: {
		      
		      close: function() {
		        // lets the user close the modal.
		      }
		    },
		  });
	});

	$('.view_video').on('click',function(){
        that = $(this); 
		
		$.confirm({
		    title: '',
		    content: '<video width="400" controls>'+
						  '<source src="'+that.attr('v-url')+'" type="video/mp4">'+
						  '<source src="'+that.attr('v-url')+'" type="video/ogg">'+
						  'Your browser does not support HTML5 video.'+
					  '</video>',
		    animation: 'scale',
		    animationClose: 'top',
		    columnClass:'col-md-6 col-md-offset-3',
		    buttons: {
		      close: function() {
		        // lets the user close the modal.
		      }
		    },
		  });
	});

var that = null;
	$('.view_pdf').on('click',function(){
        that = $(this); 
		
		$.confirm({
		    title: '',
		    content: '<embed src="'+that.attr('pdf-src')+'" type="application/pdf" width="100%" height="600px"  />',
		    animation: 'scale',
		    animationClose: 'top',
		    columnClass:'col-md-10 col-md-offset-3',
		    buttons: {
		      close: function() {
		        // lets the user close the modal.
		      }
		    },
		  });
	});

var thumnail_id = 0 ;
var video_ids = [] ;
var document_ids = [] ;
var trailer_id = 0 ;

$('.remove_file').on('click',function(){
	var image_id  =  $(this).attr('file-id');
	var image_type=  $(this).attr('file-type');

switch (image_type) {

    case 'thumnail_id':
        thumnail_id = image_id ;   
        $("input[name='thum_id']").val(thumnail_id);
        break;
    case 'video_ids':
        video_ids.push(image_id) ;   
        $("input[name='video_ids']").val(video_ids);
        break;
    case 'document_ids':
        document_ids.push(image_id) ;   
        $("input[name='document_ids']").val(document_ids);
        break;
    case 'trailer_id':
        trailer_id = image_id ;   
        $("input[name='trailer_id']").val(trailer_id);
        break;
    case 6:
        return false;
}
$(this).parent().remove();

});

$('#course_id').on('change',function(){
 var id  = $('#course_id option:selected').attr('value');
 var html ="<option value='' > select chapter </option>";
           $('#chapter_id').html(html);
   $.ajax({
  	type : 'GET',
	url  : "{{route('get-chapters')}}",
	data : { course_id : id },
	success: function(res){
		
		if(res.data !== null){
			$.each(res.data,function(indx,val){
				html+="<option value='"+val.id+"'>"+val.title+"</option>";
			});
		}
		$('#chapter_id').html(html);
	}
   });
});

});

</script>
@endsection