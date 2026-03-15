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
        Schema::create('distribution_lists', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->boolean('is_active')->default(true);
            $table->string('created_by');
            $table->string('deleted_by')->nullable();
            $table->foreignId('contact_id')->references('id')->on('contacts');
            $table->foreignId('action_id')->references('id')->on('custom_option_lists');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_lists');
    }
};
