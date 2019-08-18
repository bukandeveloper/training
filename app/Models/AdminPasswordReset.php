<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPasswordReset extends Model
{
	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'email',
		'token'
	];

    public $timestamps = false;
}
