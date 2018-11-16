<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTestimonialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_testimonial')) {
            Schema::create('user_testimonial', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id');
                $table->integer('rating')->default(0);
                $table->string('text',500)->nullable(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_testimonial');
    }
}
