<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;

class ApiMembersController extends Controller
{
    /**
     * Get all users from DB in tabular form
     * @return response json
     */
    public function getMembersTabular(Request $request) {
        // print_r('test');die();

        $members = Member::orderBy('id', 'desc')->get();

        return response()->json($members);
    }
}
