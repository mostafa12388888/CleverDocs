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
        Schema::table('template_inputs', function (Blueprint $table) {
            $table->renameColumn('is_mondatory', 'is_mandatory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_inputs', function (Blueprint $table) {
            $table->renameColumn('is_mandatory', 'is_mondatory');
        });
    }
};
