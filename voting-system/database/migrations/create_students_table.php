<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('students', function (Blueprint $table) {
            $table->string('student_id', 10)->primary();
            $table->string('fullname');
            $table->string('school_email')->unique();
            $table->string('faculty');
            $table->string('program');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
