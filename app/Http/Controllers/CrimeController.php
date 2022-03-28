<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Crime;
use App\Models\Jail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CrimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Crime::query()
            ->withCount('characters')
            ->when($request->input('name'), function (Builder $query, string $name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            });
        if ($request->has('per_page')){
            $results = $query->paginate($request->input('per_page'));
            return response()->json($results);
        }else{
            $results = $query->get();
            return response()->json($results);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'characters' => 'required|array',
            'desc' => 'required',
        ]);
        $fine = $request->input('fine');
        $jail = $request->input('jail');
        foreach ($request->input('characters') as $item) {
            $char = Character::all()->find($item);
            if ($fine > 0){
                $char_money = json_decode($char->accounts);
                $char_money->bank = $char_money->bank - 200;
                $char->update([
                    'accounts' => json_encode($char_money)
                ]);
            }
            else{
                $fine = 0;
            }
            if ($jail > 0){
                Jail::create([
                    'identifier' => $char->identifier,
                    'digit' => $char->digit,
                    'jail_time' => 2160,
                    'timeleft' => 12121212,
                    'executed' => 0
                ]);
            }
            else{
                $jail = 0;
            }
        }
        $newCrime = Crime::create([
            'desc' => $request->input('desc'),
            'fine' => $fine,
            'jail' => $jail,
        ]);
        $newCrime->characters()->sync((array) $request->input('characters'));
        return response()->json('Done', 201);
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
