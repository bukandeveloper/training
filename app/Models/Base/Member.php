<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:46:34 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Member
 * 
 * @property int $id
 * @property int $is_online
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $alamat
 * @property string $telp
 * @property \Carbon\Carbon $last_access
 * @property int $admin_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $remember_token
 * 
 * @property \App\Models\Admin $admin
 * @property \Illuminate\Database\Eloquent\Collection $orders
 *
 * @package App\Models\Base
 */
class Member extends Eloquent
{
	protected $casts = [
		'is_online' => 'int',
		'admin_id' => 'int'
	];

	protected $dates = [
		'last_access'
	];

	public function admin()
	{
		return $this->belongsTo(\App\Models\Admin::class);
	}

	public function orders()
	{
		return $this->hasMany(\App\Models\Order::class);
	}
}
