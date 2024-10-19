<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;
use Illuminate\Support\Facades\Log;

class ElectionController extends Controller
{
    public function index(Request $request)
    {
        // Get the limit for pagination
        $limit = $request->input('limit', 10);
        $elections = Election::paginate($limit);

        return view('elections.index', compact('elections'));
    }

    public function store(Request $request)
    {
        try {
            // Validate election details
            $validatedData = $request->validate([
                'election_name' => 'required|string|max:255',
                'description' => 'required|string',
                'election_type' => 'required|string|in:Faculty,Program,General',
                'restriction' => 'nullable|string',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'election_status' => 'required|string|in:upcoming,ongoing,completed', // Correct field
            ]);

            Election::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Election added successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error creating election: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error adding election: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        // Retrieve the election by ID
        $election = Election::findOrFail($id);
        
        // Pass the election to the edit view
        return view('elections.edit', compact('election'));
    }

    public function update(Request $request, $id)
    {
        $election = Election::findOrFail($id);
    
        // Validate the request including the description
        $validatedData = $request->validate([
            'election_name' => 'required|string|max:255',
            'description' => 'required|string',
            'election_type' => 'required|string|in:Faculty,Program,General',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'restriction' => 'nullable|string',
            'status' => 'required|string|in:upcoming,ongoing,completed',
        ]);
    
        // Update the election with the validated data
        $election->update($validatedData);
    
        return response()->json(['success' => true, 'message' => 'Election updated successfully!']);
    }

    public function destroy($id)
    {
        $election = Election::findOrFail($id);
        $election->delete();

        return response()->json(['success' => true, 'message' => 'Election deleted successfully!']);
    }
}
