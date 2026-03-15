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
        Schema::create('slot_assignees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workflow_slot_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('workflow_slot_id')->references('id')->on('workflow_slots')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_assignees');
    }
};
