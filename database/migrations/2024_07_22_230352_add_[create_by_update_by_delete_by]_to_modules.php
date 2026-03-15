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
        Schema::table('modules', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->references("id")->on("users")->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->references("id")->on("users")->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->references("id")->on("users")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropForeign('created_by')->nullable();;
            $table->dropForeign('deleted_by')->nullable();;
            $table->dropForeign('updated_by')->nullable();;
            $table->dropColumn('created_by')->nullable();;
            $table->dropColumn('deleted_by')->nullable();;
            $table->dropColumn('updated_by')->nullable();;
        });
    }
};
