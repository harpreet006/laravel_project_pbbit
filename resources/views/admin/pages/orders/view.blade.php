@extends('admin.layouts.main')

@section('style')
    <link rel="stylesheet" href="{{ asset('public/vendor/jquery-ui/jquery-ui.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/jquery-ui/jquery-ui.theme.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/bootstrap-multiselect/bootstrap-multiselect.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/morris/morris.css')}}" />
  <link rel="stylesheet" href="{{ asset('public/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}" />
   <style type="text/css">
        .invalid-feedback{
            display: block !important;
        }
        .simple-todo-list li{
          padding: 0px !important;
        }
    </style>
@endsection

@section('content')
<section role="main" class="content-body">
          <header class="page-header">
            <h2>Order #{{$order->id}} detail</h2>
          
            <div class="right-wrapper text-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="{{url('/admin/dashboard')}}">
                    <i class="fa fa-home"></i>
                  </a>
                </li>
                <li><span>Pages</span></li>
                <li><span>Order #{{$order->id}} detail</span></li>
              </ol>
          
              <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>

          <!-- start: page -->
           <?php 
            $img = 'logged-user.jpg';
            ?>


          <div class="row">
            <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
              <section class="card">
                <div class="card-body">
                  <div class="thumb-info mb-3">
                    <img src="{{url('public/images/'.$img)}}" class="rounded img-fluid" alt="John Doe">
                    <div class="thumb-info-title">
                      <span class="thumb-info-inner">Order #{{$order->id}}</span>
                    </div>
                  </div>

                  <?php 
                        if($order->status == 'pending'){
                          $status = 'warning'; 
                        }elseif($order->status == 'canceled'){
                          $status = 'danger'; 
                        }elseif ($order->status == 'complete') {
                          $status = 'success'; 
                        }else{
                          $status = 'danger';
                        }
                       ?>

                  <div class="widget-toggle-expand mb-3">
                    <div class="widget-header">
                      <h5 class="mb-2">General</h5>
                      <hr class="dotted short">
                      <div class="widget-content-expanded">
                        <ul class="simple-todo-list mt-3">
                          <li>Created On : {{date('d-m-Y',strtotime($order->created_at))}}</li>
                          <li>Order Status: <label class="label label-{{$status}}"> {{$order->status}} </label></li>
                          <li>Customer: <a href="{{url('admin/users').'/'.$order->user_id}}"> view customer profile --></a></li>
                          <li>Customer email: {{$order->user->email}}</li>
                        </ul>
                      </div>
                  </div>

                  <hr class="dotted short">

                  <h5 class="mb-2 mt-3">Admin Note</h5>
                  <p class="text-2">{{$order->note}}</p>
                </div>
              </section>
            </div>

            <div class="col-lg-8">
              <div class="tabs">

                <ul class="nav nav-tabs tabs-primary">
                  <li class="nav-item active">
                    <a class="nav-link" href="#items" data-toggle="tab">Items</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#edit" data-toggle="tab">Update Order Starts</a>
                  </li>
                </ul>

                <div class="tab-content">

                  <div id="items" class="tab-pane active">
                    <!-- end form -->
                    <table class="table">
                      <thead>
                        <th>Item#id</th>
                        <th>Item Name</th>
                        <th>Amount</th>
                        <th>Qty</th>
                        <th>total</th>
                      </thead>
                      <tbody>
                        <?php  $total = []; ?>
                        @foreach($order->items as $item)
                        <tr>
                          <td>Item#{{$item->id}}</td>
                          <td>{{@$item->course->course_name}} </td>
                          <td>${{$item->price}}</td>
                          <td>{{$item->quantity}}</td>
                          <td>${{ ($item->price.' * '.$item->quantity)}}  = ${{ ($item->quantity*$item->price)}}</td>
                        </tr>
                        <?php $total[]= ($item->quantity*$item->price); ?>
                        @endforeach
                      </tbody>
                    </table>
                      <hr class="dotted">

                      <table class="wc-order-totals" style="position: relative;left: 350px;">
                        <tbody>
                          <tr>
                          <td > <b>- Tex:</b></td>
                          <td width="1%"></td>
                          <td class="total">
                            <span class="woocommerce-Price-currencySymbol">0.00</span>
                          </td>
                        </tr>

                          <tr>
                          <td > <b>- Discount:</b></td>
                          <td width="1%"></td>
                          <td class="total">
                            <span class="woocommerce-Price-currencySymbol">$0.00</span>
                          </td>
                        </tr>

                         <tr>
                          <td > <b>- Totel Items:</b></td>
                          <td width="1%"></td>
                          <td class="total">
                            <span class="woocommerce-Price-currencySymbol">{{count($total)}}</span>
                          </td>
                        </tr>
                        <tr style="border-top: 1px solid;">
                          <td><b>- Total:</b></td>
                          <td width="1%"></td>
                          <td class="total">
                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>{{array_sum($total)}}.00</span>     </td>
                        </tr>    
                        </tbody>
                      </table>
                      <div>
                           <a class="btn btn-primary" href="{{url('admin/orders/invoice/'.$order->id)}}" > Download PDF </a>

                      </div>
                  </div>

                   <div id="edit" class="tab-pane">
                    <form class="p-3" method="POST" action="{{ action('OrderController@update',['id'=>$order->id]) }}" aria-label="{{ __('Register') }}" enctype="multipart/form-data">
                      <h4 class="mb-3">Edit Order</h4>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputPassword4">Order Status</label>
                          <?php $ststus_options = [
                          'pending' => 'Pending',
                          'complete' => 'complete',
                          'canceled' => 'canceled',
                          ] ;
                          ?>

                           {!! Form::select('status', $ststus_options, $order->status, ['class' => 'form-control']) !!}

                          @if ($errors->has('status'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('status') }}</strong>
                              </span>
                          @endif
                        </div>
                       
                      </div>

                      <div class="form-group">
                        <label for="inputPassword4">Add Note</label>
                        <textarea class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" placeholder="Add Note to this order"name="note" >{{$order->note}}</textarea>
                        @if ($errors->has('note'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('note') }}</strong>
                            </span>
                        @endif
                      </div>
                      
                      <div class="form-row">
                        <div class="col-md-12 text-right mt-3">
                          <input type="submit" value="Update" class="btn btn-primary modal-confirm">
                        </div>
                      </div>
                       @method('PUT')
                       @csrf
                    </form>
                   </div>
                </div>
              </div>
            </div>

          </div>
          <!-- end: page -->
        </section>
@endsection

@section('script')
 <!-- Specific Page Vendor -->
 <script src="{{ asset('public/vendor/autosize/autosize.js')}}"></script>
        <script src="{{ asset('public/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
        <script type="text/javascript">
               
  var active_link = 0;
  active_nav_links(9,active_link);
  
        </script>
@endsection