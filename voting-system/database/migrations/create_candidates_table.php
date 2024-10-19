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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id('candidate_id'); // This automatically creates an unsignedBigInteger type
            $table->string('candidate_name');
            $table->text('platform');
            $table->string('profile_picture')->nullable();
            $table->integer('total_votes')->default(0);
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('election_id')->constrained('elections')->onDelete('cascade');
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
