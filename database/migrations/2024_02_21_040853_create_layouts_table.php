<?php

use App\Enum\Form\LayoutStatusEnum;
use App\Enum\Form\LayoutTypeEnum;
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
        Schema::create('layouts', function (Blueprint $table) {
            $table->id();
            $table->text('subject');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->enum('status', [LayoutStatusEnum::getLocalConstants()])->default('active');
            $table->enum('type', [LayoutTypeEnum::getLocalConstants()]);
            $table->foreignId("created_by")->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger("updated_by");//
            $table->unsignedBigInteger("deleted_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layouts');
    }
};
