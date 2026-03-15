<?php

use App\Enum\Dashboard\ChartTypeEnum;
use App\Enum\Dashboard\CountOrGroupByChartEnum;
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
        Schema::table('components', function (Blueprint $table) {
            $table->enum('chart_type', ChartTypeEnum::getLocalConstants())->nullable()->change();
            $table->string('count_by')->change();
            $table->string('group_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('components', function (Blueprint $table) {
            $table->enum('chart_type', ChartTypeEnum::getLocalConstants())->nullable(false)->change();
            $table->enum('count_by', [CountOrGroupByChartEnum::getLocalConstants()])->change();
            $table->enum('group_by', [CountOrGroupByChartEnum::getLocalConstants()])->nullable()->change();
        });
    }
};
