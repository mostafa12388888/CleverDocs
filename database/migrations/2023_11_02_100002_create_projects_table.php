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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->integer('order');
            $table->string('reference_number')->unique();
            $table->longText('description');
            $table->double('contract_value');
            //drop down
            $table->string('project_type');
            $table->string('country');

             $table->string('project_manager_company');
             $table->string('contact');
             //drop down
            $table->boolean('project_status')->default(false);
            $table->foreignId('w_b_s_id')->references('id')->on('w_b_s')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
