<?php

namespace App\Http\Controllers;

use App\Models\Crime;
use App\Models\Investigation;
use App\Models\Wanted;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $investigations = Investigation::where('type', '=', 1)->count();
        $wanted = Wanted::all()->count();
        $crimes = Crime::where('created_at', '>',Carbon::parse('-24 hours'))->count();
        return response()->json([$investigations, $wanted, $crimes]);
    }
}
