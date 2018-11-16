<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('chapters')) {

            Schema::create('chapters', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('user_id');
                $table->bigInteger('course_id')->nullable(true);
                $table->string('title');
                $table->longText('description');
                $table->integer('video_id')->nullable(true);
                $table->integer('document_id')->nullable(true);
                $table->integer('trailer_videos_id')->nullable(true);
                $table->string('image')->nullable(true);
                $table->boolean('publish')->default(true);
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('chapters');
    }
}
