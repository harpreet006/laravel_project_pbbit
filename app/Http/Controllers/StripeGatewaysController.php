<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\GatewayListing;
use DB;
class StripeGatewaysController extends Controller
{
  function config()
  {
    return array(
      'Name' => array(
            'name' => 'Stripe',
        ),
        // a text field type allows for single line text input
        'InputType' => array(
            'email' => 'email',
            'pass' => 'password',
            'Apikey' => 'password',
            'Order' => 'text',
        )
     );
  }




  function redirect($totalamount)
  {
       $totalamountre=$totalamount*100;

       $gateway_details = DB::table('gateway_listing')->where('name', 'Stripe')->where('key', 'Apikey')->orderBy('id', 'ASC')->get();
       $formhtml = '<form action="'.action('CartfController@paymentstripe').'" method="POST">
          <script
          src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="pk_test_gQUdiOa7bdFry37lqcfXX5Q5"
          data-amount='.$totalamountre.',
          currency = "usd",
          data-name="Power BIT"
          data-description="Demo"
          data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
          data-locale="auto">
          </script>
          <input type="hidden" name="amount" value='.$totalamount.' readonly>      
          </form>';
        return $formhtml;
  }
  
}
?>

