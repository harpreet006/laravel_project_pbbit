<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Course extends Model
{

     public function topics()
    {
        return $this->hasMany('App\Topic');
    }


    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function video()
    {
       return $this->hasOne('App\Video','parent_id','id')->where('parent_type','course');
    }

    public function document()
    {
       return $this->hasMany('App\Document','parent_id','id')->where('parent_type','course');
    }

    public function trailer_video()
    {
       return $this->hasOne('App\TrailerVideo','parent_id','id')->where('parent_type','course');
    }


    public function is_buyed()
    {
      $is_exist  =  DB::table('items')->where('item_id',$this->id)->count();

      if($is_exist){
       return 'Warning..! Some user has brought this course are you sure want to delete ?.';
      }else{
        return 'Warning..! Are you sure to delete this Courses.  if your deleted this Courses all the chapter and lectures gone deleted into the system.';
      }
      
    }

}
