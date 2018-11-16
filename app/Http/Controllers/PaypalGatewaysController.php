<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\GatewayListing;
use DB;
class PaypalGatewaysController extends Controller
{
	function config()
	{
		return array(
			'Name' => array(
            'name' => 'Paypal',
        ),
        // a text field type allows for single line text input
        'InputType' => array(
            'Email' => 'email',
            'Pass' => 'password',
        )
     );
	}



	function redirect($totalamount)
	{
	    $gateway_details = DB::table('gateway_listing')->where('name', 'Paypal')->orderBy('id', 'ASC')->get();
		$formhtml = '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="accounts@freelanceswitch.com">			
		<input type="hidden" name="item_number" value="1">
		<input type="hidden" name="amount" value="'.$totalamount.'">
		<input type="hidden" name="no_shipping" value="0">
		<input type="hidden" name="no_note" value="1">
		<input type="hidden" name="currency_code" value="USD">  
		<input type="hidden" name="return" value="'.url("/payment/success").'">
		<input type="hidden" name="cancel_return" value="'.url("/payment/cancel").'"> 
		<input type="hidden" name="notify_url" value="'.url("/payment/notify").'">
		<input type="submit" class="payment-btns" value="complete payment" name="finalizeOrder" id="finalizeOrder" class="submitButton">
		<img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
		</form>'; 
		return $formhtml;
	}

	public function paymentsuccess(Request $request){


	}

	public function paymentcancel(Request $request){


	}
	
	public function paymentnotify(Request $request){


	}

}


 


?>