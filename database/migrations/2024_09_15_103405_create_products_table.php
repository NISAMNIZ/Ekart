<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable('categories')){
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->string('slug',50);
            $table->string('show_home',50);
            $table->string('image',100)->nullable();
            $table->timestamps();
        });
    }


    if(!Schema::hasTable('products')){
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->double('price',15,2);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('sub_category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->boolean('status')->comment('1:Active,2:Inactive')->default(1);
            $table->boolean('is_favorite')->comment('1:Yes,2:No')->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
