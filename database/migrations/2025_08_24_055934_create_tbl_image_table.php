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
        Schema::create('tbl_files', function (Blueprint $table) {
            $table->id('file_id');
            $table->integer('ref_object_id')->comment('Id của đối tượng nào đư lưu file');
            $table->string('controller_name')->comment('Tên controller thực hiện (Dùng để phân biệt xem trang nào upload file)');
            $table->integer('child_type')->comment('Dùng trong trường hợp 1 đối tượng có nhìu file cho nhiều trường (Các trang tự quy định số)');
            $table->text('path')->comment('Đường dẫn lưu file');
            $table->integer('size')->default(0);
            $table->string('extention');
            $table->integer('create_user_id');
            $table->dateTime('create_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_files');
    }
};
