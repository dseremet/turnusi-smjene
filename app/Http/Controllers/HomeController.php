<?php

namespace App\Http\Controllers;

use App\Models\WorkingTime;
use App\Services\ShiftService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $user = Auth::user();
        $workingTimes = WorkingTime::where('user_id', $user->id)->count();
        if (!$workingTimes) {
            return redirect()->route('smjena.postavke');
        }
        $public = false;
        return view('home', compact('user', 'public'));
    }

    public function smjenaPostavke()
    {
        $times = (new ShiftService())->timeList();

        return view('shift_settings', compact('times'));
    }

    public function postSmjenaPostavke(Request $request)
    {
        $this->validate($request, [
            'pocetak' => 'required',
            'vrijeme' => 'required'
        ]);

        $datetime = Carbon::createFromTimestamp(strtotime($request->input('pocetak')));
        $hour = date('i', $request->input('vrijeme'));
        $minute = date('', $request->input('vrijeme'));
        $datetime->setTime($hour, $minute, 0);
        $deleteOnlyAfterDate = $request->input('smjene') == "2";

        $saved = (new ShiftService())->setShifts($datetime, $deleteOnlyAfterDate);
        if ($saved) {
            return redirect()->route('home')->with('message', 'Smjene spasene');
        }
        return redirect()->back()->with('message', 'Greska u spasavanju smjena');

    }


    public function smjeneApi(Request $request)
    {
        $workingTimes = (new ShiftService())->getWorkingTimes(Auth::id());

        return \Response::json($workingTimes);
    }
}
