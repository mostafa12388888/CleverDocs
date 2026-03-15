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
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('project_type_id')->nullable()->change();
            $table->unsignedBigInteger('company_id')->nullable()->change();
            $table->unsignedBigInteger('contact_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
$table->unsignedBigInteger('country_id')->change();
            $table->unsignedBigInteger('project_type_id')->change();
            $table->unsignedBigInteger('company_id')->change();
            $table->unsignedBigInteger('contact_id')->change();
        });
    }
};
