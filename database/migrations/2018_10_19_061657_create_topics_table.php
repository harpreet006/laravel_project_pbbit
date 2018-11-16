<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('topics')) {
            Schema::create('topics', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->bigInteger('course_id')->nullable(true);
                $table->bigInteger('chapter_id')->nullable(true);
                $table->integer('video_id')->nullable(true);
                $table->integer('document_id')->nullable(true);
                $table->integer('trailer_videos_id')->nullable(true);
                $table->string('title');
                $table->longText('description');
                $table->float('price', 8, 2);
                $table->string('image')->nullable(true);
                $table->string('type')->nullable(true);
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
        Schema::dropIfExists('topics');
    }
}
