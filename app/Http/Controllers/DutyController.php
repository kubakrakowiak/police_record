<?php

namespace App\Http\Controllers;

use App\Models\Duty;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DutyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function getDuty()
    {
        $user = Auth::user()->duty->all();
        if (!$user) {
            return response()->json(false);
        }
        $user = Auth::user()->duty()->latest()->first();
        if (!$user['end_duty']) {
            return response()->json(true);
        }
        else{
            return response()->json(false);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDuty()
    {
        $userDuty = Auth::user()->duty()->latest()->first();
        try {
            if ($userDuty['end_duty'] === null) {
                $duty = Auth::user()->duty()->latest()->first();
                $duty->update([
                    'end_duty' => Carbon::now(),
                ]);
                return response()->json(false);
            }
        } catch (\Throwable $e){
                print $e;
        }
        Duty::create([
            'user_id' => Auth::user()->id,
            'start_duty' => Carbon::now(),
            ]);
        return response()->json(true);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countDuty()
    {
        $q = User::whereHas('grade', function ($q) {
            $q->where('job_id', '=', Auth::user()->grade->job->id);
        })->whereHas('duty', function ($q) {
            $q->where('end_duty', '=', null);
        })->get();
        $q->load([
            'grade',
            'patrol'
        ]);
        return response()->json($q);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
