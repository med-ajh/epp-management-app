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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('Description');
            $table->string('size');
            $table->integer('quantity')->default(0);
            $table->string('image')->nullable();
            $table->string('status')->default('Not Available');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->timestamps();


            $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
