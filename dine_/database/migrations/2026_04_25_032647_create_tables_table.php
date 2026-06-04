<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number')->unique();
            $table->unsignedInteger('capacity');
            $table->enum('status', ['available', 'occupied', 'ready_for_service', 'pending_payment'])->default('available');
            $table->uuid('qr_token')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
