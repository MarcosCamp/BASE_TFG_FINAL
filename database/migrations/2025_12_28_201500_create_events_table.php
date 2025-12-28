<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
          $table->id();
        $table->string('name');           // Antes era 'title'
        $table->text('description');
        $table->dateTime('event_date');   // Antes era 'date'
        $table->string('location');
        $table->decimal('price', 8, 2);
        $table->integer('capacity');
        $table->string('image')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};