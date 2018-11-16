
 <div class="modal fade" id="coursesection" role="dialog">
<div class="modal-dialog buy-package">    
      <!-- Modal content-->
      <!-- login_page  -->
<div class="modal-content">
<div class="login_page" id="add_popup_frm">
            <div class="frm add_popup_frm">
                <a href="#" class="cross_img cross_img_package">X</a>
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="frm_heading">{{Lang::get('messages.frequently_package_page')}}</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="{{url('/checkout')}}" class="checkout_btns">{{Lang::get('messages.Checkout_cart')}}<i class="fas fa-shopping-cart"></i></a> 
                    </div>
                </div>
                <div class="row">   
                    @php ($totalcount = [])  @endphp             
                    @foreach($courselist as $key=> $listing)

                    <div class="col-md-4">
                                        <h3 class="heading-popuptxt">{{ ucfirst($listing->course_name) }} {{ __('messages.course') }}</h3>
                                            <div class="video_section">
                                                <div class="video1">     
                    @php                             
                        $image = '' ;
                        if(file_exists('public/uploads/thumnail/'.$listing->image.'') && ($listing->image !='')){
                            $image = asset('public/uploads/thumnail/'.$listing->image.'');
                        }else{
                            $image = asset('public/frontview/images/NoPicture.jpg');
                        }               

                    @endphp                                               
                                                    <a href="{{url('/')}}@php  echo '/course/'.$lists->course_name; @endphp"><img src="{{$image}}" alt="img" class="img-fluid border-radis"/></a>
                                                </div>
                                                <div class="student_view">
                                                    <h4>{{ ucfirst($listing->course_title) }} </h4>
                                                    <p class="student_name name_text1"><span>{{ __('messages.created_by') }}</span></p>                             
                                                        <span class="rates">
                                                        <del class="delts">${{ $listing->course_price }}</del>
                                                        @php ($names[] = $listing->actual_price) @endphp
                                                        <h3 class="rates1"><span>₹</span>{{ $listing->actual_price }}</h3>
                                                        </span>
                                                        <div class="checkbox checkbox-primary checked packagepbit">             
                                                            @if(in_array($listing->id , $exitarray))
                                                                <input id="checkbox{{$key}}" course-id="{{ $listing->id }}" value="{{ $listing->actual_price }}" name="package{{$key}}" type="checkbox" checked>
                                                            <label for="checkbox{{$key}}">
                                                                <span class="check-span"></span>
                                                            </label>
                                                            @else
                                                                <input id="checkbox{{$key}}" course-id="{{ $listing->id }}" value="{{ $listing->actual_price }}" name="package{{$key}}" type="checkbox">
                                                            <label for="checkbox{{$key}}">
                                                                <span class="check-span"></span>
                                                            </label>
                                                            @endif
                                                            
                                                        </div>                                                  
                                                </div>
                                            </div>
                                        </div>                                      
                    @endforeach             
                </div>
                @php $numberd=0;   @endphp
                                    @foreach($names as $number)                                     
                                        @php $numberd +=$number;   @endphp
                                    @endforeach
                                @php $number=0;   @endphp
                                {{-- implode(', ', $names) --}}     
                <div class="pay_box-heading">{{ __('messages.Total_cart') }}:<!-- <del class="deltss">$0099</del> -->
                        <span class="rates-star"><span>$</span>{{$numberd}}

                        </div>
                                                    
                        <form  class="formcart" method="POST" action="{{url('packagcart')}}">
                                    <input type="hidden"  id="add_package_list" name="product_id" value="">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">                                  
                                    <button type="submit" class="btn btn-fefault add-to-cart">
                                        <i class="fa fa-shopping-cart"></i>
                                        {{ __('messages.bye_now') }}
                                    </button>
                                </form>                     
                        
                    <h2 class="course_heading text-center">{{Lang::get('messages.like_free_document_free_all')}}  <span> 3 courses.</span> </h2>
            </div>
        </div>
    </div>
 </div>
</div>
