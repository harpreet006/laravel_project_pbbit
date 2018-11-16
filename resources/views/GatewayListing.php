<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatewayListing extends Model
{
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = "gateway_listing";
    public $fillable = ['id', 'name', 'key','value','type']; 
    
}
