<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //


  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic_id', 'document_url','parent_id', 'parent_type'
    ];

    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }
    
}
