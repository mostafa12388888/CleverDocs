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
        Schema::table('main_template_forms', function (Blueprint $table) {
            $table->foreignId('created_by')->change()->references('id')->on("users")->cascadeOnDelete();
            $table->foreignId('updated_by')->references('id')->on("users")->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->change()->references('id')->on("users")->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->references('id')->on('modules');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_template_forms', function (Blueprint $table) {
            $table->dropForeign('module_id');
            $table->dropColumn('module_id');
            $table->dropForeign('updated_by');
            $table->dropColumn('updated_by');
            $table->string('created_by')->change();
            $table->string('deleted_by')->change();
            $table->dropColumn('name');
        });
    }
};
