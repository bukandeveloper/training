<?php

/*
  |--------------------------------------------------------------------------
  | This config file contains common constants for the whole project
  | For example success / error message for CRUD
  |--------------------------------------------------------------------------
 */

return [
	'FULL_APP_NAME'     => 'Toko Tanaman',
	'SHORT_APP_NAME'    => 'TT',

    // Title suffix
    'TITLE_SUFFIX' => '',

    // Common message
    'SUCCESS_CREATE_MESSAGE' => 'Data berhasil di simpan',        // success when data created
    'FAILED_CREATE_MESSAGE'  => 'Data gagal di simpan', // failed when data created
    'SUCCESS_UPDATE_MESSAGE' => 'Data berhasil di update',        // success when data updated
    'FAILED_UPDATE_MESSAGE'  => 'Data gagal di simpan', // failed when data updated
    'SUCCESS_DELETE_MESSAGE' => 'Data berhasil di hapus',        // success when data deleted
    'FAILED_DELETE_MESSAGE'  => 'Data gagal di simpan', // failed when data deleted
    'FAILED_DELETE_SELF_MESSAGE'            => 'Data gagal di hapus', // failed when logged in user data deleted
    'FAILED_DB_CONSTRAINT_DELETE_MESSAGE'   => 'Data gagal di hapus',   // failed deleted data because of database constraint
    'FAILED_ADMIN_ONLY_1'    => 'Data gagal di hapus',

    // User roles
    'ROLE_ADMIN'    => 1,
    'ROLE_USER'     => 2,

    /**
     * whitelist middleware that we want to restric
     * ex : WHITELISTED_ROUTE_FILTER = ['auth:admin','auth:user']
     * guest:admin for restricting user to access admin login panel
    **/
    'WHITELISTED_ROUTE_FILTER'  =>  ['auth:admin','auth:user','adminUserAuth','guest:admin'],

    /**
     * Trustone Tokyo： 202.215.32.133
     * Trustone Fukushima： 202.215.32.132
	 * Trustone Osaka: 133.175.2.138
	 * Grune Japan: 61.194.74.162
     * VPN Grune Indonesia: 183.180.68.132
     *
     * 'WHITELISTED_IP'=>['202.215.32.133','202.215.32.132','133.175.2.138','183.180.68.132','61.194.74.162'],
     *
    **/
    'WHITELISTED_IP' => false,
    // IP LIMIT TO GIVEN COUNTRY ONLY ['JP','ID']
    'IP_ENABLE_FORM_ACCESS' => false
];
