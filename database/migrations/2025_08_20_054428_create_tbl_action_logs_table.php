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
        Schema::create('tbl_action_logs', function (Blueprint $table) {
            $table->id('action_log_id');
            $table->string('action_route');
            $table->dateTime('action_date');
            $table->integer('action_user');
            $table->integer('action_type')->comment("1:create, 2: update, 3: delete");
            $table->text('action_content');
            $table->integer('ref_object_type');
            $table->integer('ref_object_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('tbl_action_logs');
    }
};
