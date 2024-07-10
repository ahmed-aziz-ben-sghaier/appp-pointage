<?php

namespace App\Http\Controllers;
use App\Models\ListeP;

use App\Models\Report;

use Illuminate\Http\Request;

class SupermanagerController extends Controller
{
    public function dashboard()
   {


     $reports = ListeP::whereIn('user_id', [1, 3,4,7,8,9,10,11,12,13])->get();

     return view('super-manager.dashboard', compact('reports'));
    }

    public function search(Request $request)
    {
        $userId = $request->input('user_id');

      $reports = ListeP::where('user_id', $userId)->get();

        return view('super-manager.dashboard', compact('reports'));
    }

    public function searchdate(Request $request)
{
    $searchUserId = $request->input('user_id');
    $searchDate = $request->input('search_date');

    $reports = ListeP::whereIn('user_id', [1, 3, 4,7,8,9,10,11,12,13])->get();
    if ($searchDate) {
        $reports = $reports->filter(function ($report) use ($searchDate) {
            $reportDate = date('Y-m-d', strtotime($report->time));
            return $reportDate === $searchDate;
        });
    }
    if ($searchUserId) {
        $reports = $reports->filter(function ($report) use ($searchUserId) {
            return $report->user_id == $searchUserId;
        });
    }




        return view('super-manager.dashboard', compact('reports'));
}


}
