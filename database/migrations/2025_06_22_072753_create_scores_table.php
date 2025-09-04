<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_profile_id');
            $table->unsignedBigInteger('class_id');
            $table->float('tp1')->unsigned();
            $table->float('tp2')->unsigned();
            $table->float('qt')->unsigned();
            $table->float('ck')->unsigned();
            $table->float('tk')->unsigned();
            $table->timestamps();
            
            $table->foreign('student_profile_id')->references('id')->on('student_profiles')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
