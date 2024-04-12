<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('recipe_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('rating'); // 整数型を使用
            $table->timestamps();

            // レシピごとの評価合計と評価の件数を格納するカラムを追加
            $table->integer('rating_sum')->default(0); // 評価合計
            $table->integer('rating_count')->default(0); // 評価の件数

            // 外部キー制約を追加
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_ratings');
    }
}
