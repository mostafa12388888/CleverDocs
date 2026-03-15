<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Fetch all table names from the database
        $tables = $this->_getTableNames();
        foreach ($tables as $table) {
            // Check if the table has 'created_at' and 'updated_at' columns
            if (Schema::hasColumn($table, 'created_at') && Schema::hasColumn($table, 'updated_at')) {
                Schema::table($table, function (Blueprint $table) {
                    // Modify the 'created_at' and 'updated_at' columns
                    $table->timestamp('created_at')->useCurrent()->change();
                    $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->change();
                });
            }
        }
    }

    /**
     * @return void
     */
    public function down(): void
    {
        // Fetch all table names from the database
        $tables = $this->_getTableNames();

        foreach ($tables as $table) {
            // Check if the table has 'created_at' and 'updated_at' columns
            if (Schema::hasColumn($table, 'created_at') && Schema::hasColumn($table, 'updated_at')) {
                Schema::table($table, function (Blueprint $table) {
                    // Reverse the 'created_at' and 'updated_at' changes
                    $table->timestamp('created_at')->nullable(false)->change();
                    $table->timestamp('updated_at')->nullable(false)->change();
                });
            }
        }
    }


    private function _getTableNames(): array
    {
        $databaseName = env('DB_DATABASE');
        $query = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$databaseName' AND table_type = 'BASE TABLE'";
        $tables = DB::select($query);

        return array_map(function ($table) {
            return $table->table_name ?? $table->TABLE_NAME ?? null;
        }, $tables);
    }
};
