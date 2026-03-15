<?php

use App\Enum\Form\InputTypeCategoryEnum;
use App\Enum\Form\InputTypeEnum;
use App\Enum\Form\InputTypeOptionEnum;
use App\Models\Form\InputType;
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
        Schema::table('input_types', function (Blueprint $table) {


            $table->text('title')->change();
            $table->enum('type', [InputTypeEnum::getLocalConstants()])->change();
            $table->text("description")->nullable();
            $table->text("help")->nullable();
            $table->enum('options_type', [InputTypeOptionEnum::getLocalConstants()])->nullable();


            $table->foreignId("custom_option_list_id")->nullable()->references("id")->on("custom_option_lists");
            $table->string('entity')->nullable();
            $table->enum('category', [InputTypeCategoryEnum::getLocalConstants()])->change();
            $table->dropColumn('sub_type');
            $table->boolean("is_default")->default(false);
            $table->string('key')->unique();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('input_types',function (Blueprint $table) {

                $table->dropColumn('title');
                $table->dropColumn('deleted_by');
                $table->dropColumn('updated_by');
                $table->dropColumn('created_by');
                $table->dropColumn('key');
                $table->dropColumn('is_default');
                $table->dropColumn('category');
                $table->dropColumn('entity');
                $table->dropColumn('options_type');
                $table->dropColumn('help');
                $table->dropColumn('description');


            }
        );
    }
};
