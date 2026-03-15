<?php

use App\Enum\Form\InputTypeEnum;
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
        Schema::table('form_submission_values', function (Blueprint $table) {
            $table->string('input_key')->nullable();
            $table->boolean("is_default")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_submission_values', function (Blueprint $table) {
            $table->dropColumn('input_key');
            $table->dropColumn('is_default');
        });
    }
};
