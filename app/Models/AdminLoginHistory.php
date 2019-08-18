<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLoginHistory extends Model
{
	protected $fillable = [
		'login_at',
		'email',
		'ip_address',
		'failed_login_at',
		'not_exist_user'
	];

    public $timestamps = false;

    protected $dates = [
        'login_at',
        'failed_login_at'
    ];
}
