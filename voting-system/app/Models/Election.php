<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    // Specify the table if it's not the default 'elections'
    protected $table = 'elections';

    // Define the fillable fields that can be mass-assigned
    protected $fillable = [
        'election_name',
        'description',
        'election_type',
        'restriction',
        'start_date',
        'end_date',
        'election_status',

    ];
    

    // If the start_date and end_date are stored as strings, make sure they're cast to DateTime objects
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
