<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DelayRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ListeP;
use App\Models\Report;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\APP;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;


class AdminController extends Controller
{
    public function dashboard()
    {

    $totalUsers = User::count();

    $presenceData = ListeP::selectRaw('DATE(time) as date, COUNT(*) as count')
    ->where('status', 'present')
    ->where('time', '>', Carbon::now()->subDays(7))
    ->groupBy('date')
    ->get();


     $dates = $presenceData->pluck('date')->map(function ($date) {
        return Carbon::parse($date)->format('M d');
    });
    $counts = $presenceData->pluck('count');

    $delayData = DelayRequest::selectRaw('DATE(created_at) as date, COUNT(*) as count')
    ->where('created_at', '>', Carbon::now()->subDays(7))
    ->groupBy('date')
    ->get();


$delayDates = $delayData->pluck('date')->map(function ($date) {
    return Carbon::parse($date)->format('M d');
});
$delayCounts = $delayData->pluck('count');

$usersPerformance = User::all()->map(function ($user) {
    $userPresence = ListeP::where('user_id', $user->id)->where('status', 'present')->count();
    $userDelays = DelayRequest::where('user_id', $user->id)->count();
    if ($userPresence + $userDelays != 0) {
        $userPerformance = $userPresence / ($userPresence + $userDelays) * 100;
    } else {
        $userPerformance = 0;
    }

    return ['user' => $user->name, 'performance' => $userPerformance];




});

$allUsersWithRoles = User::with('roles')->get();

$allUsersWithRoles = User::with('delayRequests')->get();
$allUsersWithRoles = User::with(['roles', 'listePAdditions'])->get();



 $absenceData = ListeP::where('action', 'out')
 ->where('time', '>', Carbon::now()->subDays(7))
 ->get();


$absentUsers = User::whereNotIn('id', $absenceData->pluck('user_id'))
 ->get();

 $seance1 = [];
 $seance2 = [];
 $currentTime = Carbon::now();

 foreach ($absentUsers as $user) {

     $currentHour = $currentTime->hour;


     if ($currentHour >= 8 && $currentHour < 13) {
         $seance1[] = [
             'user' => $user,
             'date' => Carbon::now()->toDateString(),
             'seance' => 'Séance 1 (8:00 - 12:00)'
         ];
     } elseif ($currentHour >= 13 && $currentHour < 18) {
         $seance2[] = [
             'user' => $user,
             'date' => Carbon::now()->toDateString(),
             'seance' => 'Séance 2 (13:00 - 17:00)'
         ];
     }
 }


return view('admin.dashboard', compact('totalUsers', 'dates', 'counts', 'delayDates', 'delayCounts', 'usersPerformance', 'allUsersWithRoles','seance1', 'seance2'));

    }


    public function presence()
    {


        return view('admin.presence');
    }

    public function submitPresenceForm(Request $request){
        try {
            $validatedData = $request->validate([
                'actionRadio' => 'required|in:in,out',
                'time' => 'required|date_format:Y-m-d\TH:i',
            ]);




            $listeP = new ListeP([
                'user_id' => auth()->user()->id,
                'action' => $validatedData['actionRadio'],
                'status' => 'present',
                'time' => $validatedData['time'],
            ]);

            $listeP->save();

            return redirect()->back()->with('success', 'Votre présence a été enregistrée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()->back()->withErrors($e->errors())->withInput();
        }

    }

    public function absenceRequests()
    {
       $delayRequests = DelayRequest::all();

       return view('admin.absence_requests', ['delayRequests' => $delayRequests]);
    }



    public function reports()
    {
        $listePData = ListeP::all();


        /*return view('admin.reports', ['listePData' => $listePData]);*/


        $reportsData = Report::all();

        return view('admin.reports', compact('listePData', 'reportsData'));





    }


    public function searchReports(Request $request)
{
    try {
        $searchQuery = $request->input('user_id');



        $originalData = ListeP::all();


        $filteredData = $originalData->where('user_id', $searchQuery);

        return view('admin.reports', ['listePData' => $filteredData]);
    } catch (\Exception $e) {
        Log::error('Error searching reports: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while searching reports.');
    }
}

public function search(Request $request)
{
    $searchUserId = $request->input('user_id');
    $searchDate = $request->input('search_date');


    $query = ListeP::query();
    if ($searchUserId) {
        $query->where('user_id', $searchUserId);
    }
    if ($searchDate) {
        $query->whereDate('time', $searchDate);
    }

    $listePData = $query->get();

    return view('admin.reports', compact('listePData'));
}






public function addUserToListeP($userId) {


    DB::beginTransaction();

    try {

        ListeP::create([
            'user_id' => $userId,
            'action' => 'in',
            'status' => 'present',
            'time' => now()->format('Y-m-d H:i:s'),
        ]);

        DelayRequest::where('user_id', $userId)->delete();

        DB::commit();

        return redirect()->route('admin.reports')->with('success', 'L\'utilisateur a été ajouté avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->route('admin.reports')->with('error', 'Une erreur s\'est produite lors de l\'ajout de l\'utilisateur à la liste_p.');
    }


}

public function removeDelayRequest($id)
    {
        try {
            $delayRequest = DelayRequest::findOrFail($id);

            $delayRequest->delete();

            return redirect()->route('admin.absence.requests')->with('success', 'La demande de retard a été supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.absence.requests')->with('error', 'Une erreur s\'est produite lors de la suppression de la demande de retard.');
        }
    }

    public function confirmRoles(Request $request)
{
    $userRoles = $request->input('user_roles');

    foreach ($userRoles as $userId => $roles) {
        $user = User::findOrFail($userId);
        $isAdmin = 0;

        if (in_array('admin', explode(',', $roles))) {
            $isAdmin = 1;
        } elseif (in_array('super_manager', explode(',', $roles))) {
            $isAdmin = 2;
        } elseif (in_array('manager', explode(',', $roles))) {
            $isAdmin = 3;
        }
        $user->is_admin = $isAdmin;
        $user->save();
    }

    $redirectRoute = $this->getRedirectRoute($userRoles);
    return redirect()->route($redirectRoute)->with('success', 'Roles confirmed successfully.');
}

private function getRedirectRoute($userRoles)
{

    if (in_array('admin', $userRoles)) {
        return 'admin.dashboard';
    } elseif (in_array('super-manager', $userRoles)) {
        return 'super.manager.dashboard';
    } elseif (in_array('manager', $userRoles)) {
        return 'admin.reports';
    } else {
        return 'home';
    }
}




























}
