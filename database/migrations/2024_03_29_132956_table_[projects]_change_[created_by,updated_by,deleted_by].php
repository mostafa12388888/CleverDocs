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
            $table->foreignId("created_by")->change()->nullable()->references("id")->on("users")->cascadeOnDelete();
            $table->foreignId('updated_by')->change()->nullable()->references("id")->on("users")->cascadeOnDelete();;
            $table->foreignId('deleted_by')->nullable()->references("id")->on("users")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'projects',
            function (Blueprint $table) {
                $table->dropForeign('deleted_by');
                $table->dropColumn('deleted_by');
                $table->string("created_by")->change();
                $table->string('updated_by')->change();
            }
        );
    }
};
