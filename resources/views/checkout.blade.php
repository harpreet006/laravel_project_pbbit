 @extends('layouts.app')

 @section('title','home')

@section('style')

@endsection

 @section('content')      
        <!-- checkout_section">  -->
        <div class="checkout_section">
            <div class="container">
                <div class="row">   
                <div class="col-sm-4">        
                                
                    @php  $nameproduct = array();@endphp
                     @foreach($cart as $item)                     
                   <div class="inner-checkout">
                    <h3 class="headings">{{$item->name }}</h3>
                        @php
                        $nameproduct[]= $item->name;

                        @endphp
                    {{$item->name }}
                    <div class="row ">
                        <div class="col-md-5">
                            <div class="bx-1eft">   
                    @php                               

                        $image = '' ;
                        if(file_exists('public/uploads/thumnail/'.$item->options->image.'') && ($item->options->image !='')){
                             $image = asset('public/uploads/thumnail/'.$item->options->image.'');
                                }else{
                                 $image = asset('public/frontview/images/NoPicture.jpg');
                        }               
                     
                    @endphp   
                             
                                        <a href=""><img src="{{$image}}" alt="img" class="img-fluid border-radis"/></a> 
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="bxx-right"> 
                                <p class="demi_text ">{{$item->name }}</p>
                                    <p class="student_name name_text11">{{ __('messages.Development_checkout') }}<span> {{ __('messages.by_checkout') }}</span> Admin</p>
                                    <span class="rates">
                                        <del class="delt1">$099</del>
                                        <h3 class="rates1"><span>$</span>{{$item->price}}</h3>
                                    </span>
                            </div>
                            
                        </div>
                        </div>
                    </div>
                        @endforeach
              
                    </div>
                    
                    <div class="col-sm-8">             
             @php echo $paymentmethod; @endphp
                        </div>
                    </div>
                <div></div></div>
            </div>
       
        <!-- checkout_section"> end -->
    
        
    
   <!-- categories-section end -->
    
 {{--@include('components.testimonials')--}}

    <div class="container">       
     @include('components.customcode')
    </div>
    @endsection

    @section('script')
    <script src="{{ asset('public/frontview/assets/js/checkout-script.js') }}"></script>
    @endsection