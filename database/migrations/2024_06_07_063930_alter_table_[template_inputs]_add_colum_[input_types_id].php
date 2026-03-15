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
            $table->foreignId('input_types_id')->constrained()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_inputs', function (Blueprint $table) {
            $table->dropForeign(['input_types_id']);
            $table->dropColumn('input_types_id');
        });
    }
};
