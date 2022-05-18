<?php

namespace App\Http\Controllers;

use App\Models\Dispatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use function Composer\Autoload\includeFile;
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
            return response()->json('Done', 201);
        }
        elseif ($dispatch['user_id'] != Auth::user()['id'] && !$dispatch['ended_at']){
            Gate::authorize('create', $dispatch);
            $dispatch->update([
                'ended_at' => Carbon::now()
            ]);
            $newDispatch = Dispatch::create([
                'user_id' => Auth::user()['id'],
                'started_at' => Carbon::now()
            ]);
            return response()->json('Done', 201);
        }
        else {
            $newDispatch = Dispatch::create([
                'user_id' => Auth::user()['id'],
                'started_at' => Carbon::now()
            ]);
            return response()->json('Done', 201);
        }
    }

    public function currentDispatchUser()
    {
        $dispatch = Dispatch::orderBy('id', 'desc')->first();
        if (!$dispatch['ended_at']){
            return response()->json($dispatch->user->load(['grade']));
        }
        else return response()->json(false);
    }
}
