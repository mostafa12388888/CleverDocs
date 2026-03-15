<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //DB::statement('SET SESSION sql_require_primary_key=1');

        Schema::create('oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('client_id');
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });

         //DB::statement('SET SESSION sql_require_primary_key=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oauth_auth_codes');
    }
};
