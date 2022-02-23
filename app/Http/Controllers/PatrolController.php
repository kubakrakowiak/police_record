<?php

namespace App\Http\Controllers;

use App\Models\Patrol;
use Illuminate\Http\Request;

class PatrolController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatrols()
    {
        $patrols = Patrol::all();
        foreach ($patrols as $patrol){
            $patrol['user'] = [];
        }
        $patrols->load([
            'car'
        ]);
        return response()->json($patrols);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPatrols(Request $request)
    {
        $patrols = $request->units;
        foreach ($patrols as $patrol){
            $ids = [];
            foreach ($patrol['user'] as $user){
                array_push($ids, $user['id']);
            }
            Patrol::findOrFail($patrol['id'])->user()->sync($ids);
        }
        return response()->json("Patrol units synced");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->type){
            $patrol = Patrol::create([
                'name' => $request->name,
                'type' => 1,
            ]);        }
        else{
            $patrol = Patrol::create([
                'name' => 'Patrol',
                'type' => 0,
            ]);
        }
        return response()->json($patrol);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatrolController  $patrolController
     * @return \Illuminate\Http\Response
     */
    public function show(PatrolController $patrolController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatrolController  $patrolController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatrolController $patrolController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatrolController  $patrolController
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $patrol = Patrol::find($id);
        $patrol->delete();
        return response(true, 200);
    }
}
