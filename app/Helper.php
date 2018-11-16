<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;
use Cart;
use DB;

class Helper extends Model
{
    //

    public static function getAllUsers(){
    	return User::select('id','name')->where([
    		['status','=','active'],
    		['user_type','!=','admin'],
    	])->get();
    }


     public static function get_header()
    {
        $coursesData = DB::table('courses')->get();
    	$topics = array();
    	foreach($coursesData as $key => $course){
			//$topicsData = DB::select('select * from topics where course_id = :course_id', ['course_id' => $course->id]);
            $topicsData = DB::table('topics')->where('course_id', $course->id)->get(); 
			$topics[$key]['id'] = $course->id;
			$topics[$key]['name'] = $course->course_name;
			$topics[$key]['topics'][] = $topicsData;
		}

        $user = DB::table('users')->get();
        return $topics;
    }


    public static function get_topic(){
    
        return  DB::table('topics')->where([
    	                                     ['publish','=' , true]
    	                                    ])
                                    ->inRandomOrder()
                                    ->limit(16)
                                    ->get()
                                    ->toArray();
    }


    public static function get_usertopic(){
    	$id = Auth::user()->id;
    	return $userData = DB::table('topics')->where('user_id', $id)->paginate(10);
    	//return $userData = $userData->toArray();
     }
 
    public static function get_testimonial(){
		$testimonialData = DB::table('user_testimonial')
            ->join('users', 'users.id', '=', 'user_testimonial.user_id')
            ->select('users.first_name', 'users.last_name','users.avtar','user_testimonial.text', 'user_testimonial.rating')
            ->get();
    	return $testimonialData;
	}


    public static function get_cart_number()
    {
        $cart = Cart::content();
        return  count($cart);
    }

}
