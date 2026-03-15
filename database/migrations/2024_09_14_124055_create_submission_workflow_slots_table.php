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
        Schema::create('submission_workflow_slots', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->enum('shape', ['start', 'end', 'decision', 'step'])->default('step');
            $table->json('description')->nullable();
            $table->string('sla_unit');
            $table->integer('sla_value');
            $table->boolean('is_auto_decision')->nullable();
            $table->json('position');
            $table->boolean('auto_close')->default(false);
            $table->enum('status', ['notStarted', 'inProgress', 'approved', 'rejected', 'returned', 'failed', 'skipped'])->default('notStarted');
            $table->integer('index');
            $table->enum('approval_method', ['chosenApprove', 'allApprove','oneApprove'])->default('chosenApprove');
            $table->boolean('is_official_signature')->default(false);
            $table->unsignedBigInteger('signature_input_id')->nullable();
            $table->unsignedBigInteger('approval_text_id')->nullable();
            $table->unsignedBigInteger('submission_workflow_id');
            $table->unsignedBigInteger('workflow_slot_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_workflow_slots');
    }

};
