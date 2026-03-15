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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('email')->uniqid;
            $table->string('logo');
            $table->string('company_filed');
            $table->double('vat');
            $table->double('tax');
            $table->double('vat_percentage');
            $table->double('tax_percentage');
            $table->string('registration');
            $table->string('address')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
