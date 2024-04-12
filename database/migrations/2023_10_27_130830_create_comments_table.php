<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // コメントのID（一意の識別子）
            $table->text('comment')->nullable(); // コメントのテキスト本文
            $table->unsignedBigInteger('user_id'); // コメントを投稿したユーザーのID
            $table->unsignedBigInteger('recipe_id'); // コメントが関連づけられているレシピのID
            $table->timestamps(); // 作成日時と更新日時

            // 外部キー制約を追加
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
