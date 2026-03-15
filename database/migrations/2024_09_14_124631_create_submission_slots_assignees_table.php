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
        Schema::create('submission_slots_assignees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submission_slot_id');
            $table->unsignedBigInteger('assignee_id');
            $table->enum('status', ['notStarted', 'inProgress', 'approved', 'rejected', 'returned', 'skipped'])->default('notStarted');
            $table->unsignedBigInteger('submission_workflow_slot_id');
            $table->unsignedBigInteger('submission_workflow_id');
            $table->unsignedBigInteger('submission_id');
            $table->boolean('is_chosen')->default(false);
            $table->boolean('is_action_by')->default(false);
            $table->text('comment')->nullable();
            $table->timestamp('action_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_slots_assignees');
    }
};
