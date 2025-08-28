<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_next_code', function (Blueprint $table) {
            $table->id('next_code_id');
            $table->string('table_name');
            $table->integer('increament');
            $table->unsignedBigInteger('max_value');
            $table->bigInteger('cur_value')->default(1);
        });
        if (Schema::hasColumn('tbl_next_code', 'max_value')) {
            DB::statement("ALTER TABLE `tbl_next_code` CHANGE `max_value` `max_value` BIGINT(20) UNSIGNED NOT NULL DEFAULT '18446744073709551615'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_next_code');
    }
};
