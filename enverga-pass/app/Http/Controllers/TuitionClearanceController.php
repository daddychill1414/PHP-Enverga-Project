<?php

namespace App\Http\Controllers;

use App\Models\TuitionClearance;
use Illuminate\Http\Request;

class TuitionClearanceController extends Controller
{
    public function index()
    {
        return view('clearance.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
        ]);

        $clearance = TuitionClearance::where('student_id', $request->student_id)->first();

        return view('clearance.index', compact('clearance'));
    }
}
