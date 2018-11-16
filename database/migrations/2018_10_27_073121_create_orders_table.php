<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->bigInteger('plan_id')->nullable(true);
            $table->string('payment_getway','250')->nullable(true);
            $table->string('token','500')->nullable(true);
            $table->string('amount','100')->nullable(true);
            $table->string('transaction_id','500')->nullable(true);
            $table->enum('status',['pending','canceled','complete'])->default('pending');
            $table->boolean('read_status')->default(false);
            $table->string('note','1500')->nullable(true);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
