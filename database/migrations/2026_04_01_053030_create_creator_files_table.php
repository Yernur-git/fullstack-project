<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('creator_files', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('original_filename')->nullable();
        $table->string('file_path')->nullable();
        $table->string('file_type')->nullable();
        $table->string('software')->nullable();
        $table->unsignedBigInteger('file_size')->default(0);
        $table->text('description')->nullable();
        $table->unsignedInteger('download_count')->default(0);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('creator_files');
    }
};
