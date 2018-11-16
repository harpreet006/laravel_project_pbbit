<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Helper;
use App\Order;
use Response;
use App\User;
use Auth;
use URL;
use DB;

class DashboardController extends Controller
{
    public function index()
    {	
		$usersData = array();
		if(empty(Auth::user()->id)){
			return redirect('/');
		}
		$id = Auth::user()->id;	
		$orderitems = DB::table('orders')->where('user_id',Auth::user()->id)->count();		
		$chapterId = array();
		$usersData = DB::table('orders')
            ->join('items', 'items.order_id', '=', 'orders.id')
			->join('courses', 'courses.id', '=', 'items.item_id')
            ->select('courses.*')
			->where([['orders.user_id', $id],['orders.status','complete']])	
			->orderBy('courses.id','asc')
            ->get();

			$UserChapterData = array();
			foreach($usersData as $key => $data){
				$chapterId[] = $data->id;
			}
        	
			$UserChapterData = DB::table('chapters')->whereIn('course_id', $chapterId)->paginate(2);
			foreach($UserChapterData as $chapters){
				$topics = DB::table('topics')->where([['chapter_id', '=', $chapters->id]])->get();
				$totalTopics = count($topics);
				$chapters->totalTopics = $totalTopics;
				$courserating = DB::table('courses')
						->leftjoin('topics', 'topics.course_id', '=','courses.id')
						->leftjoin('user_testimonial', 'topics.id', '=','user_testimonial.item_id')
						->where([['topics.user_id', Auth::user()->id],['topics.chapter_id', $chapters->id]])
						->get();
				 $count = count($courserating);
				if ($count) {         
					$max=0;
					foreach ($courserating as $key => $ratingvalue) {        		 
						 $max = $max+$ratingvalue->rating;  
										
					}
					$average= ceil($max / $count);
				}else{
					$average="";
				}
				
				$chapters->rating = $average;
				
			}
			
       return view('user.dashboard',['userData' => $usersData,'UserChapterData' => $UserChapterData,"exist"=> $orderitems,'average'=>$average ]);

    }
    public function myorderlist(Request $request){
    	if(empty(Auth::user()->id)){
			return redirect('/');
		}	
		$id = Auth::user()->id;	
		$usersData = DB::table('orders')
            ->join('items', 'items.order_id', '=', 'orders.id')
			->join('courses', 'courses.id', '=', 'items.item_id')
            ->select('courses.*')
			->where([['orders.user_id', $id],['orders.status','complete']])	
			->orderBy('courses.id','asc')
            ->get();
			$userArray = DB::table('orders')->where('user_id', Auth::user()->id)->get();					 
        	return view('user.myorders',['userData' => $usersData,'orderliist'=>$userArray]);

    }

    public function sigleorderlist(Request $request,$oderid){
    	if(empty(Auth::user()->id)){
			return redirect('/');
		}  
	$id = Auth::user()->id;	
		$usersData = DB::table('orders')
            ->join('items', 'items.order_id', '=', 'orders.id')
			->join('courses', 'courses.id', '=', 'items.item_id')
            ->select('courses.*')
			->where([['orders.user_id', $id],['orders.status','complete']])	
			->orderBy('courses.id','asc')
            ->get();		
    	$itemsdetails = DB::table('items')->join('orders', 'order_id', '=', 'orders.id')->join('courses', 'courses.id', '=', 'items.item_id')->where('orders.id', $oderid)->where('orders.user_id', Auth::user()->id)->get();    	
    	if(count($itemsdetails)>0){    		
			return view('user.singleorder',['userData' => $usersData,'itemsdetails'=>$itemsdetails]);	
    	}else{    		 
    		return redirect('user-dashboard');	
    	}
    			
    }


    

	public function ratingondashboard(Request $request){
				 	if(empty(Auth::user()->id)){
						return redirect('/');
					}
		    $input = $request->all();		    
		  $count= DB::table('user_testimonial')->where([['user_id', Auth::user()->id],['item_id',$input['productid']]])->count();	
			if($count>0){
				DB::table('user_testimonial')
		            ->where([['user_id', Auth::user()->id],['item_id',$input['productid']]])		                        
		            ->update(['rating' => $input['rating']]);		     
			}else{
				DB::table('user_testimonial')->insert(['text' => '', 'user_id' => Auth::user()->id,'item_id'=>$input['productid'],'rating'=>$input['rating']]);
			}
	}
	
	public function search(Request $request)  
	{
		if ($request->ajax()) {
			$html = "";
			$input = $request->all();
			$data  = $input['search'];
			$searchData1 = DB::table('topics')->where('title','LIKE',"%$data%")->orderBy('id','desc')->take(15)->get();
			$searchData2 = DB::table('courses')->select('id','course_name as title')->where('course_name','LIKE',"%$data%")->orderBy('id','desc')->take(3)->get();
			$searchData1 = $searchData1->toArray();
			$searchData2 = $searchData2->toArray();
			$result = array_merge($searchData1,$searchData2);
			
				if(!empty($result)){
					return json_encode($result);
				}else{
					return '[{"title":"Record not Found" }]';
				}
		}else{
			return response()->json(['status'=>0 , 'message'=> 'permission not granted']);
		}
	}
	
	public function userSearch(Request $request)  
	{
		
		if ($request->ajax()) {
			$html = "";
			$courseId = array();
			$input = $request->all();
		    $searchdata  = $input['search'];
			$id = Auth::user()->id;
			$usersData = DB::table('orders')
            ->join('items', 'items.order_id', '=', 'orders.id')
			->join('courses', 'courses.id', '=', 'items.item_id')
            ->select('courses.*')
			->where([['orders.user_id', $id],['orders.status','Complete']])	
			->orderBy('courses.id','asc')
            ->get();
			$result1 = array();
			$result2 = array();
			if ( count($usersData) > 0 ) {
				foreach($usersData as $key => $data){
					$courseId[] = $data->id;
				}
				$UserChapterData = DB::table('chapters')->where('title','LIKE',"%$searchdata%")->orderBy('id','desc')->take(15)->get();	
				if ( count($UserChapterData) > 0 ){
					foreach($UserChapterData as $chapter){
						if(in_array( $chapter->course_id,$courseId)){
							$result1[] = $chapter;
						}
					}
				}
				$UserTopicData = DB::table('topics')->where('title','LIKE',"%{$searchdata}%")->orderBy('id','desc')->take(15)->get();	
				if ( count($UserTopicData) > 0 ){
					foreach($UserTopicData as $topic){
						if(in_array( $topic->course_id,$courseId)){
							$result2[] = $topic;
						}
					}
				}
				if( (count($result1) > '0') && (count($result2) > '0')){
					$result = array_merge($result1,$result2);
					return json_encode($result);
				}elseif((count($result1) > 0) && (count($result2) <= 0)){
					$result = $result1;
					return json_encode($result);
					
				}elseif((count($result1) <= 0) && (count($result2) > 0)){
					$result = $result2;
					return json_encode($result);
					
				}else{
					return '[{"title":"Record not Found" }]';
				}
			}else{
				return '[{"title":"Record not Found" }]';
			}
			
		}else{
			return response()->json(['status'=>0 , 'message'=> 'permission not granted']);
		}
	}
	
	public function profile(){
		if(empty(Auth::user()->id)){
			return redirect('/');
		}		 
		$id = Auth::user()->id;
		$userArray = DB::table('users')->where('id', $id)->get();
		$userprofileData = $userArray->toArray();
		$usersData = DB::table('orders')
            ->join('items', 'items.order_id', '=', 'orders.id')
			->join('courses', 'courses.id', '=', 'items.item_id')
            ->select('courses.*')
			->where([['orders.user_id', $id],['orders.status','Complete']])	
            ->get();
		 return view('user.user-profile',['userData' => $usersData,'profiledata' =>$userprofileData]);
	}
	public function updateProfile(Request $request){
		if(empty(Auth::user()->id)){
			return redirect('/');
		}
		$id = Auth::user()->id;
		$input = $request->all();
        $validator =  Validator::make($input, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'userimg' => 'image|mimes:jpeg,jpg,png|max:10000',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();

        }else{
             $file_name = $input['old_image'];
             if($request->hasFile('userimg') && $request->file('userimg')->isValid()){
                $file = $request->file('userimg');
                $file_name = $id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                $file->move(base_path() . '/public/images/avatar', $file_name);
            }
            User::where('id',$id)->update([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'name' => $input['first_name'].' '. $input['last_name'],
                'avtar' => $file_name,
            ]);

            $usersuccessmsg= trans('messages.user_successfully_updated');
            $request->session()->flash('status', $usersuccessmsg);

            return redirect('/user-dashboard');

        }	
	}
	
	public function changePassword(){

		if(empty(Auth::user()->id)){
			return redirect('/');
		}	
		$id = Auth::user()->id;
		$userArray = DB::table('users')->where('id', $id)->get();
		$userprofileData = $userArray->toArray();
		$usersData = DB::table('orders')
            ->join('items', 'items.order_id', '=', 'orders.id')
			->join('courses', 'courses.id', '=', 'items.item_id')
            ->select('courses.*')
			->where([['orders.user_id', $id],['orders.status','Complete']])	
            ->get();
		return view('user.change-password',['userData' => $usersData,'profiledata' =>$userprofileData]);

		
	}
	public function updatePassword(Request $request){
		if(empty(Auth::user()->id)){
			return redirect('/');
		}
		$id = Auth::user()->id;
		$input = $request->all();
		  $validator = Validator::make($input, [
            'old_password' => array(
                          'required',
                          'min:6',
                          'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                         ),
			'password_confirmation' => array(
                          'required',
                          'min:6',
                          'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                         ),			 
            'password' => array(
                          'required',
						  'confirmed',
                          'min:6',
                          'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                         ),
						 
            //'password' => 'required|string|min:6|confirmed',
        ]);
		 if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
			
			$userArray = DB::table('users')->where([['id', '=', $id]])->get();
			$userp = $userArray->toArray();
			$user_pass = $userArray[0]->password;
			if (Hash::check($input['old_password'], $user_pass)) {
   				User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($input['password']),
            ]);
            
            $passwordchangedmsg = trans('messages.password_changed_msg');
            $request->session()->flash('status', $passwordchangedmsg);

            return redirect()->back();
			}else{
				$passwordmsg = trans('messages.incorrect_password');
				$request->session()->flash('status', $passwordmsg);
				return redirect()->back();
			} 	 
        }
	}	
	public function playVideo(){
		if(empty(Auth::user()->id)){
			return redirect('/');
		}
		$id = Auth::user()->id;
		$usersData = DB::table('orders')
				->join('items', 'items.order_id', '=', 'orders.id')
				->join('courses', 'courses.id', '=', 'items.item_id')
				->select('courses.*')
				->where([['orders.user_id', $id],['orders.status','Complete']])	
				->get();
		
		foreach($usersData as $key => $data){
				$UserChapter = DB::table('chapters')->where([['course_id', '=', $data->id]])->get();
		}		
		return view('user.play-video',['userData' => $userData,'chapterData' => $UserChapter ]);
	}
	public function showChapters($id){

		if(empty(Auth::user()->id)){
			return redirect('/');
		}
		$paymentvarify = DB::table('orders')->where('user_id',Auth::user()->id)->count();
		if($paymentvarify){
		$usersData = array();
		$userid = Auth::user()->id;	
		$chapterId = $id;
		$usersData = DB::table('orders')
            ->join('items', 'items.order_id', '=', 'orders.id')
			->join('courses', 'courses.id', '=', 'items.item_id')
            ->select('courses.*')
			->where([['orders.user_id', $userid],['orders.status','Complete']])	
            ->get();
			$UserChapterData = DB::table('chapters')->where('course_id','=' ,$chapterId)->paginate(2);
			foreach($UserChapterData as $chapters){
				$topics = DB::table('topics')->where([['chapter_id', '=', $chapters->id]])->get();
				$totalTopics = count($topics);
				$chapters->totalTopics = $totalTopics;
			}	

			//$chapterIdd=1;
        	$courserating = DB::table('courses')->leftjoin('topics', 'topics.course_id', '=','courses.id')->leftjoin('user_testimonial', 'topics.id', '=','user_testimonial.item_id')->where([['topics.user_id', Auth::user()->id],['topics.course_id',$chapters->id]])->get();
        	//print_r($courserating);
        	$count = count($courserating);
        	if ($count) {         
	        	$max=0;
	        	foreach ($courserating as $key => $ratingvalue) {        		 
	        		$max = $max+$ratingvalue->rating;       		
	        		# code...
	        	}
	        	$average= ceil($max / $count);
     	   	}else{
     	   		$average="";
     	   	}
			//print_r($usersData)	;
       		return view('user.dashboard',['userData' => $usersData,'UserChapterData' => $UserChapterData ,'exist'=>$paymentvarify,'average'=>$average]);	
       }else{
       	   return redirect('/course');
       }	
	}
	
	public function showChapter($id){
			if(empty(Auth::user()->id)){
			return redirect('/');
		}
		$paymentvarify = DB::table('chapters')
			->join('items','items.item_id','=','chapters.course_id')
			->join('orders','orders.id','=','items.order_id')
			->select('*')
			->where([['chapters.id',$id],['orders.user_id',Auth::user()->id]])	
			->count();
		if($paymentvarify){
			$usersData = array();
			$usersData = DB::table('topics')
					->leftjoin('courses', 'courses.id', '=', 'topics.course_id')
					->leftjoin('users', 'users.id', '=', 'topics.user_id')
					->leftjoin('videos', 'videos.parent_id', '=', 'topics.id')
					->leftjoin('documents', 'documents.parent_id', '=', 'topics.id')
					->select('topics.id as topicId','topics.updated_at','topics.title','topics.description','topics.image as topicImage','courses.course_name','users.name','videos.url','videos.thumb_url','documents.document_url')
					->where([['topics.chapter_id', $id],['topics.publish','1']])	
					->distinct()
					->get();	
					$chapterData = DB::table('chapters')
						->leftjoin('courses', 'courses.id', '=', 'chapters.course_id')
						->leftjoin('users', 'users.id', '=', 'chapters.user_id')
						->leftjoin('videos', 'videos.parent_id', '=', 'chapters.id')
						->select('chapters.*','courses.course_name','users.name as userName','videos.url as video','videos.thumb_url')
						->where([['chapters.id', '=', $id]],['videos.parent_type','=','chapter'],['videos.parent_id','=',$id])->get();	
			
	       return view('user.chapterDetail',['userData' => $usersData,'chapterData' =>$chapterData]);
		}else{
			return redirect('/course');
		}
	}
	
	public function showTopic($id){
			if(empty(Auth::user()->id)){
			return redirect('/');
		}
		$paymentvarify = DB::table('orders')->where('user_id',Auth::user()->id)->count();
		if($paymentvarify){			
			$usersData = array();		
			$topicData = DB::table('topics')
			->leftjoin('courses', 'courses.id', '=', 'topics.course_id')
			->leftjoin('users', 'users.id', '=', 'topics.user_id')
			->leftjoin('videos', 'videos.parent_id', '=', 'topics.id')	 
			->select('topics.id as topicId','topics.title','topics.description','topics.image','topics.chapter_id','courses.*','users.*','videos.url','videos.thumb_url')
			->where([['topics.id', $id],['topics.publish','1']])	
			->get();

			if(count($topicData) > 0 ){
			$usersData = DB::table('topics')
					->join('courses', 'courses.id', '=', 'topics.course_id')
					->join('users', 'users.id', '=', 'topics.user_id')
					->join('videos', 'videos.parent_id', '=', 'topics.id')					
					->select('topics.id as topicId','topics.title','topics.description','topics.image as topicImage','courses.*','users.*','videos.url','videos.thumb_url')
					->where([['topics.chapter_id', $topicData['0']->chapter_id],['topics.publish','1']])	
					->get();
					
					$ratingdata = DB::table('user_testimonial')->where([['user_testimonial.user_id', Auth::user()->id],['user_testimonial.item_id',$topicData[0]->topicId]])->first();
					
					if($ratingdata){$ratingfull=$ratingdata->rating;}else{$ratingfull="";}						 

			 return view('user.chapterDetail',['userData' => $usersData,'topicData' => $topicData,'rating'=>$ratingfull]);	
			}else{
				 return redirect('/page_not_found');
			}
		}else{
 			return redirect('/course');

		}		 
	}
	public function download(Request $request){
		if ($request->isMethod('post')) {		
		$input = $request->all();	
		$doclist = DB::table('documents')->where([['parent_id', $input['product_id']]])->first();		
		$file = public_path('/uploads/documents/').$doclist->document_url;
		$headers = array('Content-Type' => 'image/jpeg','image/png','video/mp4','application/pdf');
		return Response::download($file,$doclist->document_url,$headers);
	}else{
		return redirect('/');
	}
		
	}


	public function admin_dashboard()
	{

		
		$today_orders = Order::where([ 
			                          [ 'created_at' ,'>=' ,Carbon::today()->toDateString()]
			                         ])->count();
		$all_users     = User::where([
									 ['user_type','=','user']
							     	])->count();

		return view('admin.dashboard',compact('all_users','today_orders'));
		
        }	

	

}
