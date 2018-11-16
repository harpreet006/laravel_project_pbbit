<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Chapter extends Model
{
    //

    public function user()
    {
      return $this->hasOne('App\User','id','user_id');
    }

    public function course()
    {
       return $this->hasOne('App\Course','id','course_id');
    }

     public function video()
    {
       return $this->hasMany('App\Video','parent_id','id')->where('parent_type','chapter');;
    }

    public function document()
    {
       return $this->hasMany('App\Document','parent_id','id')->where('parent_type','chapter');;
    }

    public function trailer_video()
    {
       return $this->hasMany('App\TrailerVideo','parent_id','id')->where('parent_type','chapter');;
    }

    public function is_buyed()
    {
      $is_exist  =  DB::table('items')->where('item_id',$this->course_id)->count();

      if($is_exist){
       return 'Warning..! Some user has brought this Chapter are you sure want to delete ?.';
      }else{
        return 'Warning..! Are you sure to delete this Chapter.  if your deleted this chapter all lectures gone deleted into the system.';
      }
    }
    
}
