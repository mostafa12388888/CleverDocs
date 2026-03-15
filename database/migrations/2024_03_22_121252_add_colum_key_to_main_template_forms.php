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
            $table->string('key')->unique()->nullable();
            $table->boolean("is_default")->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_template_forms', function (Blueprint $table) {
            //
        });
    }
};
