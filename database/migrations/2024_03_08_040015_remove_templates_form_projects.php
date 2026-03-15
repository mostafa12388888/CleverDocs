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
        Schema::table('templates_form_projects', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign('templates_form_projects_module_id_foreign');

            // Drop the column
            $table->dropColumn('module_id');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates_form_projects', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->references('id')->on('modules');
        });
    }
};
