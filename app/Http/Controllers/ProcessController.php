<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Process;

class ProcessController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update($id)
    {   
        $process = Process::find($id);
        $process->done = true;
        $process->save();

        return redirect()->route('tracker.show', ['id' => $process->tracker_id]);
    }
}
