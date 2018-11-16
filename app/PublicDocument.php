<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class PublicDocument extends Model
{
    //
  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_image', 'document_url'
    ];
    
}
