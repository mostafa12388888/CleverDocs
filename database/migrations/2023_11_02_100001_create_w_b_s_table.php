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
        Schema::create('w_b_s', function (Blueprint $table) {
            $table->id();

            $table->foreignId('w_b_s_id')->nullable()->references('id')->on('w_b_s');

            $table->string('created_by')->nullable();
            $table->json('title');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('w_b_s');
    }
};
