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
        Schema::create('input_types', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->enum('type',['string','number','dropdown','build in attachment','boolen','date','text','file','attachment','button']);
            $table->string('sub_type')->nullable();
            $table->string('category');
            // $table->foreignId('custom_option_lists')->references('id')->on('custom_optionslists')->cascadeOnDelete();
            $table->softDeletes();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_types');
    }
};
