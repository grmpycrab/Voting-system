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
        Schema::create('candidate_votes', function (Blueprint $table) {
            $table->id('candidate_vote_id');
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade'); // Ensure this is unsignedBigInteger
            $table->foreignId('election_id')->constrained('elections')->onDelete('cascade');   // Ensure this is unsignedBigInteger
            $table->integer('vote_count')->default(0);
            $table->timestamps();
        });        
        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_votes');
    }
};
