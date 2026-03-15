<?php

use App\Enum\Form\PrivateInBoxStatusEnum;
use App\Enum\Form\PrivateInBoxTypeEnum;
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
        Schema::create('private_in_boxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('from_contact_id')->nullable()->references('id')->on('contacts')->onDelete('cascade');
            $table->longText('message');
            $table->integer('typeId');
            $table->enum('type',[PrivateInBoxTypeEnum::getLocalConstants()])->default(PrivateInBoxTypeEnum::SUBMISSION);
            $table->enum('status',[PrivateInBoxStatusEnum::getLocalConstants()])->default(PrivateInBoxStatusEnum::UN_READ);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_in_boxes');
    }
};
