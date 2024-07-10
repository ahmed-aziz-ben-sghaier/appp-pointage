<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListeP;
use App\Models\DelayRequest;


class ManagerController extends Controller
{
    public function dashboard()
    {
        /*return view('manager.dashboard');*/

        $reports = ListeP::whereIn('user_id', [1, 4,8,10,11,12,13])->get();

        return view('manager.dashboard', compact('reports'));


    }
    public function search(Request $request)
    {

        $userId = $request->input('user_id');

      $reports = ListeP::where('user_id', $userId)->get();


        return view('manager.dashboard', compact('reports'));
    }

    public function searchdate(Request $request)
    {
        $searchUserId = $request->input('user_id');
        $searchDate = $request->input('search_date');

        $reports = ListeP::whereIn('user_id', [1, 4,8,10,11,12,13])->get();

    // Si une date est spécifiée, filtrer les rapports par cette date
    if ($searchDate) {
        $reports = $reports->filter(function ($report) use ($searchDate) {
            // Convertir la date du rapport en format 'Y-m-d'
            $reportDate = date('Y-m-d', strtotime($report->time));
            // Retourner true si la date du rapport correspond à la date spécifiée
            return $reportDate === $searchDate;
        });
    }

    // Si un utilisateur est spécifié, filtrer les rapports par cet utilisateur
    if ($searchUserId) {
        $reports = $reports->filter(function ($report) use ($searchUserId) {
            // Retourner true si l'ID de l'utilisateur du rapport correspond à l'ID spécifié
            return $report->user_id == $searchUserId;
        });
    }

            return view('manager.dashboard', compact('reports'));
    }



}
