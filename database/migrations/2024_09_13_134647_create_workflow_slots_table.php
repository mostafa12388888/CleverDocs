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
        Schema::create('workflow_slots', function (Blueprint $table) {
            $table->id();
            $table->enum('shape', ['start', 'end', 'decision', 'step'])->default('step');
            $table->unsignedBigInteger('workflow_id');
            $table->json('title');
            $table->json('description')->nullable();
            $table->string('sla_unit');
            $table->integer('sla_value');
            $table->boolean('is_auto_decision')->nullable();
            $table->json('position');
            $table->boolean('auto_close')->default(false);
            $table->enum('status', ['notStarted', 'inProgress', 'approved', 'rejected', 'returned', 'failed', 'skipped'])->default('notStarted');
            $table->integer('level');
            $table->enum('approval_method', ['chosenApprove', 'allApprove','oneApprove'])->default('chosenApprove');
            $table->boolean('is_official_signature')->default(false);
            $table->unsignedBigInteger('signature_input_id')->nullable();
            $table->unsignedBigInteger('approval_text_id')->nullable();
            $table->unsignedBigInteger('index')->nullable();
            $table->timestamps();
            $table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
            $table->index(['workflow_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_slots');
    }
};
