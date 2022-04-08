<?php

namespace App\Http\Controllers;

use App\Models\Wanted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WantedController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wanted = Wanted::create([
            'reason' => $request->input('reason'),
            'character_id' => $request->input('characterId'),
            'user_id' => Auth::user()->id
        ]);
        return response($wanted);
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Wanted::find($request->input('id'))->delete();
        return response("Deleted");
    }
}
