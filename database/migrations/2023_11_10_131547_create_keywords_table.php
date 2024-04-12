<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeywordsTable extends Migration
{
    public function up()
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id'); // ユーザーIDの追加
            $table->integer('role')->default(1);
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users'); // 外部キー制約
        });
    }

    public function down()
    {
        Schema::dropIfExists('keywords');
    }
}
