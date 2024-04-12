<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id'); // レシピとの関連
            $table->string('name'); // 材料名
            $table->string('quantity')->nullable(); // 材料の量（任意）
            $table->string('unit')->nullable(); // 材料の単位（任意）
            $table->timestamps();
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
};
