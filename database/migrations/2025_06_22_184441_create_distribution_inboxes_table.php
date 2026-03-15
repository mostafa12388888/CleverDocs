<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Form\PrivateInBoxStatusEnum;
use App\Enum\Form\PrivateInBoxTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distribution_inboxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribution_list_id')->nullable()->references('id')->on('distribution_lists')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->longText('message')->nullable();
            $table->bigInteger('type_id');
            $table->foreignId("priority_id")->references("id")->on("custom_option_lists")->cascadeOnDelete();
            $table->enum('type', [PrivateInBoxTypeEnum::getLocalConstants()])->default(PrivateInBoxTypeEnum::SUBMISSION);
            $table->enum('status', [PrivateInBoxStatusEnum::getLocalConstants()])->default(PrivateInBoxStatusEnum::UN_READ);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_inboxes');
    }
};
