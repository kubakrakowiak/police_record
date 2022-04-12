<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $job_id = Auth::user()->grade->job->id;
        $grades = Grade::where('job_id', '=', $job_id)->pluck('id');
        $query = User::query()
            ->whereIn('grade_id', $grades)
            ->when($request->input('name'), function (Builder $query, string $name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            });
        //$users = $query->paginate(10);
        if ($request->has('per_page')){
            $users = $query->paginate($request->input('per_page'));
            return response()->json([$users->load([
                'grade'
            ]), $users->total()]);
        }else
        {
            $users = $query->get();
            return response()->json($users->load(
                'grade'
            ));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
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
     * @return JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id)->load([
            'grade.job'
        ]);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
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
        if(Auth::user()->permission){
            return response(User::destroy($id));
        }
        else return response("Error, you don't have required permission", 500);
    }
}
