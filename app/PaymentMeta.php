<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMeta extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'payment_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label', 'meta_key', 'meta_value','payment_getway_id'
    ];

     public function payment_getways()
    {
        return $this->belongsTo('App\PaymentGetway');
    }

}
