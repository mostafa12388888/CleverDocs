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
        Schema::table('workflows', function (Blueprint $table) {
            $table->foreignId('deleted_by')->nullable()->references('id')->on('users')->cascadeOnDelete();
        });
        Schema::table('main_workflows', function (Blueprint $table) {
            $table->unsignedBigInteger('deleted_by')->nullable()->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workflows', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
        Schema::table('main_workflows', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
    }
};
