<?php

namespace App\Http\Controllers;

use App\Models\DangerLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DangerLevelController extends Controller
{
    public function index()
    {
        $dangerLevel = DangerLevel::query()->latest()->first();
        return response()->json($dangerLevel);
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $dangerLevel = DangerLevel::query()->latest()->first();
        try {
            if ($dangerLevel['end_duty'] === null) {
                $dangerLevel->update([
                    'ended_at' => Carbon::now(),
                ]);
            }
        } catch (\Throwable $e){
            print $e;
        }

        if ($request->input('type') == 0){
            $name = "Green Code";
        }
        elseif ($request->input('type') == 1){
            $name = "Orange Code";
        }
        elseif ($request->input('type') == 2){
            $name = "Red Code";
        }
        else{
            $name = "Black Code";
        }

        $newDangerLevel = DangerLevel::create([
            'user_id' => $userId,
            'started_at' => Carbon::now(),
            'name' => $name,
            'type' => $request->input('type')
        ]);
        return response()->json($newDangerLevel);
    }
}
