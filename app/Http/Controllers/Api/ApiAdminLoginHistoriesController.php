<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\AdminLoginHistory;

class ApiAdminLoginHistoriesController extends Controller {

    /**
     * Return the contents of admin_login_histories table in tabular form
     * Using offset to get the data from server side not client side
     * To handle huge load of data
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function getAdminLoginHistoriesTabular(Request $request) {
        // Accessing the request
        $dataPerPage = $request->input('size');
        $filters = $request->input('filters');
        $sorters = $request->input('sorters');

        $loginHistories = AdminLoginHistory::query();

        // Setup filters
        if ($filters != null) {
            foreach ($filters as $filter) {
                $field = $filter['field'];
                $type = $filter['type'];
                $value = $filter['value'];

                if($field == 'id'){
                    $loginHistories = $loginHistories->where('admin_login_histories.id','like', '%'.$value.'%');
                }
                else if($field == 'email'){
                    $loginHistories = $loginHistories->where('admin_login_histories.email','like', '%'.$value.'%');
                }
                else if($field == 'login_at'){
                    $loginHistories = $loginHistories->where('admin_login_histories.login_at','like', '%'.$filter['value'].'%');
                }
                else if($field == 'not_exist_user'){
                    $loginHistories = $loginHistories->where('admin_login_histories.not_exist_user','like', '%'.$filter['value'].'%');
                }
                else if($field == 'failed_login_at'){
                    $loginHistories = $loginHistories->where('admin_login_histories.failed_login_at','like', '%'.$filter['value'].'%');
                }
                else if($field == 'ip_address'){
                    $loginHistories = $loginHistories->where('admin_login_histories.ip_address','like', '%'.$filter['value'].'%');
                }
            }
        }

        // Setup sorters
        if ($sorters != null) {
            foreach ($sorters as $sorter) {
                $loginHistories = $loginHistories->orderBy($sorter['field'], $sorter['dir']);
            }
        } else {
            $loginHistories = $loginHistories->orderBy('id', 'desc');
        }

        return response()->json($loginHistories->paginate($dataPerPage));
    }

}
