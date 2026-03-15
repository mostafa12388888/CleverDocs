<?php


use App\Enum\Enum;
use App\Enum\Form\InputTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterTypeInInputTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws ReflectionException
     */
    public function up()
    {
        DB::statement("ALTER TABLE input_types CHANGE type type ENUM('" . implode("','", array_values(Enum::getConstants(InputTypeEnum::class))) . "') NOT NULL " . ";");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
