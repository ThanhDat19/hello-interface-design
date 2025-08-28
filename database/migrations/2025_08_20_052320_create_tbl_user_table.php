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
        Schema::create('tbl_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('fullname')->nullable();
            $table->string('nickname');
            $table->string('email');
            $table->string('password');
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->integer('role')->default(2)->comment('1: admin');
            $table->integer('create_user_id')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->integer('update_user_id')->nullable();
            $table->dateTime('update_date')->nullable();
        });
        Schema::create('tbl_user_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->integer('ref_user_id');
            $table->string('fullname')->nullable();
            $table->string('nickname');
            $table->string('email');
            $table->string('password');
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->integer('role')->default(2)->comment('1: admin');
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
        Schema::dropIfExists('tbl_user');
        Schema::dropIfExists('tbl_user_history');
    }
};
