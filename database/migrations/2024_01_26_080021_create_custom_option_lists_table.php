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
        Schema::create('custom_option_lists', function (Blueprint $table) {
            $table->id();
            $table->boolean("is_active");
            $table->boolean("is_default")->default(0);
            $table->json('title');
            // $table->foreignId('input_type_id')->nullable()->references('id')->on('input_types')->cascadeOnDelete();
            $table->integer('key')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_option_lists');
    }
};
