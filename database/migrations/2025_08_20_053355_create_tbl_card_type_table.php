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
        Schema::create('tbl_card_type', function (Blueprint $table) {
            $table->id('card_type_id');
            $table->string('card_type_name');
            $table->text('description')->nullable();
            $table->boolean('is_hero')->default(2)->comment('1:hero');
            $table->integer('create_user_id')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->integer('update_user_id')->nullable();
            $table->dateTime('update_date')->nullable();
        });
        Schema::create('tbl_card_type_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->integer('ref_card_type_id');
            $table->string('card_type_name');
            $table->text('description')->nullable();
            $table->boolean('is_hero')->default(2)->comment('1:hero');
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
        Schema::dropIfExists('tbl_card_type');
        Schema::dropIfExists('tbl_card_type_history');
    }
};
