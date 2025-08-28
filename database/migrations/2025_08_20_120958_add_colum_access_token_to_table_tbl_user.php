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
        if (!Schema::hasColumn('tbl_user', 'access_token')) {
            Schema::table('tbl_user', function (Blueprint $table) {
                $table->text('access_token')->after('update_date')->nullable();
            });
        }
        if (!Schema::hasColumn('tbl_user_history', 'access_token')) {
            Schema::table('tbl_user_history', function (Blueprint $table) {
                $table->text('access_token')->after('update_date')->nullable();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('tbl_user', 'access_token');
        Schema::dropColumns('tbl_user_history', 'access_token');

    }
};
