<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->has('per_page')){
            $tariffs = Tariff::paginate($request->input('per_page'));
            return response()->json([$tariffs]);
        }
        return response()->json(Tariff::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Tariff::create([
            'name' => $request['data']['name'],
            'fine' => $request['data']['fine'],
            'jail' => $request['data']['jail'],
        ]);

        return response()->json('done', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Tariff::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $tariff = Tariff::find($id);
        $tariff->update([
            'name' => $request['data']['name'],
            'fine' => $request['data']['fine'],
            'jail' => $request['data']['jail'],
        ]);

        return response()->json('done', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tariff::find($id)->delete();
        return response(200);
    }
}
