<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracker;

class HomeController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
   {   
       $date = [date('m'), date('Y')]; 

        $month = $this->getMonth($date);
        $month[0] = $this->fillFirstWeek($month[0]);
        //dd($month);

        return view('home', compact('month'));
      
   }

   public function getMonth($date = null)
   {
       $totalDays = (int)(date('t', mktime(0, 0, 0, $date[0], 01, $date[1])));
       $i = 0;
       $w = $this->getFirstWeekDays($date);
       $month = [];

       while($i <= $totalDays) {
           if ($w > $totalDays) {
               $arr = range($i + 1, $totalDays);
           } else {
               $arr = range($i + 1, $w);
           }
           
           $i = $w;
           $w = $i + 7;
           $month[] = $arr; 
       }
      
       return $month;
   }

   public function fillFirstWeek($arr)
   {
       $count = 7 - count($arr);
       $emptyDays = [];

       for ($i=0; $i < $count; $i++) { 
           $emptyDays[] = ''; 
       }

       return array_merge($emptyDays, $arr);
   }

   public function getFirstWeekDays($date)
   {
          $w = 7;
          $w = $w - (int)date('w', mktime(0, 0, 0, $date[0], 01, $date[1])) + 1;

          if($w > 7) {
            $w = 1;
          }

          return $w;
   }
}
