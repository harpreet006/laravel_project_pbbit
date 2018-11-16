<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TrailerVideo;
use VideoThumbnail;
use App\Document;
use App\Video;
use Auth;
use DB;

class TopicController extends Controller
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
        $topics = Topic::orderBy('id','desc')->get();
        return view('admin.pages.topics.index',compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $courses = DB::table('courses')->get();
        $chapters = [];
		if($courses){
			$chapters = DB::table('chapters')->where('course_id',$courses[0]->id)->get();
		}
        return view('admin.pages.topics.add',compact('courses','chapters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $input = $request->all();

        $validator =  Validator::make($input, [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|alpha_num',
            'course_id' => 'required|alpha_num',
            'chapter_id' => 'required|alpha_num',
            'thumnail' => 'required|mimes:jpeg,jpg,png',
            'video' => 'required',
            'video.*' => 'mimes:avi,mpeg,mp4',
            'trailer_video' => 'mimes:avi,mpeg,mp4',
            'document' => 'required',
            'document.*' => 'mimes:doc,pdf,docx'
        ]);

        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

               $image = 'testing.png';
               $video = $document = '';

               // save thumbtail
                if($request->hasFile('thumnail')){
                    $file = $request->file('thumnail');
                    $image =  str_random(20) . '.' . $file->getClientOriginalExtension();
                    $file->move($this->upload_path.'/thumnail/', $image);
                }

               $topic_id =  Topic::insertGetId([
                    'title' => $input['title'],
                    'description' => $input['description'],
                    'price' => $input['price'],
                    'course_id' => $input['course_id'],
                    'chapter_id' => $input['chapter_id'],
                    'publish' => $input['publish'],
                    'user_id' => Auth::id(),
                    'image' => $image,
                ]);

                // save video
                if($request->hasFile('video')){
                    foreach($request->file('video') as $file){
                        $video = $topic_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/videos', $video);
                        
                        $videoUrl = $this->upload_path.'/videos/'.$video;
                        $storageUrl = $this->upload_path.'/videos/thumb/';
                        $video_thumb = mt_rand().'.png'; 

                        \VideoThumbnail::createThumbnail($videoUrl, $storageUrl, $video_thumb , 2 , $width = 640, $height = 480);
                       
                        Video::create([
                            'parent_id' => $topic_id, 
                            'parent_type' => 'topic', 
                            'url' => $video,
                            'thumb_url' => $video_thumb
                        ]);
                    }
                }

                // save trailer video
                if($request->hasFile('trailer_video')){
                        $file = $request->file('trailer_video');
                        $trailer_video = $topic_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/videos', $trailer_video);
                        
                        $videoUrl = $this->upload_path.'/videos/'.$trailer_video;
                        $storageUrl = $this->upload_path.'/videos/thumb/';
                        $video_thumb = mt_rand().'.png';

                        \VideoThumbnail::createThumbnail($videoUrl, $storageUrl, $video_thumb , 2 , $width = 640, $height = 480);
                       
                        TrailerVideo::create([
                            'parent_id' => $topic_id, 
                            'parent_type' => 'topic', 
                            'trailer_url' => $trailer_video,
                            'trailer_thumb_url' => $video_thumb
                        ]);
                }

                // save document
                if($request->hasFile('document')){

                    foreach($request->file('document') as $file){
                        $document = $topic_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/documents', $document);
                        Document::create([
                            'parent_id' => $topic_id, 
                            'parent_type' => 'topic',
                            'document_url' => $document
                        ]);
                    }
                }

                $topiscussesscreated= trans('messages.topic_successfully_created');
                $request->session()->flash('status', $topiscussesscreated);

                return redirect('admin/topics');
    }

}

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$chapters = [] ; 
        $topic = Topic::where('id', $id)->first();
        $courses = DB::table('courses')->get();
		$chapters = DB::table('chapters')->where('course_id',$topic->course_id)->get();
        return view('admin.pages.topics.edit',compact('courses','chapters','topic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $topic_id)
    {
        $input = $request->all();

        $validator =  Validator::make($input, [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|alpha_num',
            'course_id' => 'required|alpha_num',
            'chapter_id' => 'required|alpha_num',
            'image' => 'mimes:jpeg,jpg,png',
            'trailer_video' => 'mimes:avi,mpeg,mp4',
             //'video' => 'required',
             'video.*' => 'mimes:avi,mpeg,mp4',
             //'document' => 'required',
             'document.*' => 'mimes:doc,pdf,docx'
        ]);

        if($validator->fails()){

            return redirect()->back()->withErrors($validator)->withInput();

        }else{

               $video = $document = '';
               $topic = Topic::find($topic_id);

               // save thumbtail
                if($request->hasFile('image')){

                  // delete old file
                    @unlink($this->upload_path.'/thumnail/'.$topic->image);

                    $file = $request->file('image');
                    $topic->image =  str_random(20) . '.' . $file->getClientOriginalExtension();
                    $file->move($this->upload_path.'/thumnail', $topic->image);
                }

                $topic->title = $input['title'];
                $topic->description = $input['description'];
                $topic->price = $input['price'];
                $topic->course_id = $input['course_id'];        
                $topic->chapter_id = $input['chapter_id'];
                $topic->publish = $input['publish'];
                $topic->user_id = Auth::id();
                $topic->save();

                // save video
                if($request->hasFile('video')){
                    foreach($request->file('video') as $file){
                        $video = $topic_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/videos', $video);
                        $videoUrl = $this->upload_path.'/videos/'.$video;
                        $storageUrl = $this->upload_path.'/videos/thumb/';
                        $video_thumb = mt_rand().'.png'; 
                        
                        \VideoThumbnail::createThumbnail($videoUrl, $storageUrl, $video_thumb , 2 , $width = 640, $height = 480);
                       
                        Video::create([
                            'parent_id' => $topic_id, 
                            'parent_type' => 'topic', 
                            'url' => $video,
                            'thumb_url' => $video_thumb
                        ]);
                    }
                }

                // delete old videos
                if(!empty($request->video_ids)){
                  
                  $will_delete_video = Video::whereIn('id',explode(',', $request->video_ids))->get();
                  
                  if(count($will_delete_video)){
                    foreach ($will_delete_video as $del_video) {
                      @unlink($this->upload_path.'/videos/'.$del_video->url);
                      @unlink($this->upload_path.'/videos/thumb/'.$del_video->thumb_url);
                      Video::where('id',$del_video->id)->delete();;
                    }
                  }

                }

                // save trailer video
                if($request->hasFile('trailer_video')){

                        $file=$request->file('trailer_video');

                        $trailer_video = $topic_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/videos', $trailer_video);
                        
                        $videoUrl = $this->upload_path.'/videos/'.$trailer_video;
                        $storageUrl = $this->upload_path.'/videos/thumb/';
                        $video_thumb = mt_rand().'.png';

                        \VideoThumbnail::createThumbnail($videoUrl, $storageUrl, $video_thumb , 2 , $width = 640, $height = 480);
                       
                        TrailerVideo::create([
                            'parent_id' => $topic_id, 
                            'parent_type' => 'topic', 
                            'trailer_url' => $trailer_video,
                            'trailer_thumb_url' => $video_thumb
                        ]);
                }

                 // delete old Trailder video
                if(!empty($request->trailer_id)){
                  $will_delete_traile=TrailerVideo::where('id',$request->trailer_id)->get();
                  if(count($will_delete_traile)){
                    foreach ($will_delete_traile as $del_trai) {
                      @unlink($this->upload_path.'/videos/'.$del_trai->trailer_url);
                      @unlink($this->upload_path.'/videos/thumb/'.$del_trai->trailer_thumb_url);
                      TrailerVideo::where('id',$del_trai->id)->delete();;
                    }
                  }
                }
                
                // save document
                if($request->hasFile('document')){

                    foreach($request->file('document') as $file){
                        $document = $topic_id.'_'.str_random(20) . '.' . $file->getClientOriginalExtension();
                        $file->move($this->upload_path.'/documents', $document);
                        Document::create([
                            'parent_id' => $topic_id, 
                            'parent_type' => 'topic',
                            'document_url' => $document
                        ]);
                    }
                }

                // delete old document
                if(!empty($request->document_ids)){
                  $will_delete_document=Document::whereIn('id',explode(',',$request->document_ids))->get();
                  if(count($will_delete_document)){
                    foreach ($will_delete_document as $del_doc) {
                      @unlink($this->upload_path.'/documents/'.$del_doc->document_url);
                      Document::where('id',$del_doc->id)->delete();;
                    }
                  }
                }
                $topiscussesscreated= trans('messages.topic_successfully_updated');
                $request->session()->flash('status', $topiscussesscreated);

                return redirect('admin/topics');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        # code...
      Topic::where('id',$id)->delete();
      $topicdeleted= trans('messages.topic_successfully_deleted');
      session()->flash('status', $topicdeleted);
        return redirect()->back();

    }
}