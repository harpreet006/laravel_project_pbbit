 @extends('layouts.app')

 @section('title','home')

@section('style')

@endsection

 @section('content')      
        <!-- checkout_section">  -->
        <div class="checkout_section">
            <div class="container">
                <div class="row">             
     
      <div class="table-responsive">
            <table cellpadding="1" cellspacing="1" class="table table-hover" id="tabla">
          <thead>
            <tr>
              <th>S/n</th>
              <th>Item Name</th>
              <th>Status</th>
              <th>Invoice</th>
              <th>Amount</th>
              <th>Shipping</th>
              <th>Quantity</th>
            </tr>
          </thead>
          <tbody id="myTable">
            @php  $count=1; @endphp
             @foreach($order as $item) 
              <tr>
              <td>{{$count}}</td>
              <td>{{$item->item_name}}</td>
              <td>{{$item->status}}</td>
              <td>{{$item->invoice}}</td>
              <td>{{$item->amount}}</td>
              <td>{{$item->shipping}}</td>
              <td>{{$item->quantity}}</td>
            </tr>
              @php $count++;  @endphp
             @endforeach
           
   
          </tbody>
        </table>   
      </div>
      <div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
      </div>
      <div class="col-md-12 center text-center">
        <span class="left" id="total_reg"></span>
            <ul class="pagination pager" id="myPager"></ul>
          </div>                           
                
                <div></div></div>
            </div>
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
    <script type="text/javascript">

    </script>
    @endsection