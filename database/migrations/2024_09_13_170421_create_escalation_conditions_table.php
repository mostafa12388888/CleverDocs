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
        Schema::create('escalation_conditions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['overall', 'slot'])->default('slot');
            $table->unsignedBigInteger('workflow_id')->nullable();
            $table->unsignedBigInteger('slot_id')->nullable();
            $table->unsignedBigInteger('slot_index')->nullable();
            $table->boolean('is_sla_exceeded')->default(false);
            $table->boolean('is_before_sla_exceeded')->default(false);
            $table->boolean('is_after_sla_exceeded')->default(false);
            $table->string('before_sla_unit');
            $table->integer('before_sla_value');
            $table->string('after_sla_unit');
            $table->integer('after_sla_value');
            $table->boolean('is_on_received')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escalation_conditions');
    }
};
