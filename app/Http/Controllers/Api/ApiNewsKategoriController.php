<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsKategory;

class ApiNewsKategoriController extends Controller
{
    /**
     * Get all users from DB in tabular form
     * @return response json
     */
    public function getNewsKategoriTabular(Request $request) {
        // print_r('test');die();

        $newsKategory = NewsKategory::orderBy('id', 'desc')->get();

        return response()->json($newsKategory);
    }
}
