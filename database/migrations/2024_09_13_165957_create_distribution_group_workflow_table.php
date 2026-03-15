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
        Schema::create('distribution_group_workflow', function (Blueprint $table) {
            $table->id();

            // Foreign keys for the workflow and distribution group
            $table->unsignedBigInteger('workflow_id');
            $table->unsignedBigInteger('distribution_group_id');

            // Defining the relationships
            $table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
            $table->foreign('distribution_group_id')->references('id')->on('distribution_groups')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_group_workflow');
    }
};
