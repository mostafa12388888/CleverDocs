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
        Schema::table('distribution_lists', function (Blueprint $table) {
            $table->dropForeign("distribution_lists_action_id_foreign");
            $table->dropColumn("action_id");
            $table->dropForeign("distribution_lists_contact_id_foreign");
            $table->dropColumn("contact_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distribution_lists', function (Blueprint $table) {
            //
        });
    }
};
