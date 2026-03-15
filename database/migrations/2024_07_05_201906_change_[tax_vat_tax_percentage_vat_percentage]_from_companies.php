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
        Schema::table('companies', function (Blueprint $table) {
            $table->double('vat')->nullable()->change();
            $table->double('tax')->nullable()->change();
            $table->double('vat_percentage')->nullable()->change();
            $table->double('tax_percentage')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->double('vat')->change();
            $table->double('tax')->change();
            $table->double('vat_percentage')->change();
            $table->double('tax_percentage')->change();
        });
    }
};
