<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('contact_distribution_lists')
            ->whereNotNull('action_id')
            ->delete();


        Schema::table('contact_distribution_lists', function (Blueprint $table) {
            if (Schema::hasColumn('contact_distribution_lists', 'action_id')) {
                $table->dropForeign(['action_id']);
            }

            $table->foreign('action_id')
                ->references('id')
                ->on('input_options')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_distribution_lists', function (Blueprint $table) {
            $table->dropForeign(['action_id']);
            $table->dropColumn('action_id');
        });
    }
};
