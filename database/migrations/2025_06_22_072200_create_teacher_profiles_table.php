<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->unique();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('name');
            $table->enum('gender',['Nam', 'Nữ']);
            $table->string('phone_number')->nullable();
            $table->dateTime('dob');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
       Schema::dropIfExists('teacher_profiles');
    }
}
