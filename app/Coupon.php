<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

	protected $coupon;


    protected $fillable = [
         'promotion_code', 'type','value','apply_on','start_date','expiry_date','number_of_user','max_user','note','apply_once'
    ];




    public function isCouponExist($coupon)
    {
    	$current_time =  date('Y-m-d');
    	return $this->coupon = $this->where([
    		                                ['promotion_code', '='  , $coupon],
    		                             ])
    	                              ->where('start_date','<=', $current_time)
                                      ->where('expiry_date', '>=', $current_time)
    	->first();
    }

    public function isCouponActive()
    {
    	if(!$this->coupon){
    		return false;
    	}else{
    	   return ($this->coupon->max_user > $this->coupon->applied_coupons);
    	}
    }


}
