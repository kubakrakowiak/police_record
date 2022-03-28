<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Investigation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Investigation::query()
            ->when($request->input('name'), function (Builder $query, string $name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            })
            ->when($request->input('type') == '0' or $request->input('type') == '1', function (Builder $query, string $type) use ($request) {
                $query->where('type', '=', intval($request->input('type')));
            });//todo
        if ($request->has('per_page')){
            $results = $query->paginate($request->input('per_page'));
        }else{
            $results = $query->get();
        }
        return response()->json($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $newInvestigation = Investigation::create([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'created_by' => $userId,
            'type' => $request->input('type'),
        ]);
        if($request->input('type') == 0){
            $newInvestigation->closed_at = Carbon::now();
        }
        $newInvestigation->users()->sync((array) $request->input('policemans'));
        $newInvestigation->save();
        return response()->json($newInvestigation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Investigation::all()->find($id)->load([
            'users',
            'creator'
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function close(Request $request)
    {
        $inv = Investigation::all()->find($request->id);
        if($inv->type == 1 && $inv->created_by == Auth::user()->id){
            $inv->update([
                'closed_at' => Carbon::now(),
                'type' => 0,
            ]);
            return response()->json($inv);
        }
        else return response()->json("Can't close investigation. Check that you are creator", 500);

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
