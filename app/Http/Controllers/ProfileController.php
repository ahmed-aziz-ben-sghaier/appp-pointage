<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index(){
        $current_userid = Auth::id();
        $userinfo=User::where('id', $current_userid)->first();
        $userprofile=Profile::where('user_id', $current_userid)->first();

        return view('profile.index',compact('userprofile','userinfo'));

    }
    public function updateinfo(Request $request){
        $newmobile = $request['updmobile'];
        $newaddress = $request['updaddress'];
        $newstatus = $request['status'];
        $newcompany = $request['upcompany'];
        $newmobile = $request['updmobile'];
        $newposition = $request['updposition'];
        $userid =$request['userid'];

         $userinfo = Profile::find($userid);

    if (!$userinfo) {
        $userinfo = new Profile();
        $userinfo->user_id = $userid;
    }
        $userinfo->mobile=$newmobile;
        $userinfo->address=$newaddress;
        $userinfo->status=$newstatus;
        $userinfo->company=$newcompany;
        $userinfo->position=$newposition;
        $userinfo->save();
        return redirect('profile/index');







    }
}
