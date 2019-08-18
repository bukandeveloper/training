<?php

namespace App\Models;

class Member extends \App\Models\Base\Member
{
	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'is_online',
		'email',
		'password',
		'name',
		'alamat',
		'telp',
		'last_access',
		'admin_id',
		'remember_token'
	];
}
