<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
</head>
<body>

                    <!-- end form -->
                    <table border="1">
                      <thead>
                      	<tr>
	                        <th>Item#id</th>
	                        <th>Item Name</th>
	                        <th>Amount</th>
	                        <th>Qty</th>
	                        <th>total</th>
	                      </tr>
                      </thead>
                      <tbody>
                        <?php  $total = []; ?>
                        @foreach($order->items as $item)
                        <tr>
                          <td>Item#{{$item->id}}</td>
                          <td>{{$item->course->course_name}} </td>
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
              

</body>
</html>