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
        Schema::create('input_options', function (Blueprint $table) {
            $table->id();
            $table->boolean("is_active");
            $table->boolean("is_default")->default(0);
            $table->json('title');
            $table->foreignId('custom_option_list_id')->references('id')->on('custom_option_lists')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_options');
    }
};
