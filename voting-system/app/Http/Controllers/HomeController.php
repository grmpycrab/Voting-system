<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Dummy data
        $totalElections = 5; // Example total elections
        $totalVoters = 100; // Example total voters
        $ongoingElections = 2; // Example ongoing elections
        $votersParticipated = 45; // Example voters participated

        // Pass dummy data to the view
        return view('home', compact('totalElections', 'totalVoters', 'ongoingElections', 'votersParticipated'));
    }
}
