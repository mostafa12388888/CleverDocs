<?php

use App\Enum\Dashboard\ChartTypeEnum;
use App\Enum\Dashboard\CountOrGroupByChartEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Dashboard\SettingEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->boolean('is_private')->default(true);
            $table->foreignId('form_id')->references('id')->on('main_template_forms')->cascadeOnDelete();
            $table->foreignId('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('dashboard_id')->constrained('dashboards')->cascadeOnDelete();
            $table->enum('chart_type', ChartTypeEnum::getLocalConstants());
            $table->enum('count_by',[CountOrGroupByChartEnum::getLocalConstants()]);
            $table->enum('group_by',[CountOrGroupByChartEnum::getLocalConstants()])->nullable();
            $table->text('color_record')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
