<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\UserLicense;
use App\Models\UserLicenseLogs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $results = UserLicense::all();
        foreach ($results as $p) {
            $p->char = Character::where('identifier', $p->owner)
                ->where('digit', $p->digit)
                ->first();
        }
        return response()->json($results);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function history()
    {
        $results = UserLicense::all();
        foreach ($results as $p) {
            $p->char = Character::where('identifier', $p->owner)
                ->where('digit', $p->digit)
                ->first();
        }
        return response()->json($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return response()->json($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function revoke(int $id)
    {
        $patrol = UserLicense::find($id);
        $log = UserLicenseLogs::create([
            'log_type' => 0,
            'type' => $patrol->type,
            'owner' => $patrol->owner,
            'digit' => $patrol->digit,
            'grade' => $patrol->grade,
            'user_id' => Auth::user()['id'],
        ]);
        $patrol->delete();

        return response(true, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
