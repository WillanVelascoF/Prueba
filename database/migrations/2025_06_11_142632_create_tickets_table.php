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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_provider_id');
            $table->unsignedBigInteger('assigned_provider_id')->nullable();
            $table->string('title');
            $table->unsignedBigInteger('type_id');
            $table->text('description');
            $table->string('status')->default('open'); // Ej: open, in_progress, closed
            $table->text('solution')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('creator_provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_provider_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('ticket_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
