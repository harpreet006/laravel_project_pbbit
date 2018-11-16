 @extends('layouts.app')

 @section('title','home')

@section('style')

@endsection

 @section('content')
<div class="beginner-course begin">
		  @foreach($courselist as $lists) 		  
		  @php	  
		   $new_date = date('F d,  Y', strtotime($lists->updated_at));		 

			$image = '' ;
			if(file_exists('public/uploads/thumnail/'.$lists->image.'') && ($lists->image !='')){
				 $image = asset('public/uploads/thumnail/'.$lists->image.'');
					}else{
					 $image = asset('public/frontview/images/NoPicture.jpg');
			}				
		 
		  @endphp
		<div class="{{ strtolower($lists->course_name) }}-course courselisting">			
			<div class="container">
				<div class="row ">
					<div class="col-md-5">
						<div class="bx-1eft">
							
							<h3 class="headings"><a href="{{url('/')}}@php  echo '/course/'.$lists->course_name; @endphp">{{ ucfirst($lists->course_name) }} {{ __('messages.course') }} </a></h3>
							<a href="{{url('/')}}@php  echo '/course/'.$lists->course_name; @endphp"><img src="{{$image}}" alt="img" class="img-fluid border-radis courseimg"/></a>	
						</div>
					</div>
					<div class="col-md-7">
						<div class="bx-right">						
							<p class="demi_text margin-tp">{{ ucfirst($lists->course_title) }}</p>
								<p class="student_name name_text11"><span>{{ __('messages.created_by') }}</span> </p>
								<p class="student_name name_text2"><span>{{ __('messages.last_update') }} </span> {{ $new_date }}</p>
									<span class="rates">								
									<h3 class="rates1"><span>$</span>{{ $lists->actual_price }}</h3>
									</span>						
								<p class="pargh margin-topp">{{ ucfirst(substr($lists->course_description,0,350)) }}...</p>			
                                 <a class="buy_now coursepackage" type="submit">{{ __('messages.start_course') }}</a>
								<form  class="formcart" method="POST" action="{{url('cart')}}">
                                            <input type="hidden" name="product_id" value="{{$lists->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-fefault add-to-cart courselistig_pbit">
                                                <i class="fa fa-shopping-cart"></i>
                                                  {{ __('messages.add_to_cart') }}
                                            </button>
                                        </form>
						</div>
					</div>
				</div>
				</div>
				</div>
				<!-- course-list end -->
				@endforeach
		</div>
		<!-- Beginner Course end -->
    <div class="container">       
     @include('components.customcode')
    </div>
     <div class="container">       
     @include('components.course_popup')
    </div>
    @endsection
    @section('script')
    <script type="text/javascript">
     

    </script>
    @endsection



                                  