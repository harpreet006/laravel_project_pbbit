<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TrailerVideo;
use VideoThumbnail;
use App\Document;
use Session;
use App\Topic;
use App\Video;
use Auth;
use Cart;
use DB;

class CourseController extends Controller
{



    private $upload_path;

    public function __construct()
    {
        # code...
        $this->upload_path = public_path('/uploads');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('id','desc')->get();
        return view('admin.pages.courses.index',compact('courses'));
    }

     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.courses.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator =  Validator::make($input, [
            'course_name' => 'required|string|max:255',
            'course_title' => 'required|string|max:255',
            'course_price' => 'alpha_num|max:11',
            'actual_price' => 'required|alpha_num|max:11',
            'course_description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png',
            'video' => 'required|mimes:avi,mpeg,mp4',
            'trailer_video' => 'mimes:avi,mpeg,mp4',
            'document.*' => 'mimes:doc,pdf,docx'
        ]);

        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

               $image = '';
               $video = $document = '';

               // save thumbtail
                if($request->hasFile('image')){
                    $file = $request->file('image');
                    $image =  str_random(20) . '.' . $file->getClientOriginalExtension();
                    $file->move($this->upload_path.'/thumnail/', $image);
                }

               $course_id =  Course::insertGetId([
                    'user_id' =>Auth::id(),
                    'course_name' => $input['course_name'], 
                    'course_title' => $input['course_title'],
                    'course_price' => $input['course_price'],
                    'actual_price' => $input['actual_price'],
                    'course_description' => $input['course_description'],
                    'image' => $image,
          'created_at' => date('Y-m-d H:i:s')
                ]);

                // save video
                if($request->hasFile('video')){
                        $file = $request->file('video');
                        $video = $course_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/videos', $video);
                        
                        $videoUrl = $this->upload_path.'/videos/'.$video;
                        $storageUrl = $this->upload_path.'/videos/thumb/';
                        $video_thumb = mt_rand().'.png'; 

                        \VideoThumbnail::createThumbnail($videoUrl, $storageUrl, $video_thumb , 2 , $width = 640, $height = 480);
                       
                        Video::create([
                            'parent_id' => $course_id, 
                            'parent_type' => 'course', 
                            'url' => $video,
                            'thumb_url' => $video_thumb
                        ]);
                }

                // save trailer video
                if($request->hasFile('trailer_video')){
                        $file = $request->file('trailer_video');
                        $trailer_video = $course_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/videos', $trailer_video);
                        
                        $videoUrl = $this->upload_path.'/videos/'.$trailer_video;
                        $storageUrl = $this->upload_path.'/videos/thumb/';
                        $video_thumb = mt_rand().'.png';

                        \VideoThumbnail::createThumbnail($videoUrl, $storageUrl, $video_thumb , 2 , $width = 640, $height = 480);
                       
                        TrailerVideo::create([
                            'parent_id' => $course_id,
                            'parent_type' => 'course', 
                            'trailer_url' => $trailer_video,
                            'trailer_thumb_url' => $video_thumb
                        ]);
                }

                // save document
                if($request->hasFile('document')){

                    foreach($request->file('document') as $file){
                        $document = $course_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/documents', $document);
                        Document::create([
                            'parent_id' => $course_id, 
                            'parent_type' => 'course', 
                            'document_url' => $document
                        ]);
                    }
                }

                $topiscussesscreated= __('messages.Course Successfully Created');
                $request->session()->flash('status', $topiscussesscreated);

                return redirect('admin/courses');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::where('id', $id)->first();
        return view('admin.pages.courses.edit',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $course_id = $id;

        $validator =  Validator::make($input, [
            'course_name' => 'required|string|max:255',
            'course_title' => 'required|string|max:255',
            'course_price' => 'alpha_num|max:11',
            'actual_price' => 'required|alpha_num|max:11',
            'course_description' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            'video' => 'mimes:avi,mpeg,mp4',
            'trailer_video' => 'mimes:avi,mpeg,mp4',
            'document.*' => 'mimes:doc,pdf,docx'
        ]);

        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

               $video = $document = '';
               $course = Course::find($course_id);

               // save thumbtail
                if($request->hasFile('image')){

                  // delete old file
                    @unlink($this->upload_path.'/thumnail/'.$course->image);

                    $file = $request->file('thumnail');
                    $course->image =  str_random(20) . '.' . $file->getClientOriginalExtension();
                    $file->move($this->upload_path.'/thumnail', $course->image);
                }

                $course->course_name = $input['course_name'];
                $course->course_title = $input['course_title'];
                $course->course_description = $input['course_description'];
                $course->course_price = $input['course_price'];
                $course->actual_price = $input['actual_price'];
                $course->publish = $input['publish'];
        $course->updated_at = date('Y-m-d H:i:s');
                $course->save();

                // save video
                if($request->hasFile('video')){
                        $file = $request->file('video'); 
                        $video = $course_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/videos', $video);
                        $videoUrl = $this->upload_path.'/videos/'.$video;
                        $storageUrl = $this->upload_path.'/videos/thumb/';
                        $video_thumb = mt_rand().'.png'; 
                        
                        \VideoThumbnail::createThumbnail($videoUrl, $storageUrl, $video_thumb , 2 , $width = 640, $height = 480);
                       
                        Video::create([
                            'parent_id' => $course_id, 
                            'parent_type' => 'course', 
                            'url' => $video,
                            'thumb_url' => $video_thumb
                        ]);

                         // delete old videos
                        if(!empty($request->video_ids)){
                          
                          $will_delete_video = Video::whereIn('id',explode(',', $request->video_ids))->get();
                          
                          if(count($will_delete_video)){
                            foreach ($will_delete_video as $del_video) {
                              @unlink($this->upload_path.'/videos/'.$del_video->url);
                              @unlink($this->upload_path.'/videos/thumb/'.$del_video->thumb_url);
                              Video::where('id',$del_video->id)->delete();
                            }
                          }

                        }

                }

               

                // save trailer video
                if($request->hasFile('trailer_video')){

                        $file=$request->file('trailer_video');

                        $trailer_video = $course_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/videos', $trailer_video);
                        
                        $videoUrl = $this->upload_path.'/videos/'.$trailer_video;
                        $storageUrl = $this->upload_path.'/videos/thumb/';
                        $video_thumb = mt_rand().'.png';

                        \VideoThumbnail::createThumbnail($videoUrl, $storageUrl, $video_thumb , 2 , $width = 640, $height = 480);
                       
                        TrailerVideo::create([
                            'parent_id' => $course_id, 
                            'parent_type' => 'course', 
                            'trailer_url' => $trailer_video,
                            'trailer_thumb_url' => $video_thumb
                        ]);

                        // delete old Trailder video
                if(!empty($request->trailer_id)){
                  $will_delete_traile=TrailerVideo::where('id',$request->trailer_id)->get();
                  if(count($will_delete_traile)){
                    foreach ($will_delete_traile as $del_trai) {
                      @unlink($this->upload_path.'/videos/'.$del_trai->trailer_url);
                      @unlink($this->upload_path.'/videos/thumb/'.$del_trai->trailer_thumb_url);
                      TrailerVideo::where('id',$del_trai->id)->delete();
                    }
                  }
                }

                }

                 

                // save document
                if($request->hasFile('document')){

                    foreach($request->file('document') as $file){
                        $document = $course_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/documents', $document);
                        Document::create([
                            'parent_id' => $course_id, 
                            'parent_type' => 'course',
                            'document_url' => $document
                        ]);
                    }


                    // delete old document
                if(!empty($request->document_ids)){
                  $will_delete_document = Document::whereIn('id',explode(',',$request->document_ids))->get();
                  if(count($will_delete_document)){
                    foreach ($will_delete_document as $del_doc) {
                      @unlink($this->upload_path.'/documents/'.$del_doc->document_url);
                      Document::where('id',$del_doc->id)->delete();
                    }
                  }
                }

                }

                $topiscussesscreated= __('messages.Course Successfully Updated');
                $request->session()->flash('status', $topiscussesscreated);

                return redirect('admin/courses');
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
        Course::where('id',$id)->delete();
        DB::table('chapters')->where('course_id',$id)->delete();
        return redirect()->back();
    }

    public function singlecourse(Request $request,$name){
            $courses_exist=DB::table('courses')
              ->leftJoin('users', 'users.id', '=', 'courses.user_id')           
              ->select('courses.*',  'users.first_name')
              ->where('courses.course_name', $name)->first(); 
                         
            if($courses_exist){    
                $getchapter=DB::table('chapters')           
                ->where('chapters.course_id',$courses_exist->id)->paginate(5);

                foreach ($getchapter as $key => $value) { 
                  $counttopic =DB::table('topics')           
                   ->where('topics.chapter_id',$value->id)->count();
                    $value->totalcount =$counttopic;                          
                }                          
                
                return view('singlecourse',['current_course' => $courses_exist,'chapter_list' => $getchapter,'class'=> $courses_exist->course_name,'type'=>"innerpage"]);
            }else{

                echo ('This page has expired'); die;

            }                    
           
    }

    public function courselist(Request $request)
    {
       
            $courselist = Course::get(); 
            if(count(Cart::content())){         
                $tiems= Cart::content();            
                foreach ($tiems as $key => $value) {
                        $existcourse[]= $value->id;                
                }
                if(count($existcourse)>0){  $existcourse=$existcourse; }
            }else{
              $existcourse=array();
            }
              
       return view('courselist',['courselist' => $courselist,'exitarray'=>$existcourse,'class'=>'courses','type'=>"innerpage"]);
            
    }
   public function sampleVideo($id){
		
		 $courses_exist=DB::table('topics')
              ->leftJoin('courses', 'courses.id', '=', 'topics.course_id')           
              ->select('topics.*',  'courses.course_name')
              ->where('topics.id', $id)->first();
		
        if($courses_exist){
            $courselist =Topic::where([
                ['publish','=',true],
                ['course_id','=',$courses_exist->course_id],
            ])->paginate(5);
           
            $trialVideo = DB::table('trailer_videos')->where([['parent_id', '=', $courses_exist->id],['parent_type','=','topic']])->get();
            if(count($trialVideo) > 0){ 
            $topicDetail = DB::table('topics')->where([['id', '=', $courses_exist->id]])->get();
			return view('user.video-detail',['lists' => $courselist,'class'=> $courses_exist->course_name,'type'=>"innerpage",'trialVideo' =>$trialVideo,'topicDetail'=>$topicDetail]);
			}else{
				 return redirect('/');
			}

        }else{
            return redirect('/');
        }   
        
    }



}
