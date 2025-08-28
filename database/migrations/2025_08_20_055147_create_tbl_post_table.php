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
        Schema::create('tbl_post', function (Blueprint $table) {
            $table->id('post_id');
            $table->text('title');
            $table->text('content');
            $table->integer('create_user_id')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->integer('update_user_id')->nullable();
            $table->dateTime('update_date')->nullable();
        });
        Schema::create('tbl_post_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->integer('ref_post_id');
             $table->text('title');
            $table->text('content');
            $table->integer('create_user_id')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->integer('update_user_id')->nullable();
            $table->dateTime('update_date')->nullable();
            $table->integer('version')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_post');
        Schema::dropIfExists('tbl_post_history');
    }
};
