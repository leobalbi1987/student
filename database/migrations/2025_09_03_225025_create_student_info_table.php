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
        Schema::create('student_info', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('roll')->unique();
            $table->string('class', 10);
            $table->string('city', 50);
            $table->string('pcontact', 15);
            $table->string('photo', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_info');
    }
};
