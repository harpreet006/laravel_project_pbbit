@extends('layouts.app')

@section('title','home')

@section('style')

@endsection

 @section('content')      
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb shopping_cart">            
                <li class="active">{{ __('messages.Shopping_cart') }}</li>
            </ol>
        </div>

        <div class="table-responsive cart_info">
            @if(count($cart))
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">{{ __('messages.Items_cart') }}</td>
                        <td class="description"></td>
                        <td class="price">{{ __('messages.Price_cart') }}</td>
                        <td class="quantity">{{ __('messages.Quantity_cart') }} </td>
                        <td class="total"></td>
                        
                    </tr>
                </thead>
                <tbody>
                    @php  $count=1; @endphp
                    @foreach($cart as $item)
                    <tr>
                        <td class="cart_product">
                             @php  echo $count; @endphp
                             
                        </td>
                        <td class="cart_description">
                    @php                               

                        $image = '' ;
                        if(file_exists('public/uploads/thumnail/'.$item->options->image.'') && ($item->options->image !='')){
                             $image = asset('public/uploads/thumnail/'.$item->options->image.'');
                                }else{
                                 $image = asset('public/frontview/images/NoPicture.jpg');
                        }               
                     
                    @endphp
                            <h4><a href=""> <img class="product_image_cart" style="width:10%" src="{{$image}}" alt="img" class="img-fluid border-radis"/>{{$item->name}}</a></h4>                           
                        </td>
                        <td class="cart_price">
                            <p>${{$item->price}}</p>
                        </td>
                     <!--    <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                
                               
                                 <form  class="formcart" method="POST" action="{{url('cartplus')}}">
                                            <input type="hidden" name="product_id" value="{{$item->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-fefault add-to-cart">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </form>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{$item->qty}}" autocomplete="off" size="2">
                                <form  class="formcart" method="POST" action="{{url('cartminus')}}">
                                            <input type="hidden" name="product_id" value="{{$item->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-fefault add-to-cart">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </form>
                            
                            </div>
                        </td> -->
                        <td class="cart_total">
                            <p class="cart_total_price">1</p>
                        </td>
                        <td class="cart_delete">
                            <form  class="formcart" method="POST" action="{{url('remove')}}">
                                            <input type="hidden" name="product_id" value="{{$item->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-fefault add-to-cart">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
 


                            <!--   <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>  -->
                        </td>
                    </tr>
                     @php  $count++; @endphp
                    @endforeach
                    @else
                 <div class="No-item-in-cart">
                <p>{{ __('messages.cart_empty_message') }}</p>
                <div class="continue-shopping-btn"><a href="{{url('/course')}}">{{ __('messages.Continue_shopping_cart') }}</a></div>
                </div>
                @endif
                </tbody>
            </table>
             <div class="apply-coupon">
            <ol class="breadcrumb shopping_cart">            
                <li class="active">
                    <input type="text" id="coupon" name="coupon" placeholder="Apply Coupon Here">
                    <button id="apply-coupon">Apply</button>
                    <button id="remove-coupon" style="display: none;">Remove Coupon</button>
                </li>
            </ol>
        </div>
        </div>
    </div>

</section> <!--/#cart_items-->



@if(count($cart))
<section id="do_action">
    <div class="container">
        <div class="heading">
        <!--        <h3>What would you like to do next?</h3> -->
        </div>
        <div class="row discount-container" >
            <div class="col-sm-8">
                <div class="chose_area">
                    <ul class="user_info">
                    <li> {{ __('messages.Shipping_Cost_cart') }} <span> {{ __('messages.Shipping_Cost_Free_cart') }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="total_area">
                <ul>
                <li>{{ __('messages.Total_cart') }}<span> ${{Cart::subtotal()}}</span></li>
                </ul>
                </div>
            </div>
         </div>

 <div class="row">
@if (Auth::check())
    <div class="col-sm-12"> 
    <form  class="formcart" method="POST" action="{{url('checkout')}}">
    <input type="hidden" name="total_amount" value="{{Cart::subtotal()}}"> 
        @php $count=0; @endphp
        @foreach($gatewaylisting as $key=> $listing)  
   
            <div class="pay-box changeposition{{$count}}">                
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">              
                <div class="row no-gutters">
                    <div class="col-sm-10">
                        <div class="radio radio-primary">                          
                            <input name="radio1" id="radio{{$count}}" value="{{$listing->name}}"  {{ $count === 1 ? "checked" : "" }}  type="radio">
                            <label for="radio{{$count}}" class="label-textt">

                                {{$listing['name']}}                            
                                
                            </label>
                            <p class="pargh">{{ __('messages.cart_page_text') }}</p>
                            
                        </div>
                    </div>                            
                </div>                          
            </div>

            @php $count++; @endphp          
        @endforeach
         <button type="submit" class="btn btn-fefault add-to-checkout">{{ __('messages.Checkout_cart') }}</button>
    </form>
    </div>
@endif

   <div class="col-sm-4">
                    <div class="total_area">
                       
                            @if (Auth::check())                        

                             @else
                               <button  class="btn login_btnn checkoutsection" id="mycheckout" type="submit">{{ __('messages.Checkout_cart') }}</button>
                         
                            @endif
                    @endif        
                                   
                           </div>
                        </div> 
  

                </div>
        </div>
</section><!--/#do_action-->


    
 {{--@include('components.testimonials')--}}

    <div class="container">       
     @include('components.customcode')
    </div>
    @endsection

@section('script')
<script src="{{ asset('public/frontview/assets/js/checkout-script.js') }}"></script>
<script type="text/javascript">
    var IS_APPLIED = false ;
    var COUPON =  '';
    $(document).ready(function(){
        $('#apply-coupon').on('click',function(e){
            e.preventDefault();
            var that = $(this);
            var coupon = $('#coupon').val();
            if(IS_APPLIED){
                $.alert('you have already apply coupon on this');
                return false;
            }
            if(coupon ==  ''  || coupon.length === 0 || typeof coupon === "undefined"){
             return false;
            }
              $.ajax({
                        method: 'GET',
                        url: BASE_URL+"/coupon/apply",
                        data : { 'coupon_code' : coupon },
                        success: function(response){
                            
                            if(response.status){
                                $('.discount-container').append(response.html);
                                $('input[name="total_amount"]').val(response.data.after_discount)
                                IS_APPLIED = true;
                                COUPON = coupon;

                                that.hide();
                                $('#remove-coupon').show();
                            }else{
                                $.alert(response.messages);
                            }
                        }
                    });
            
        });

        $(document).on('click','#remove-coupon',function(){

            $('#coupon').val('');
            var that = $(this);
             $.ajax({
                        method: 'GET',
                        url: BASE_URL+"/coupon/remove",
                        data : { },
                        success: function(response){
                            
                            if(response.status){
                                // $('.discount-container').append(response.html);
                                $('input[name="total_amount"]').val(response.data.total);
                                 IS_APPLIED = false;
                                 that.hide();
                                 $('#apply-coupon').show();
                                 $( ".discount-container .dynamic" ).remove();
                            }
                        }
                    });
        });
        // document end
    })
</script>
@endsection