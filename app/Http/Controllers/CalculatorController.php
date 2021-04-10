<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController
{

    public function index(){
        return view('index');
    }

    public function calculate(Request $request){
        $interest = (int) $request->input('interest');
        $startingCapital = (int)  $request->input('startingCapital');
        $maxDays = (int)  $request->input('maxDays');
        $interest = (($interest / 100) + 1);

        $outcome = [];
        for($i = 1; $i <= $maxDays; $i++)
        {
            $totalCapital = $startingCapital;
            $startingCapital = $startingCapital * $interest;
            $startingCapital = round($startingCapital);
            $totalCapital = $startingCapital - $totalCapital;

            array_push($outcome, [$i, $startingCapital, $totalCapital]);
        }

        return $outcome;
    }
}
