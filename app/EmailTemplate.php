<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'template_name', 'template','template','template_for', 'user_id'
    ];


}
