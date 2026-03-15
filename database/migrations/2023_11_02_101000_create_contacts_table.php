<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('contact_email')->unique();
            $table->foreignId('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->json('position');//
            $table->text('address')->nullable();
            $table->integer('is_key_contact')->default(true);//
            $table->string('phone1');//
            $table->string('phone2')->nullable();//
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
