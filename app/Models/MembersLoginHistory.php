<?php

namespace App\Models;

class MembersLoginHistory extends \App\Models\Base\MembersLoginHistory
{
	protected $fillable = [
		'login_at',
		'email',
		'ip_address',
		'failed_login_at',
		'not_exist_user'
	];
}
