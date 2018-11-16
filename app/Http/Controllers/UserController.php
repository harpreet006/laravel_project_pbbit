<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\Register;
use App\Mail\verifyUser;
use App\SiteLog;
use App\User;
use Auth;
use Mail;
use URL;
use DB;

class UserController extends Controller
{
    //
      public function index(Request $request)
    {
      # code...
      $coulams = [];
      $input = $request->all();


      $query = User::where([ ['user_type', '!=' , 'admin'] ])->where([ ['status', '=' , 'active'] ]);

      if(isset($input['search_str']) && !empty($input['search_str'])){

          if(isset($input['column']) && !empty($input['column'])){
            $coulams =  $input['column'];
          }

      }
    
      $i = 0;
      if(count($coulams)){
            foreach($coulams as $coulam){
                if(in_array($coulam, ['email','name'])){
                  if($i == 0){
                    $query->where($coulam, 'LIKE', "%". $input['search_str'] . "%");
                  }else{
                   $query->orWhere($coulam, 'LIKE', "%". $input['search_str'] . "%");
                  }
                  $query->orderBy($coulam, 'ASC');
                  $i++;
                }
            }
      }

     $users  = $query->paginate(15);

      return view('admin.pages.users.index',compact('users'));

    }

     public function create()
    {
        return view('admin.pages.users.create_user');
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin.pages.users.edit', ['user' => User::findOrFail($id)]);
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('admin.pages.users.profile', ['user' => User::findOrFail($id)]);
    }

    public function store(Request $request)
    {
        //
         # code...
        $input = $request->all();

        $validator =  Validator::make($input, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|alpha_num|min:6|confirmed',
          
        ]);
        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'name' => $input['first_name'].' '. $input['last_name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
            ]);

            $topicsuccesscreated= trans('messages.topic_successfully_created');
            $request->session()->flash('status', $topicsuccesscreated);

            return redirect('admin/users');

        }
    }


    /**
     * Update the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        //
         # code...
        $input = $request->all();

        $validator =  Validator::make($input, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            //'address' => 'required|string|max:1500',
            'email' => 'required|string|email|max:255|unique:users,id,'.$id ,
            'image' => 'image|mimes:jpeg,jpg,png|max:10000',
        ]);
        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

             $file_name = $input['old_image'];


             if($request->hasFile('image') && $request->file('image')->isValid()){
                $file = $request->file('image');
                $file_name = $id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                $file->move(base_path() . '/public/images/avatar', $file_name);
            }


            User::where('id',$id)->update([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'name' => $input['first_name'].' '. $input['last_name'],
                'email' => $input['email'],
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'avtar' => $file_name,
            ]);

               SiteLog::create([
                'user_id' => Auth::id(),
                'action_type' => 'update',
                'log' => 'User  ('.$input['email'].') updated by '.Auth::user()->name,
                'ip' => $request->ip(),
                'client' =>$request->header('user-agent'),
            ]);


            $usersuccessmsg= trans('messages.user_successfully_updated');
            $request->session()->flash('status', $usersuccessmsg);

            return redirect('admin/users');

        }
    }

   public function change_password(Request $request)
    {
        # code...
        $input = $request->all();

        $validator =  Validator::make($input, [
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return redirect(URL::previous()."#change-password")->withErrors($validator)->withInput();
        }else{

            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($input['password']),
            ]);

            SiteLog::create([
                'user_id' => Auth::id(),
                'action_type' => 'update',
                'log' => 'User ('.$input['email'].') password changed by '.Auth::user()->name,
                'ip' => $request->ip(),
                'client' =>$request->header('user-agent'),
            ]);

            
            $passwordchangedmsg= trans('messages.password_changed_msg');
            $request->session()->flash('status', $passwordchangedmsg);

            return redirect()->back();
        }

    }

    /**
     * Active and deactive the given user.
     *
     * @param  string  $id , $status
     * @return Response
     */
    public function change_status($id,$status)
    {
      $user = User::findOrFail($id);
      if($user){
        $old_status  =  $user->status;
        if(in_array($status, ['active','inactive'])){
          $user->status = $status;
          $user->save();


          SiteLog::create([
                'user_id' => Auth::id(),
                'action_type' => 'update',
                'log' => 'User ('.$input['email'].') status changed from '.$old_status .'to '. $status .' by '.Auth::user()->name,
                'ip' => $request->ip(),
                'client' =>$request->header('user-agent'),
            ]);

          session()->flash('status', 'User Successfuly '.$status.'d');
        }
      }
      return redirect()->back();
    }
    


    /**
     * Delete the given user.
     *
     * @param  string  $id
     * @return Response
     */

    public function destroy($id)
    {
      # code...

      SiteLog::create([
                'user_id' => Auth::id(),
                'action_type' => 'deleted',
                'log' => 'User ('.$input['email'].') deleted by '.Auth::user()->name,
                'ip' => $request->ip(),
                'client' =>$request->header('user-agent'),
            ]);

      User::where('id',$id)->delete();
      session()->flash('status', 'User deleted');
        return redirect()->back();

    }

    /**
     * Show the given user.
     *
     * @param  string  $id
     * @return Response
     */
    public function profile()
    {
        # code...
        $id =  Auth::id();
        return view('admin.pages.users.profile', ['user' => User::findOrFail($id)]);
    }



/*public function register(Request $request)  
{
   
  if ($request->ajax()) {
    # code...
    $input = $request->all();
      $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => array(
                          'required',
                          'min:6',
                          'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                         ),
             
            //'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
          $errors = $validator->errors(); 
          return response()->json(['status'=> 0 , 'errors' => $errors ]);
        }else{    
          $user =  User::create([
                  'name' => $input['name'],
                  'email' => $input['email'],
                  'password' => Hash::make($input['password']),            
                  'status' => '1',  
                  'notification' => '1',  
                  'remember_token' => $input['_token']
              ]);

          $email = $input['email'];
        
          Mail::to($email)->send(new Register($user));
          Mail::to($email)->send(new verifyUser($user));

          if(!Auth::check()){
              $log_msg = 'New User ('.$input['email'].') created.';
          }else{
              $log_msg = 'User ('.$input['email'].') created by '.Auth::user()->name;
          }

           SiteLog::create([
                'user_id' => Auth::id(),
                'action_type' => 'create',
                'log' => $log_msg,
                'ip' => $request->ip(),
                'client' =>$request->header('user-agent'),
            ]);

          return response()->json(['status'=>1 , 'message'=> 'Thanku so much for joinging PBIT!. To finish signing up just need you to confirm your email address.<b>Check your inbox.</b>']);

        }
  }else{
    return response()->json(['status'=>0 , 'message'=> 'permission not granted']);
  }
}*/


public function register(Request $request)  
{
  # code...
  //echo "hooop"; die;
  if ($request->ajax()) {
    # code...
    $input = $request->all();
      $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => array(
                          'required',
                          'min:6',
                          'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                         ),
             
            //'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
          $errors = $validator->errors(); 
          return response()->json(['status'=> 0 , 'errors' => $errors ]);
        }else{    
          $user =  User::create([
                  'name' => $input['name'],
                  'email' => $input['email'],
                  'password' => Hash::make($input['password']),            
                  'status' => '1',  
                  'notification' => '1',  
                  'remember_token' => $input['_token']             
              ]);
      
/*          $email = $input['email'];
         $user = User::findOrFail($user->id);         
         Mail::send('email.verify_user', ['user' => $user], function ($m) use ($user) {
        $m->from('jasvirs210@gmail.com', 'Your Application');
        $mailto=$m->to('jasvir.shinedezign@gmail.com', 'singh')->subject('Your Reminder!');
        if($mailto){
          echo "success";
        }else{
          echo "failed";
        }

        });*/
          //Mail::to($email)->send(new verifyUser($user));
          //Auth::guard()->login($user);
          return response()->json(['status'=>1 , 'message'=> 'success']);
        }
  }else{
    return response()->json(['status'=>0 , 'message'=> 'permission not granted']);
  }
}

public function login(Request $request)  
{
    
  if ($request->ajax()) {
    # code...
          $email         = $request->email;
          $password      = $request->password;
          $rememberToken = $request->_token; 
          $secret="6Le6KXcUAAAAAH0DDUC-evoydppjw1alDsSXpstP";
          $response=$request->captcha;  
          if($email=="" || $password==""){
              $msg = array(
          'status'  => 'error',
          'message' => 'Login Fail !'
        ); 
        //print_r($msg);
        return response()->json($msg);
          }
          $verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
          $captcha_success=json_decode($verify);            
          if ($captcha_success->success==0) {
              $msg = array(
                'status'  => 'error',
                'message' => 'captcha is not matched'
              ); 
              //print_r($msg);
              return response()->json($msg);
          }
          // now we use the Auth to Authenticate the users Credentials
      // Attempt Login for members
      if (Auth::attempt(['email' => $email, 'password' => $password], $rememberToken)) {
        $msg = array(
          'status'  => 'success',
          'message' => 'Login Successful'
        ); 
         return response()->json($msg);
      } else {
        $msg = array(
          'status'  => 'error',
          'message' => 'Login Fail !'
        ); 
        return response()->json($msg);
      }
  }else{
    return response()->json(['status'=>0 , 'message'=> 'permission not granted']);
  } 
}

public function verify_user($token)
{

  if(!empty($token)){
    $user = User::where('remember_token',$token)->first();
    if($user){
      $user->email_verified_at  =  date('Y-m-d H:i:s');
      $user->remember_token = null;
      $user->save();
      session()->flash('message', 'Congratulations! Your Acount Successfuly verifyed.');
    }
    return redirect('/');
  }
}

}
