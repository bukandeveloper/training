<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class ApiAdminsController extends Controller {

    /**
     * Return the contents of Admin table in tabular form
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function getAdminsTabular() {
        $adminsTabular = array();
        $admins = Admin::orderBy('id', 'desc')->get();
        $i = 0;
        foreach ($admins as $admin) {
            $tabularData = new Admin();
            $tabularData->id = $admin->id;
            $tabularData->display_name = $admin->display_name;
            $tabularData->email = $admin->email;
            $tabularData->password = $admin->password;
            $tabularData->created_at = $admin->created_at;
            $tabularData->updated_at = $admin->updated_at;
            // To make 'delete button' works with csrf_field(), need to comment out VerifyCsrfToken in app/kernel.php
            // After that token can be parsed via ajax
            $tabularData->action = '<form id="form-delete-' . $i . '" action="' . url('/admin/admins/'.$admin->id) . '" method="POST">' .
                csrf_field() .
	            '<input type="hidden" name="_method" value="DELETE">' .
                '<a class="btn btn-primary" href="' . url('/admin/admins/' . $admin->id) . '/edit" title="編集"><i class="fa fa-edit"></i></a>' .
                '&nbsp;&nbsp;' .
                '<input type="hidden" name="id" value="' . $admin->id . '">' .
                '<input type="hidden" name="delete_flag" value="1">' .
                    '<span onclick="javascript:if(confirm(\'Are you sure to delete this data ?\')) { document.getElementById(\'form-delete-' . $i . '\').submit(); } return false;" class="btn btn-warning btn-delete" title="削除"><i class="fa fa-trash"></i></span>' .
                '</form>';
            array_push($adminsTabular, $tabularData);
            $i++;
        }
        return response()->json($adminsTabular);
    }

}
