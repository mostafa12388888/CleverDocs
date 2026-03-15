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
        Schema::table('projects', function (Blueprint $table) {
           $table->unsignedBigInteger('project_type_id');
           $table->foreignId('contact_id')->references('id')->on('contacts')->cascadeOnDelete();
           $table->unsignedBigInteger('company_id');
           $table->unsignedBigInteger('country_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('w_b_s', function (Blueprint $table) {
            //
        });
    }
};
