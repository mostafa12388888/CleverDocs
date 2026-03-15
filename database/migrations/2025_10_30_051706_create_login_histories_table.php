<?php

use App\Enum\Authorization\StatusLoginHistoryEnum;
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
        Schema::create('login_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('token_id')->nullable()->references('id')->on('oauth_access_tokens')->cascadeOnDelete()->change();
            $table->string('ip')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('location')->nullable();
            $table->string('device')->nullable();
            $table->enum('status', [StatusLoginHistoryEnum::getLocalConstants()])->default(StatusLoginHistoryEnum::ACTIVE);
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('logged_out_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};
