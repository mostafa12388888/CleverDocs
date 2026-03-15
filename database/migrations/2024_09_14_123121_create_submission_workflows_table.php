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
        Schema::create('submission_workflows', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_date')->nullable();
            $table->timestamp('started_date')->nullable();
            $table->boolean('is_auto')->default(false);
            $table->enum('status', ['inProgress', 'approved', 'rejected'])->default('inProgress');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('submission_id');
            $table->unsignedBigInteger('workflow_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_workflows');
    }
};
