<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use Response;
use DB;
class ActionController extends Controller
{
  

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request) {
		if ($request->isMethod('post')) {		
				$input = $request->all();	  
		        $getchapter=DB::table('chapters')           
		        ->where('chapters.id',$input['product_id'])->first();      
				 $file = public_path('/uploads/thumnail/'). $getchapter->image;
				 $headers = array('Content-Type' => 'image/jpeg','image/png','video/mp4','application/pdf');
				return Response::download($file,$getchapter->image,$headers);
	}else{
		return redirect('cart');
	}
}

}
