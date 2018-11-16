 @extends('layouts.app')

 @section('title','home')

@section('style')

@endsection

 @section('content')
 <div class="outer_area padding_60">
	<div class="container">
		<div class="order_successfully_completed">
             
			<img class="success_image" src="{{asset('public/frontview/images/success_image.png')}}" alt="img">
			<h3>Thank you for your purchase!</h3>
			<h3> your order number is:<a href="#"> 123456789123654</a></h3>
		</div>
	</div>
 </div>

    <div class="container">       
     @include('components.customcode')
    </div>
    @endsection

    @section('script')
    <script type="text/javascript">
     

    </script>
    @endsection



                                  