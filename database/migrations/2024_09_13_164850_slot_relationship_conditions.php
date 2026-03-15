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
        Schema::create('slot_relationship_conditions', function (Blueprint $table) {
            $table->id();

            // Foreign keys for parent slot and child slot (self-referencing slots)
            $table->unsignedBigInteger('parent_slot_id');
            $table->unsignedBigInteger('child_slot_id');

            // Foreign key to reference the condition applied to the relation
//            $table->unsignedBigInteger('condition_id')->nullable();


            $table->string('condition_operator')->nullable();
            $table->unsignedBigInteger('condition_input_id')->nullable();
            $table->string('condition_value')->nullable();

            // Defining the relationships
            $table->foreign('parent_slot_id')->references('id')->on('workflow_slots')->onDelete('cascade');
            $table->foreign('child_slot_id')->references('id')->on('workflow_slots')->onDelete('cascade');

            $table->json('title')->nullable();
            $table->boolean('is_default')->default(false);
            $table->enum('type', ['Formward', 'GoAhead'])->default('Formward');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_relationship_conditions');
    }
};
