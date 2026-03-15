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
        Schema::create('template_inputs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['string', 'number', 'dropdown', 'boolen', 'date', 'text', 'textarea', 'build in attachment', 'file', 'attachment', 'button'])->nullable();
            $table->string('styles');
            $table->boolean('is_mondatory')->default(0);
            $table->string('title');
            $table->string('custom_title');
            $table->float('position_x');
            $table->float('position_y');
            $table->integer('height');
            $table->integer('width');
            // $table->foreignId('input_types_id')->references('id')->on('input_types')->cascadeOnDelete();
            $table->foreignId('templates_forms_id')->references('id')->on('templates_forms')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_inputs');
    }
};
