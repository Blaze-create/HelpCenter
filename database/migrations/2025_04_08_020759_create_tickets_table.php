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
            $table->string('samaccountname');
            $table->timestamps();
            $table->string('title');
            $table->text('description');
            $table->string('attachment')->nullable();
            
            $table->string('assigned_to')->default('unassigned');
            $table->string('priority')->default('unassigned');
            $table->string('category')->default('unassigned');
            $table->string('resolved_at')->nullable();
            $table->text('notes')->nullable();

            $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');
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
