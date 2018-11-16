<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\GatewayListing;
use Stripe\Stripe;
use Stripe\Charge;
use App\Order;
use App\Item;
use Session;
use Helper; // Important
use Auth;
use Cart;
use DB;
class CartfController extends Controller
{ 
	//add to cart add by jasvir
	public function cartadd(Request $request) {
		$input = $request->all();		
		if(!empty($input['product_id'])){
			$tiems= Cart::content();
			foreach ($tiems as $key => $value) { 
			          if($input['product_id']==$value->id){          
                      		Cart::remove($value->rowId);
                  	   }
            }
			$product_id=$input['product_id'];
			$product = DB::table('courses')->where('id', $product_id)->first();
			Cart::add(array('id' => $product_id, 'name' => $product->course_name, 'qty' => 1, 'price' => $product->actual_price,'options' => ['image' => $product->image]));
		} 		
		$cart = Cart::content();	
		//$gatewaylisting=GatewayListing::groupBy('name')->get();		
		$gatewaylisting=GatewayListing::groupBy('name')->selectRaw('count(*) as total, name')->get();		 
		return view('cart', array('cart' => $cart, 'gatewaylisting'=>$gatewaylisting, 'title' => 'Welcome', 'description' => '', 'page' => 'home','class'=>'courses','type'=>"innerpage"));		
	}



		//add to cart add by jasvir
	public function packagcart(Request $request) { 
		$input = $request->all();	
		$tiems= Cart::content();
			foreach ($tiems as $key => $value) {                     
                      Cart::remove($value->rowId);
            }	
		if(!empty($input)){			
			$product_id=explode(',',$input['product_id']);	
		 	foreach ($product_id as $key => $value) {
				$product = DB::table('courses')->where('id', $value)->first();
					Cart::add([
						'id'       => $product->id,
						'name'     => $product->course_name,
						'qty' => 1,
						'price'    => $product->actual_price,
						'options' => ['image' => $product->image]
						]);		
				# code...
			}	 
			//die;		
		} 
		return redirect('cart');
	}


	//cart remove by jasvir
	public function cartremove(Request $request){
		$input = $request->all();	
		if($input){	
	    	 $items = session('cart');
	    	 $data = Session::all();
	    	 foreach ($data as $key => $valuedata) {    	 	 
	    	 	if($key=='cart'){
	    	 		foreach($valuedata['default'] as $defaultval){    	 			 
	    	 			if($input['product_id']==$defaultval->id){    	 				 
	    	 				Cart::remove($defaultval->rowId);
	    	 				return redirect('cart');
	    	 			}//if end
	    	 		}// foreach
	    	 	} //if end   	 
	    	 }//foreach
	    	}else{
	    		return redirect('cart');
	    	}
	}//cartremove

	public function cartincrease(Request $request){				
				$input = $request->all();		
				$cart = Session::get('cart');			
				foreach ($cart as $key => $cartvalue) {
					foreach($cartvalue as $cartincre){ 					 	 			
					 if($input['product_id']==$cartincre->id){
						$rowId= $cartincre->rowId;						
						Cart::update(
							$rowId, [
							'qty' => $cartincre->qty+1						
						]);
						return redirect('cart');
					}//end if				
				}//foreach
			}//foreach
	}//cartincrease 
	public function cartdecrease(Request $request){			
				$input = $request->all();		
				$cart = Session::get('cart');			
				foreach ($cart as $key => $cartvalue) {
					foreach($cartvalue as $cartincre){ 					 	 			
					 if($input['product_id']==$cartincre->id){
						$rowId= $cartincre->rowId;						
						Cart::update(
							$rowId, [
							'qty' => $cartincre->qty-1						
						]);
						return redirect('cart');

					}//end if				
				}//foreach
			}//foreach
	}//cartincrease 

	public function cartcheckout(Request $request){		
		$input = $request->all();
		//print_r($input);
		if(!empty($input['radio1'])){ $paymentmethod=$input['radio1']; 				
		if(!empty($input['total_amount'])){ $totalamount=$input['total_amount'];}			
		$cart = Cart::content();
		//print_r($cart)	;
		$arrayname= array();
		foreach ($cart as $key => $value) {		   
			$arrayname[]= $value->id.',';
			# code...
		}
		//print_r($arrayname);
        $ary=implode('', $arrayname);
        $product_name=rtrim($ary,',');
		if(empty(count($cart))){return redirect('course');}		
		include_once $paymentmethod.'GatewaysController.php';
		$class = __NAMESPACE__ . '\\' .$paymentmethod. 'GatewaysController';
        $gateway_object = new $class();                
        $totalamount=str_replace(",", "", $totalamount);
        session(['product_name' => $product_name]);
		return view('checkout', array('cart' => $cart,'paymentmethod'=>$gateway_object->redirect($totalamount),  'title' => 'Welcome', 'description' => '', 'page' => 'home','class'=>'checkout','type'=>"innerpage"));
		}else{
			session(['product_name' => '']);
			  return redirect('/cart');
		}
	}

	public function frompaypal(Request $request){
		$input = $request->all();	
		if(empty(Auth::id())){
            return redirect('/');
		}
		
		if ($request->all()) {		
		 	$data = Order::create([
	                'user_id' => Auth::id(),
	                'transaction_id' => $input['txn_id'],
	                'first_name' => $input['first_name'],
	                'last_name' => $input['last_name'],
	                'payer_email' => $input['payer_email'],
	                'amount' => $input['payment_gross'],               
	                'status' => $input['payment_status'],                
	                'item_name' => $input['item_name'],
	                'quantity' => '',
	            ]);
		 	Item::create([
	                'order_id' => $data->id,
	                'item_id' => $data->id,               
	                'quantity' => 1,
	                'price' => $data->amount,               
	            ]);

		 		DB::table('orders')
						->where('id', $data->id);
				Cart::destroy();
					return view('paymentsuccess', array('order' => '',  'title' => 'Order', 'description' => '', 'page' => 'pagesuccesss','class'=>'success','type'=>"innerpage")); 
		}else{
			return redirect('cart');
		}   
/*	$courselist =Order::where([
                    ['user_id','=',Auth::id()]                  
                 ])->get(); */

	// Cart::destroy();

	}

	public function cancel(Request $request){

     	$cartcontain = count(Cart::content());
        if($cartcontain){
     		Cart::destroy();
     		return view('paymentcancel', array('order' => '',  'title' => 'Order', 'description' => '', 'page' => 'cancel','class'=>'order','type'=>"innerpage"));

     	}else{
     		 return redirect('cart');
     	} 

	}

		/*public function paymenttype(Request $request){
  
			if ($request->ajax()) {
				//echo 'Ajax';
			}else{
				return response()->json(['status'=>0 , 'message'=> 'permission not granted']);
			}
		}*/


		public function paymentstripe(Request $request)
		{
				# code...
				Stripe::setApiKey(config('services.stripe.secret'));
				$input = $request->all();	
				/*print_r($input['amount']);
				print_r($input['product_name']);*/
		        $token = request('stripeToken');
		        $cartcontain = count(Cart::content());

		        if( $cartcontain ){	

		        	if($token){
			        	$charge = Charge::create([
			            'amount' => (int)$input['amount'],
			            'currency' => 'usd',
			            'description' => 'HELLO',
			            'source' => $token,
			            ]);

				      	$data=Order::create([
			                'user_id' => Auth::id(),
			                'payment_getway' => 'stripe',
			                'token' => '',
			                'amount' => $charge['amount'], 
			                'transaction_id' => $charge['balance_transaction'],
			                'status' => $charge['status'],                        
			                'read_status' => $charge['description'],
			                'note' => '',
			                 
			            ]);
			            $product_ids = Session::get('product_name');
			            $productids=explode(',', $product_ids);
			            foreach ($productids as $key => $Item_id) {			            	
				            	Item::create([
								'order_id' => $data->id,
								'item_id' => $Item_id,               
								'quantity' => 1,
								'price' => $data->amount,               
							]);	
			            	# code...
			            }									

						DB::table('orders')
						->where('id', $data->id)
						->update(['status' => 'complete']);
						Cart::destroy();
						session(['product_name' => '']);
			        }
			         //
			     	//return 'Payment Success!';
		        return view('paymentsuccess', array('orderid' => $data->id,  'title' => 'Order', 'description' => '', 'page' => 'order','class'=>'order','type'=>"innerpage")); 
		    }else{
		    	return redirect('cart');
		    }

		}

}