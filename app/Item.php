<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //



   protected $fillable = [
        'order_id', 'item_id', 'quantity','quantity','price'
    ];
    public function course()
    {
       return $this->hasOne('App\Course','id','item_id');
    }


}
