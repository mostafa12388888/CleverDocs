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
        Schema::create('contact_distribution_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->references("id")->on("contacts")->cascadeOnDelete();
            $table->foreignId('distribution_list_id')->references("id")->on("distribution_lists")->cascadeOnDelete();
            $table->foreignId("action_id")->references("id")->on("custom_option_lists")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_distribution_lists');
    }
};
