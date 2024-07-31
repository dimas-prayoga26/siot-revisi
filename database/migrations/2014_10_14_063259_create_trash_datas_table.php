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
        Schema::create('trash_datas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable();
            $table->foreignUuid('garbage_officer_id')->nullable();
            $table->foreignUuid('trash_bin_id')->nullable();
            $table->double('weight');
            $table->foreignUuid('trash_type_id')->constrained();
            $table->foreignUuid('trash_type_detail_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trash_datas');
    }
};
