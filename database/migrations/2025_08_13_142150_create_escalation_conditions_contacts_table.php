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
        Schema::create('escalation_conditions_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('escalation_condition_id')->index();
            $table->foreign('escalation_condition_id')->references('id')->on('escalation_conditions')->onDelete('cascade');
            $table->unsignedBigInteger('contact_id')->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escalation_conditions_contacts');
    }
};
