<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;

class ApiNewsController extends Controller
{
    /**
     * Get all users from DB in tabular form
     * @return response json
     */
    public function getNewsTabular(Request $request) {

        $data = News::orderBy('id', 'desc')->get();

        return response()->json($data);
    }
}
