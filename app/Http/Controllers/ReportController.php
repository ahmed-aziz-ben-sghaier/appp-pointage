<?php

namespace App\Http\Controllers;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function submit(Request $request)
    {
        
        $request->validate([
            'content' => 'required|string',
        ]);


        $report = new Report();
        $report->content = $request->input('content');
        $report->user_id = auth()->user()->id;
        $report->save();
        return redirect()->back()->with('success', 'Report added successfully!');
    }
}
