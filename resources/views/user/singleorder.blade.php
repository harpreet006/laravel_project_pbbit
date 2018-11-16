@extends('layouts.app-user')

@section('title','dashboard')

@section('right-content')
  <div class="container">
  <h2>My Items</h2>           
  <table class="table">
    <thead>
      <tr>
        <th>S/n</th>
         <th>Course Name</th>
         <th>Price</th>          
         <th>Status</th>
         <th>Created At</th>
         <th>transaction_id</th>
        
      </tr>
    </thead>
    <tbody>
@php 
  $count=1;
  $price=array(); 
@endphp

@foreach($itemsdetails as $items)

    {{--{{$items->order_id}}
    {{$items->item_id}}
    {{$items->price}}
    {{$items->created_at}}
    {{$items->user_id}}
    {{$items->image}}
    {{$items->status}}
    {{$items->transaction_id}}
    {{$items->course_name}}
    {{$items->course_title}}
    {{$items->course_description}}--}}  
      <tr>
        <td>{{$count}}</td> 
        <td><a href="{{url('course/')}}/{{$items->course_name}}"><img  class="items_image" src="{{url('public/uploads/thumnail/')}}/{{$items->image}}">{{$items->course_name}}</a></td>
        <td>{{$items->price}}</td>     
     
          @if($items->status =='complete')<td><span style="color:green" class="label status status-unpaid"><span class="textred">{{$items->status}}</span></span></td> @endif
          @if($items->status =='pending')<td  style="color:blue"><span class="label status status-unpaid"><span class="textred">{{$items->status}}</span></span></td> @endif
          @if($items->status =='cancelled')<td style="color:red"  style="color:red"><span class="label status status-unpaid"><span class="textred">{{$items->status}}</span></span></td> @endif 
          <td>{{$items->created_at}}</td> 
          @php  $price[]=$items->price @endphp
          
        <td orderid=""><span class="label status status-unpaid"><span class="textred"></span></span></td>
      </tr>
     

   
 @php  $count++; @endphp
@endforeach
 
     </tbody>
  </table> 
    <div class="extracharges">
    <div class="listpage_total_amount">Sub {{ __('messages.Total_cart') }}<span> @php echo '$'.array_sum($price); @endphp</span></div>
    @php 
      $subto=array_sum($price);
      $tax=0;
   $remain = ((int)$subto - (int)$tax);
    @endphp
  
    <div class="tex-charg"><label>Tex:</label><span>10</span></div>
    <div class="coupon-charg"><label>Coupon:</label><span>Ztxphjuiop123456</span>
    <div class="coupon-charg"><label>Total Abount:</label><span>{{$remain}}</span>
  
  </div>

</div>



    
    
@endsection
<style type="text/css">
  .items_image{
    width:10%;
  }
  .extracharges {
    float: right;
    border: 1px solid #eee;
    width: 37%;
    padding: 12px;
}
</style>

    
                                                                                        