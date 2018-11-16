<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGetway extends Model
{
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'getway_name', 'note', 'status','is_sendbox'
    ];


    public function payment_meta()
    {
       return $this->hasMany('App\PaymentMeta','payment_getway_id','id');
    }

    
}
