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
        Schema::create('tbl_card', function (Blueprint $table) {
            $table->id('card_id');
            $table->string('card_code');
            $table->string('card_name');
            $table->integer('card_type_id');
            $table->text('description')->nullable();
            $table->integer('defense_stat')->default(0);
            $table->integer('magic_stat')->default(0);
            $table->integer('support_stat')->default(0);
            $table->integer('attack_stat')->default(0);
            $table->integer('dodge_stat')->default(0);
            $table->integer('create_user_id')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->integer('update_user_id')->nullable();
            $table->dateTime('update_date')->nullable();
        });
        Schema::create('tbl_card_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->integer('ref_card_id');
            $table->string('card_code');
            $table->string('card_name');
            $table->integer('card_type_id');
            $table->text('description')->nullable();
            $table->integer('defense_stat')->default(0);
            $table->integer('magic_stat')->default(0);
            $table->integer('support_stat')->default(0);
            $table->integer('attack_stat')->default(0);
            $table->integer('dodge_stat')->default(0);
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
        Schema::dropIfExists('tbl_card');
        Schema::dropIfExists('tbl_card_history');
    }
};
