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
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('main_workflow_id');
            $table->string('sla_unit');
            $table->integer('sla_value');
            $table->integer('version');
            $table->json('title');
            $table->boolean('is_auto_close');
            $table->boolean('is_active');
            $table->foreign('main_workflow_id')->references('id')->on('main_workflows')->onDelete('cascade');
            $table->index(['main_workflow_id']);
            $table->index(['created_by']);
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflows');
    }
};
