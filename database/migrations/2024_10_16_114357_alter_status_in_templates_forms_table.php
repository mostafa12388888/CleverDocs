<?php


use App\Enum\Enum;
use App\Enum\Form\FormStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterStatusInTemplatesFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws ReflectionException
     */
    public function up()
    {

        Schema::table('templates_forms', function (Blueprint $table) {

            if (!Schema::hasColumn('templates_forms', 'status')) {
                $table->enum('status', array_values(FormStatusEnum::getLocalConstants()))->default(FormStatusEnum::ACTIVE);
            }
            else{
                $statuses = "'" . implode("', '", array_values(FormStatusEnum::getLocalConstants())) . "'";
                DB::statement("ALTER TABLE templates_forms MODIFY COLUMN status ENUM({$statuses})  NOT NULL;");            }


        });


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
