<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper;
use App\Orders;
use App\Users;
use DB;

class NotificationController extends Controller
{

     //
    public function index()
    {
        # code...
        $users =  Helper::getAllUsers(); 
        DB::table('notifications')->where('read_status',false)->update(['read_status'=>true]);
        return view('admin.pages.notifications.index',compact('users'));
    }
    
     public function get_unread_orders(Request $request)
    {
        $postvar = $request->all();
        $orders_count = DB::table('orders')->where('read_status', 0)->count();
        $orders_lists = DB::table('orders')->join('users', 'users.id', '=', 'orders.user_id')->where('read_status', 0)
		->select('orders.*', 'users.id as userid','users.first_name as username','users.last_name as user_lastname','users.name as uname','users.last_name as user_lastname','users.avtar as userimage')
		->get();
        return response()->json([ 
                                  'orders_count'=>$orders_count, 
                                  'orders_lists' => $orders_lists
                              ]);
    }
    
    public function get_notifications(Request $request)
    {
        $postvar = $request->all();
        $notifications_count = DB::table('notifications')->where('read_status', 0)->count();
        $notifications_lists = DB::table('notifications')->join('users', 'users.id', '=', 'notifications.user_id')->where('read_status', 0)
		->select('notifications.*', 'users.id as userid','users.first_name as username','users.last_name as user_lastname','users.name as uname','users.last_name as user_lastname','users.avtar as userimage')
		->get();
        return response()->json([ 
                                  'notifications_count'=>$notifications_count, 
                                  'notifications_lists' => $notifications_lists
                              ]);
    }
}