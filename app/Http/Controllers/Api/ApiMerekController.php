<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merek;

class ApiMerekController extends Controller
{
    /**
     * Get all users from DB in tabular form
     * @return response json
     */
    public function getMerekTabular(Request $request) {
        // print_r('test');die();

        $data = Merek::orderBy('id', 'desc')->get();

        return response()->json($data);
    }
}
