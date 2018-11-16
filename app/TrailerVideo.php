<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrailerVideo extends Model
{
    //


         /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic_id', 'trailer_url','trailer_thumb_url','parent_id', 'parent_type'
    ];



    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }
    
}
