<?php

namespace App\Http\Controllers;

use App\Models\Dispatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class DispatchController extends Controller
{
    public function getDispatch()
    {
        $dispatch = Dispatch::orderBy('id', 'desc')->first();
        if ($dispatch['ended_at']){
            return response()->json(0);
        }
        elseif ($dispatch['user_id'] == Auth::user()['id']){
            return response()->json(1);
        }
        else{
            return response()->json(2);
        }
    }

    public function setDispatch()
    {
        $dispatch = Dispatch::orderBy('id', 'desc')->first();
        if ($dispatch['user_id'] == Auth::user()['id'] && !$dispatch['ended_at']) {
            $dispatch->update([
                'ended_at' => Carbon::now(),
            ]);
            return response()->json('Done', 200);
        }
        elseif ($dispatch['user_id'] != Auth::user()['id'] && !$dispatch['ended_at']) {
            $dispatch->update([
                'ended_at' => Carbon::now()
            ]);
            $newDispatch = Dispatch::create([
                'user_id' => Auth::user()['id'],
                'started_at' => Carbon::now()
            ]);
            return response()->json('Done', 200);
        }
        else {
            $newDispatch = Dispatch::create([
                'user_id' => Auth::user()['id'],
                'started_at' => Carbon::now()
            ]);
            return response()->json('Done', 200);
        }
    }

    public function currentDispatchUser()
    {
        $dispatch = Dispatch::orderBy('id', 'desc')->first();
        if (!$dispatch['ended_at']){
            return response()->json($dispatch->user);
        }
        else return response()->json(false);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
