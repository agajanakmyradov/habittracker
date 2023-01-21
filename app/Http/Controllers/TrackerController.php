<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tracker;
use App\Models\Post;
use App\Models\Process;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\TrackerStoreRequest;
use Auth;

class TrackerController extends Controller
{  
    public function __construct()
    {
        $this->middleware('auth');
    }
    
   public function index($id)
   {   
       $processes = Process::where('tracker_id', $id)
                           ->where('date', '<=', date('Y-m-d'))
                           ->select('date', 'done')
                           ->get();

       $nextProcess = Process::where('tracker_id', $id)
                                    ->where('date', '>=', date('Y-m-d'))
                                    ->where('done', false)
                                    ->first();
        $tracker =  Tracker::find($id);

       //dd($nextMark);

        return view('tracker.index', compact('processes', 'nextProcess', 'tracker'));
   }

   public function create()
   {
       return view('tracker.create');
   }

    public function store(TrackerStoreRequest $request)
    {
        $tracker = new Tracker;
        $tracker->title = $request->input('title');
        $tracker->period_type = $request->input('period_type');
        $tracker->last_day = Carbon::createFromFormat('m/d/Y', $request->input('last_day'))->format('Y-m-d');
        $tracker->user_id = Auth::id();
        
        if ($tracker->period_type == 'days') {
            $tracker->period = $request->input('days');
        } elseif ($tracker->period_type == 'everyday') {
            $tracker->period = 0;
        } else {
            $days = '';

            foreach ($request->input('weekday') as $weekday) {
                $days = $days . $weekday . ',';
            }

            $tracker->period = $days;
        }

        $tracker->save();

        $this->createPlan($tracker);

        return redirect()->route('tracker.show', ['id' => $tracker->id]);
    }


    public function createPlan($tracker)
    {   
        $seconds = 86400;
        $date = explode('-', $tracker->last_day);
        $dayInSeconds = time();
        $lastDayInSeconds = mktime(0, 0, 0, $date[1], $date[2], $date[0]);  

        if ($tracker->period_type == 'weekdays') {
            $week = explode(',', $tracker->period);
            
            while($dayInSeconds <= $lastDayInSeconds) {
                if (in_array(date('w', $dayInSeconds), $week)) {
                    $process = new Process;
                    $process->tracker_id = $tracker->id;
                    $process->done = false;
                    $process->date = date('Y-m-d', $dayInSeconds);
                    $process->save();
                }

                $dayInSeconds = $dayInSeconds + $seconds;
            }
        } else {
            while($dayInSeconds <= $lastDayInSeconds) {
                $process = new Process;
                $process->tracker_id = $tracker->id;
                $process->done = false;
                $process->date = date('Y-m-d', $dayInSeconds);
                $process->save();

                $dayInSeconds = $seconds * (1 + $tracker->period) + $dayInSeconds ;
            }
        }
    }

    public function delete($id)
    {
        Tracker::find($id)->delete();

        return redirect()->route('home');
    }

}
