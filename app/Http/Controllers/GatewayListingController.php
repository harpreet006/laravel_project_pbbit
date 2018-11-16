<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\GatewayListing;
use DB;

class GatewayListingController extends Controller
{
    //

      public function index()
    {
    	$gateway_enabled = DB::table('gateway_listing')->where('key', 'name')->get();
		$dir    = dirname(__FILE__);;
		$files = scandir($dir);
		$gateway_array = array();
		$i = 0;
		foreach ($files as $filename){
			if (strpos($filename, 'GatewaysController') !== false){
				$filename_array = explode('GatewaysController',$filename);
				$gateway_array[$i] = $filename_array[0];
				$i++;
			}
		}
    	return view('admin.pages.gateways.index',compact('payments','gateway_array','gateway_enabled'));

    }
	public function changestatus(Request $request)
    {
         $postvar = $request->all();
         $name = $postvar['gateval_name'];
         $status = $postvar['status'];
        if($status == 'activated'){
    		include_once $name.'GatewaysController.php';
    		$class = __NAMESPACE__ . '\\' .$name. 'GatewaysController';
            $gateway_object = new $class();
    		if(method_exists($gateway_object, 'config')){
    		    $gateway_object = $gateway_object->config();
				 DB::table('gateway_listing')->insert([
                             'name' => $gateway_object['Name']['name'],
							 'key' => 'name',
							 'value' => $gateway_object['Name']['name'],
							 'type' => ''
                         ]);
    	    	foreach($gateway_object['InputType'] as $key=>$gateway_value){
							DB::table('gateway_listing')->insert([
								'name' => $gateway_object['Name']['name'],
								'key' => $key,
								'value' => '',
								'type' => strtolower($gateway_value)
							]);
    	    	}
    		}
        }else{
            DB::table('gateway_listing')->where('name', $name)->delete();
        }
		echo "success";
		die;
    }
    	public function get_gateway_configuration(Request $request)
    {
        $postvar = $request->all();
        $name = $postvar['gateway_name'];
       /* $class = __NAMESPACE__ . '\\' .$name. 'GatewaysController';
            $gateway_object = new $class();
    		if(method_exists($gateway_object, 'redirect')){
    		    $gateway_object = $gateway_object->redirect();
    		    print_r($gateway_object);
    		   
    		}
    		 die();*/
    	    $configuration_array = DB::table('gateway_listing')->where('name', $name)->orderBy('id', 'ASC')->get();
    	    $html = '<form action="" method="post" >';
    	    foreach($configuration_array as $configuration_arrayval){
    	        if($configuration_arrayval->key =='name'){
    	            $name = $configuration_arrayval->value;
    	        }else{
    	            if($configuration_arrayval->value == ''){
    	                $input_val = '';
    	            }else{
    	                $input_val = Crypt::decrypt($configuration_arrayval->value);
    	            }
    	             $html .= ' <div class="form-group">
                        <label for="'.strtolower($configuration_arrayval->key).'">'.$configuration_arrayval->key.'</label>
                        <input type="'.strtolower($configuration_arrayval->type).'" value="'.$input_val.'" class="form-control" id="'.$configuration_arrayval->key.'">
                      </div>';
    	            
    	            
    	        }
    	        
    	        
    	    }
    	   
            $html .=  '<div class="form-group"><button id="'.$name.'" onclick="setconfiguration(this)" type="button" class="btn btn-default">Submit</button></div></form>';
		echo $html;
		die;
    }
    	public function save_gateway_configuration(Request $request){
         $postvar = $request->all();
         $formdata = $postvar['formdata'];
         $name = $postvar['gatewayname'][0];
          DB::table('gateway_listing')->where('name', $name)->delete();
          DB::table('gateway_listing')->insert([
                             'name' => $name,
							 'key' => 'name',
							 'value' => $name,
							 'type' => ''
                         ]);
    	    foreach($formdata as $formvalue){
                if($formvalue['key']!="Order"){
                    $input_val = Crypt::encrypt($formvalue['value']);
                }else{
                    $input_val = $formvalue['value'];
                }    	   
    	        $key = $formvalue['key'];
    	     	DB::table('gateway_listing')->insert([
								'name' => $name,
								'key' => $key,
								'value' => $input_val,
								'type' => $formvalue['type']
							]);
    	        
    	    }
    	   echo "success";
		die;
    }

}
