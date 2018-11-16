 @extends('layouts.app')

 @section('title','home')

@section('style')
<style type="text/css">
    .jconfirm-box img, video {
    width: 100%;
    width: -moz-available;
    width: -webkit-fill-available;
}
</style>
@endsection

 @section('content')

        <div class="container no_padding_mob">
                <div class="outer_sec">
                <div class="inner_sec">
                </div>
                <div class="inner_box_section">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="first_bx">
                            <img src="{{ url('public/frontview/images/icon-1.png')}}" alt="img"/>
                            <h4> {{ __('messages.home_onlinecourse') }}</h4>
                            <p> {{ __('messages.home_explore_text') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4  col-md-4 col-12">
                        <div class="first_bx">
                            <img src="{{ url('public/frontview/images/icon-2.png')}}" alt="img"/>
                            <h4> {{ __('messages.home_expert_instru') }} </h4>
                            <p> {{ __('messages.home_expert_instru_text') }} </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="first_bx">
                            <img src="{{ url('public/frontview/images/icon-3.png')}}" alt="img"/>
                            <h4>{{ __('messages.home_Acess') }} </h4>
                            <p> {{ __('messages.home_Acess_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- inner_box_section end -->
        </div>
    
        <div class="container mt-40 ">
          <div class="bx_section">
            <h2 class="text-center heading_text"> {{ __('messages.home_most_commprehensive') }} </h2>
                <div class="row">
                    @if($courses)
                    @foreach($courses as $course)
                    <div class="col-md-4">
                        <div class="video_section">

                              <?php  $video = (isset($course->video->url))?url('public/uploads/videos/'.$course->video->url):'';

                                    $img = (isset($course->video->thumb_url))?url('public/uploads/videos/thumb/'.$course->video->thumb_url):url('/public/frontview/images/video_1.png'); 
                                ?> 

                            <div class="video1">
                                <img src="{{ $img }}" alt="img" class="vide" height="230px" />
                                <div class="hover_backcolor"> 
                                </div>
                                <a href="#" class="view_video" v-url="{{$video}}"><img src="{{url('/public/frontview/images/play_btnn.png')}}" alt="img" class="play-btn"/></a>
                                <h4 class="inner_heading">{{ $course->course_name }}</h4>
                            </div>
                            <div class="student_view">
                                <h4>{{ $course->course_name }}</h4>
                                <p class="student_name name_text1"><span>   {{ __('messages.created_by') }}</span> {{ $course->user->name }}</p>
                                <p class="student_name name_text2"><span>  {{ __('messages.last_update') }} </span>{{  date('M d,  Y', strtotime($course->updated_at)) }} </p>
                                    <span class="rates">
                                    <del class="delts">${{$course->course_price}}</del>
                                    <h3 class="rates1"><span>$</span>{{$course->actual_price}}</h3>
                                    </span>
									
									<div class="ration-sectiondash" style="clear:both">	
									<div class="ratingdash selected" method="POST" action="{{url('download')}}">
										<input type="radio" id="star5" name="rating10" value="5" {{ $course->rating == 5 ? "checked" : "" }} disabled=""=""><label  ratingact="5" class = "full" for="star5" title="Awesome - 5 stars"></label>
										<input type="radio" id="star4half" name="rating9" value="4 and a half" {{ $course->rating  == 4.5 ? "checked" : "" }} disabled=""=""><label ratingact="4.5" class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
										<input type="radio" id="star4" name="rating8" value="4" {{ $course->rating == 4 ? "checked" : "" }} disabled=""=""><label ratingact="4" class = "full" for="star4" title="Pretty good - 4 stars"></label>
										<input type="radio" id="star3half" name="rating7" value="3 and a half" {{ $course->rating  == 3.5 ? "checked" : "" }} disabled=""=""><label  ratingact="3.5" class="half" for="star3half" title="Meh - 3.5 stars"></label>
										<input type="radio" id="star3" name="rating6" value="3" {{ $course->rating == 3 ? "checked" : "" }} disabled=""=""><label  ratingact="3" class = "full" for="star3" title="Meh - 3 stars"></label>
										<input type="radio" id="star2half" name="rating5" value="2 and a half" {{ $course->rating  == 2.5 ? "checked" : "" }} disabled=""=""><label ratingact="2.5" class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
										<input type="radio" id="star2" name="rating4" value="2" {{ $course->rating  == 2 ? "checked" : "" }} disabled=""=""><label ratingact="2" class = "full" for="star2" title="Kinda bad - 2 stars" ></label>
										<input type="radio" id="star1half" name="rating3" value="1 and a half" {{ $course->rating == 1.5 ? "checked" : "" }} disabled=""=""><label ratingact="1.5" class="half" for="star1half" title="Meh - 1.5 stars"></label>
										<input type="radio" id="star1" name="rating2" value="1" {{ $course->rating == 1 ? "checked" : "" }} disabled=""=""><label ratingact="1" class = "full" for="star1" title="Sucks big time - 1 star"></label>
										<input type="radio" id="starhalf" name="rating1" value="half" {{ $course->rating == 0.5 ? "checked" : "" }} disabled=""=""><label  ratingact="0.5" class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>

									</div>
								</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                 
               </div>
          </div>
        </div>
    <!-- categories-section -->
   <div class="categories-section">
        <div class="container">
         <h2 class="text-center heading_text">  {{ __('messages.home_document_download') }} </h2>
            <div class="row">

             
          {{--  @foreach($public_doc as $listing) --}}
                <div class="col-md-3">
                    <div class="categories-bx activee in_progress">
                        <img src="{{ url('public/frontview/images/icon-a.png')}}" alt="img">
                        <h4>{{ __('messages.home_download_1') }} </h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="categories-bx in_progress">
                        <img src="{{ url('public/frontview/images/icon-b.png')}}" alt="img">
                        <h4>{{ __('messages.home_download_2') }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="categories-bx in_progress">
                        <img src="{{ url('public/frontview/images/icon-c.png')}}" alt="img">
                        <h4>{{ __('messages.home_download_3') }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="categories-bx in_progress">
                        <img src="{{ url('public/frontview/images/icon-d.png')}}" alt="img">
                        <h4>{{ __('messages.home_download_4') }}</h4>
                    </div>
                </div>
               {{-- @endforeach --}}
            </div>
        </div>
   </div>
   <!-- categories-section end -->
   <!-- Students are viewing  -->
   <div class="students-viewing">
        <div class="container">
            <h4 class="view_heading"> {{ __('messages.home_student_viewer') }}</h4>
            <div class="row">
                <div class="col-md-3 col-12 in_progress" >
                    <div class="student_view">
                        <h5 class="best-seller">{{ __('messages.best_seller') }} </h5>
                        <h4>Advanced CSS and Sass: Flexbox, Grid, Animations and More!</h4>
                        <p class="student_name"><span>by</span> Jonas</p>
                        
                        <div class="play">
                            <span class="play_text"><img src="{{ url('public/frontview/images/play_img.png')}}" alt="img">Play NOW</span>
                            <span class="rate">
                            <h3 class="rate1">$099</h3>
                            <del class="delt">$099</del>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 in_progress">
                    <div class="student_view">
                        <h5 class="best-seller">{{ __('messages.best_seller') }} </h5>
                        <h4>Advanced CSS and Sass: Flexbox, Grid, Animations and More!</h4>
                        <p class="student_name"><span>by</span> Jonas</p>
                        
                        <div class="play">
                            <span class="play_text"><img src="{{ url('public/frontview/images/play_img.png')}}" alt="img">Play NOW</span>
                            <span class="rate">
                            <h3 class="rate1">$099</h3>
                            <del class="delt">$099</del>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 in_progress">
                    <div class="student_view">
                        <h5 class="best-seller">{{ __('messages.best_seller') }} </h5>
                        <h4>Advanced CSS and Sass: Flexbox, Grid, Animations and More!</h4>
                        <p class="student_name"><span>by</span> Jonas</p>
                        
                        <div class="play">
                            <span class="play_text"><img src="{{ url('public/frontview/images/play_img.png')}}" alt="img">Play NOW</span>
                            <span class="rate">
                            <h3 class="rate1">$099</h3>
                            <del class="delt">$099</del>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 in_progress">
                    <div class="student_view">
                        <h5 class="best-seller">{{ __('messages.best_seller') }} </h5>
                        <h4>Advanced CSS and Sass: Flexbox, Grid, Animations and More!</h4>
                        <p class="student_name"><span>by</span> Jonas</p>
                        
                        <div class="play">
                            <span class="play_text"><img src="{{ url('public/frontview/images/play_img.png')}}" alt="img">Play NOW</span>
                            <span class="rate">
                            <h3 class="rate1">$099</h3>
                            <del class="delt">$099</del>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
   <!-- Students are viewing  end -->
    
    @include('components.testimonials')

    <div class="container">       
     @include('components.customcode')
    </div>
    @endsection

    @section('script')
    <script type="text/javascript">
     

    </script>
    @endsection



                                  