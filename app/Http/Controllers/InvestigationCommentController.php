<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\InvestigationComment;
use App\Models\UserLicense;
use App\Models\UserLicenseLogs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InvestigationCommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $comment = InvestigationComment::create([
            'content' => $request->input('content'),
            'investigation_id' => $request->input('investigationId'),
            'user_id' => Auth::user()['id'],
        ]);

        return response()->json('Done', 200);
    }
}
