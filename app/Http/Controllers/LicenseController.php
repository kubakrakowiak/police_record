<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\User;
use App\Models\UserLicense;
use App\Models\UserLicenseLogs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = UserLicense::query()
            ->when($request->input('type'), function (Builder $query, string $type) {
                $query->where('type', 'LIKE', '%' . $type . '%');
            })
            ->when($request->input('character'), function (Builder $query, string $character) {
                $query->where('owner', 'LIKE', '%' . json_decode($character)->identifier. '%')
                ->where('digit', 'LIKE', '%' . json_decode($character)->digit. '%');
            });
        if ($request->has('per_page')){
            $results = $query->paginate($request->input('per_page'));
        }else{
            $results = $query->get();
        }
        foreach ($results as $p) {
            $p->char = Character::query()
                ->where('identifier', $p->owner)
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
    public function history(Request $request)
    {
        $query = UserLicenseLogs::query()
            ->when($request->input('type'), function (Builder $query, string $type) {
                $query->where('type', 'LIKE', '%' . $type . '%');
            })
            ->when($request->input('character'), function (Builder $query, string $character) {
                $query->where('owner', 'LIKE', '%' . json_decode($character)->identifier. '%')
                    ->where('digit', 'LIKE', '%' . json_decode($character)->digit. '%');
            });
        if ($request->has('per_page')){
            $results = $query->paginate($request->input('per_page'));
        }else{
            $results = $query->get();
        }
        foreach ($results as $p) {
            $p->char = Character::where('identifier', $p->owner)
                ->where('digit', $p->digit)
                ->first();
            $p->created_format = Carbon::createFromTimestamp($p->created_at)->format('d/m/Y');
            $p->user = User::find($p->user_id);
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
        $type = 'undefined';
        if ($request->form['type']['id'] == 0){
            $type = 'weapon';
        }elseif ($request->form['type']['id'] == 1){
            $type = 'dmv';
        }
        elseif ($request->form['type']['id'] == 2){
            $type = 'drive_bike';
        }
        elseif ($request->form['type']['id'] == 3){
            $type = 'drive';
        }
        elseif ($request->form['type']['id'] == 4){
            $type = 'drive_truck';
        }
        $newLicense = UserLicense::create([
            'type' => $type,
            'digit' => $request->form['character']['digit'],
            'owner' => $request->form['character']['identifier'],
        ]);

        $log = UserLicenseLogs::create([
            'log_type' => 1,
            'type' => $type,
            'digit' => $request->form['character']['digit'],
            'owner' => $request->form['character']['identifier'],
            'user_id' => Auth::user()['id'],
        ]);

        return response()->json($newLicense);
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
