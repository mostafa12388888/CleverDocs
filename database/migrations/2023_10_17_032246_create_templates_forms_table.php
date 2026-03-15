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
        Schema::create('templates_forms', function (Blueprint $table) {
            $table->id();
            $table->json('name',150);
            $table->enum('layout',['landscape','portrait'])->default('landscape');
            $table->boolean('Primary')->default(0);
            $table->string('update_by')->nullable();
            $table->string('create_by')->nullable();
            $table->enum('status',['active','hidden'])->default('hidden');
            $table->date('update_date');
            $table->foreignId('main_template_form_id')->references('id')->on('main_template_forms')->cascadeOnDelete();
//            $table->foreignId('workflow_id')->nullable()->references('id')->on('workflows')->cascadeOnDelete();
            $table->integer('version')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates_forms');
    }
};
