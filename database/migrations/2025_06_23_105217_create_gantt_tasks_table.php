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
            Schema::create('gantt_tasks', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('parent_id')->nullable();
        $table->integer('number')->nullable();
        $table->string('text')->nullable();
        $table->date('start_date')->nullable();
        $table->integer('duration')->default(1);
        $table->string('reference')->nullable();
        $table->integer('quantity')->nullable();
        $table->string('uom')->nullable();
        $table->decimal('unit_price', 10, 2)->nullable();
        $table->decimal('total_price', 12, 2)->nullable();
        $table->timestamps();
    });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gantt_tasks');
    }
};
