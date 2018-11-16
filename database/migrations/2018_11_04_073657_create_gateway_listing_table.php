<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        

            Schema::create('gateway_listing', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name',255);
                $table->string('key',255);
                $table->string('value',500)->nullable(true);
                $table->string('type',500)->nullable(true);
            });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gateway_listing');
    }
}
