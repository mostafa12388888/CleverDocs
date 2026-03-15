<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();//
            $table->foreignId('contact_id')->references('id')->on('contacts')->cascadeOnDelete();//
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');//
            $table->string('code')->nullable();
            $table->dateTime('expire_at')->nullable();
            $table->boolean('active');//
            $table->integer('acount_code')->uniqid();//

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
