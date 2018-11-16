<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
	
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'plan_id', 'payment_getway','txn_id','address_state','address_city','address_street','last_name','first_name','payer_email','amount','transaction_id','invoice','status','payment_type','shipping','item_name','quantity','txn_type'    
    ];

  
}
