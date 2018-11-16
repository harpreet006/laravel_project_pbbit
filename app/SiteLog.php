<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteLog extends Model
{
    //

    protected $table = 'logs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'log','ip','client','action_type'
    ];


    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}
