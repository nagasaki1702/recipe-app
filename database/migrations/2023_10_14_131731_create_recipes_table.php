<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    public function up()
{
    Schema::create('recipes', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->string('image')->nullable();
        $table->unsignedBigInteger('user_id'); // ユーザーIDを格納するカラム
        $table->foreign('user_id')->references('id')->on('users');
        $table->timestamps();
    });
}




    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}

