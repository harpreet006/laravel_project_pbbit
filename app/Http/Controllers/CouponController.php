<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Coupon;
use Cart;
use DB;

class CouponController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id','desc')->get();
        return view('admin.pages.coupons.index',compact('coupons'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
    	$courses = DB::table('courses')->get();

        return view('admin.pages.coupons.add',compact('courses'));
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['_token']);
        
        $validator =  Validator::make($input, [
            'promotion_code' => 'required|string|max:191',
            'type' => 'required|string',
            'value' => 'alpha_num|max:11',
            'apply_on' => 'required',
            'start_date' => 'required',
            'expiry_date' => 'required',
            'number_of_user' => 'required',
            'max_user' => 'required',
        ]);

        if($validator->fails()){
        	
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

        	$input['apply_on'] =  implode(',', $input['apply_on']);
        	Coupon::create($input);

        	$topiscussesscreated= __('messages.Coupon Successfully Created');
            $request->session()->flash('status', $topiscussesscreated);

        	return redirect('admin/coupons');
        }
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::where('id',$id)->delete();
        return redirect()->back();
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $coupon = 	Coupon::findOrFail($id);
    	$courses = DB::table('courses')->pluck('course_name','id');
        return view('admin.pages.coupons.edit',compact('courses','coupon'));
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->except(['_token','_method']);
        
        $validator =  Validator::make($input, [
            'promotion_code' => 'required|string|max:191',
            'type' => 'required|string',
            'value' => 'alpha_num|max:11',
            'apply_on' => 'required',
            'start_date' => 'required',
            'expiry_date' => 'required',
            'number_of_user' => 'required',
            'max_user' => 'required',
        ]);

        if($validator->fails()){
        	
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

        	$input['apply_on'] =  implode(',', $input['apply_on']);
        	Coupon::where('id',$id)->update($input);

        	$topiscussesscreated= __('messages.Coupon Successfully Updated');
            $request->session()->flash('status', $topiscussesscreated);

        	return redirect('admin/coupons');
        }
     }



     public function apply_coupon(Request $request)
     {

        $coupon = new Coupon();
        $html = '';
        $data = [];

        if($this_coupon =  $coupon->isCouponExist($request->coupon_code)){
            if($coupon->isCouponActive()){

                $cart  = Cart::content();
                $total_price = $cart->sum('price');
                if($this_coupon->type == 'percentage'){
                  $data['discount'] = ($this_coupon->value / 100)*$total_price;
                  $data['after_discount'] = $total_price - $data['discount'] ;
                  $title = $this_coupon->value.'%';
                }else{
                    $data['discount'] = $this_coupon->value;
                    $data['after_discount'] = $total_price - $this_coupon->value ;
                    $title = '$'.$this_coupon->value;
                }

                $data['discount'] = (is_float($data['discount'])) ? $data['discount'] :  $data['discount'].'.00';
                $data['after_discount'] = (is_float($data['after_discount'])) ? $data['after_discount'] :  $data['after_discount'].'.00';

                $html = '<div class="col-sm-8 dynamic"><div class="chose_area"><ul class="user_info"><li> Discount <span>'.$title.'</span></li></ul></div></div><div class="col-sm-3 dynamic"><div class="total_area"><ul><li>Discount =<span> $'.($data['discount']).'</span></li></ul></div></div>';
                $html.= '<div class="col-sm-8 dynamic" ><div class="chose_area"><ul class="user_info"><li> Total Amount After Discount <span></span></li></ul></div></div><div class="col-sm-3 dynamic"><div class="total_area"><ul><li>Total =<span> $'.($data['after_discount']).'</span></li></ul></div></div>';

                $request->session()->put('coupon_data',[
                                                        'coupon_id' => $this_coupon->id, 
                                                        'discount' => $data['discount'],
                                                        'after_discount' => $data['after_discount'],
                                                        'type' => $this_coupon->type, 
                                                        'value' => $this_coupon->value, 
                                                    ]);


                return \Response::json(['status'=> 1 , 'messages' => 'success' , 'html' => $html , 'data' => $data]);

            }else{
                
                return \Response::json(['status'=> 0 , 'messages' => 'code has expired']);
            }
        }else{
                return \Response::json(['status'=> 0 , 'messages' => 'not exitst']);
        }
     }


     public function remove_coupon(Request $request)
     {  
        $cart  = Cart::content();
        $total_price = $cart->sum('price');
        $request->session()->put('coupon_data',[]);
        return \Response::json(['status'=> 1 , 'messages' => 'success' , 'data' => ['total' => $total_price ] ]);
     }



}
