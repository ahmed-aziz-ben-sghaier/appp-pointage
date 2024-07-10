<?php

namespace App\Http\Controllers;
use App\Models\DelayRequest;
use App\Models\ListeP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function adminhome()
    {
        return view('admin-home');
    }
    public function markPresence()
    {
        // Logique pour marquer la présence de l'utilisateur
        return view('presence');
    }

   















    public function requestDelay()
    {
        // Logique pour la demande de retard de l'utilisateur
        return view('request_delay');
    }
    public function submitDelayRequest(Request $request)
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'delayDate' => 'required|date',
        'delayTime' => 'required',
        'delayReason' => 'required',
    ]);

    // Création d'une nouvelle instance de DelayRequest avec les données validées
    $delayRequest = new DelayRequest([
        'user_id' => auth()->user()->id,
        'delay_date' => $validatedData['delayDate'],
        'delay_time' => $validatedData['delayTime'],
        'reason' => $validatedData['delayReason'],
        'status' => 'pending',
    ]);

    // Sauvegarde de la demande de retard dans la base de données
    $delayRequest->save();

    // Vous pouvez ajouter des messages de succès ou de redirection ici
    return redirect()->back()->with('success', 'Demande de retard soumise avec succès.');
}







}
