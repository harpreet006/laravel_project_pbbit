     <div class="beginner-course">
            <div class="container">
                <div class="row ">
                    <div class="col-md-7">
                        <div class="beginner-left-section">
                            <!-- <img src="{{ url('public/frontview/images/beginers_course_img.jpg')}}" alt="img"/> -->
                            <video width="600" height="410" controls controlsList='nodownload'>
                            <source src="{{url('public/uploads/videos/')}}/{{$trialVideo[0]->trailer_url}}" type="video/mp4">
                            <source src="movie.ogg" type="video/ogg">
                              Your browser does not support the video tag.
                            </video>
                        </div>

                    </div>
                    <div class="col-md-5">
                    
                    @if(count($topicDetail) > 0)
                    @foreach($topicDetail as $topicData)
                        <div class="beginner-right-section">
                            <h3 class="main_text1">{{ ucfirst($class) }} Course </h3>
                            <p class="demi_text margin-tp">{{ $topicData->title }} </p>                
                                @php
                                    $new_date = date('F d,  Y', strtotime($topicData->title));
                                @endphp
                                <p class="student_name name_text11"><span>Created by</span> {{ $lists[0]->user->name }}</p>
                                 @php  $new_date = date('F d,  Y', strtotime($topicData->updated_at)); @endphp
                                <p class="student_name name_text21"><span>{{ Lang::get('messages.last_update') }} </span> {{$new_date}}</p>
                                    <span class="rates">   
                                    <h3 class="rates1"><span>$</span> {{ $lists[0]->course->course_price != "" ? $lists[0]->course->course_price : "" }}</h3>
                                    </span>
                                <p class="pargh margin-topp">{{ $topicData->description != "" ? substr($topicData->description, 0, 350)."....!": "Soon..." }} </p>

                                    <form  class="formcart" method="POST" action="{{url('cart')}}">
                                    <input type="hidden" name="product_id" value="{{$lists[0]->course->id}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-fefault add-to-cart">
                                        <i class="fa fa-shopping-cart"></i>
                                        {{ __('messages.bye_now') }}
                                    </button>
                                </form>
                                
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>