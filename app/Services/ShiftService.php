<?php
/**
 * Created by PhpStorm.
 * User: damirseremet
 * Date: 20/10/2019
 * Time: 17:28
 */

namespace App\Services;


use App\Models\WorkingTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShiftService
{

    public function setShifts(Carbon $datetime, $deleteOnlyAfterDate = false)
    {
//set for next 6 months
        $in6Months = (clone $datetime)->addMonths(6);
        $initialSelectedDate = clone $datetime;

        $workingTimes = [];
        $userId = Auth::id();

        while ($datetime <= $in6Months) {
            $start = clone $datetime;
            $datetime->addHours(12);
//prva smjena
            $workingTimes[] = [
                'user_id' => $userId,
                'shift' => 1,
                'working_from' => $start->toDateTimeString(),
                'working_to' => $datetime->toDateTimeString(),
            ];

            $datetime->addHours(24);
            $start = clone $datetime;
            $datetime->addHours(12);

            $workingTimes[] = [
                'user_id' => $userId,
                'shift' => 2,
                'working_from' => $start->toDateTimeString(),
                'working_to' => $datetime->toDateTimeString(),
            ];

            $datetime->addHours(48);
        }

        if ($deleteOnlyAfterDate) {
            WorkingTime::where('user_id', $userId)->where('working_to', '>=', $initialSelectedDate)->delete();
        }else{
            WorkingTime::where('user_id', $userId)->delete();

        }
        WorkingTime::insert($workingTimes);

        return true;

    }

    public function timeList($start = 300, $end = 1200)
    {
        $times = [];
        $i = $start;
        if ($i && $end) {
            while ($i <= $end) {
                $times[$i] = date('i:s', $i);
                $i += 15;
            }
        }

        return $times;
    }

    public function getWorkingTimes($user_id)
    {
        $workingTimes = WorkingTime::where('user_id', $user_id)->get();
        $workingTimes = $workingTimes->map(function ($workingTime) {
            $title = '';
            $color = '#16E0BD';

            if ($workingTime->shift == 1) {
                $title .= 'Dnevna smjena: ';
            } elseif ($workingTime->shift == 2) {
                $title .= 'Nocna smjena: ';
                $color = '#B76C96';
            }
            $title .= ($workingTime->working_from->format('H:i') . '-' . $workingTime->working_to->format('H:i'));

            return [
                'start' => $workingTime->working_from,
                'end' => $workingTime->working_to,
                'title' => $title,
                'color' => $color
            ];
        });

        return $workingTimes;
    }
}
