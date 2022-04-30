<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->load([
            'grade'
        ]);
        return Grade::where('job_id', '=', $user->grade->job_id)->orderBy('order')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request)
    {
        if (Auth::user()->permission > 0){
            foreach ($request->data as $key=>$value){
                Grade::find($value['id'])->update([
                    'order' => $key
                ]);
            }
        }
        return response('done', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(Grade::find($id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->permission > 0) return response(Grade::find($id)->delete());
        else return response('not authorized',500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->permission > 0) {
            Grade::find($id)->update([
                'name' => $request->input('data')['name'],
            ]);
            return response('done', 200);
        }else return response('not authorized',500);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Auth::user()->permission > 0) {
            Grade::create([
                'name' => $request->input('data')['name'],
                'order' => Grade::where('job_id', '=', Auth::user()->grade->job_id)->orderBy('order', 'DESC')->first()->order + 1,
                'abilities' => 0,
                'job_id' => 1,
            ]);
            return response('done', 200);
        }else return response('not authorized',500);
    }
}
