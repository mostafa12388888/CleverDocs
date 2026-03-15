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
        Schema::table('custom_option_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->change()->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_option_lists', function (Blueprint $table) {
            $table->dropColumn('created_by')->nullable();;
            $table->dropColumn('deleted_by')->nullable();;
            $table->dropColumn('updated_by')->nullable();;
        });
    }
};
