<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkingTime;
use App\Services\ShiftService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{

    public function index(Request $request, $mdId)
    {
        $user = User::where(DB::raw("MD5(`id`)"), $mdId)->first();
        if (!$user) {
            return response('User not found', Response::HTTP_FORBIDDEN);
        }
        $public = true;
        return view('home', compact('public', 'mdId'));
    }


    public function smjeneApi(Request $request, $mdId)
    {
        $user = User::where(DB::raw("MD5(`id`)"), $mdId)->first();
        if (!$user) {
            return response('User not found', Response::HTTP_FORBIDDEN);
        }
        $workingTimes = (new ShiftService())->getWorkingTimes($user->id);

        return \Response::json($workingTimes);
    }
}
