<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    protected $fillable = [
        'user_id', 'plan_id', 'payment_getway','amount','token','transaction_id ','status '
    ];

    public function user()
    {
      return $this->hasOne('App\User','id','user_id');
    }

    public function course()
    {
       return $this->hasOne('App\Course','id','plan_id');
    }

    public function items()
    {
       return $this->hasMany('App\Item','order_id','id');
    }



}
