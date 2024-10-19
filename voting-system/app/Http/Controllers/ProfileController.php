<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile'); // Ensure this corresponds to the Blade file profile.blade.php in the resources/views directory
    }
}
