<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:47:19 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Order
 * 
 * @property int $id
 * @property int $total
 * @property int $berat
 * @property int $ongkir
 * @property int $member_id
 * @property int $status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Member $member
 * @property \App\Models\OrderStatus $order_status
 * @property \Illuminate\Database\Eloquent\Collection $order_details
 *
 * @package App\Models\Base
 */
class Order extends Eloquent
{
	protected $casts = [
		'total' => 'int',
		'berat' => 'int',
		'ongkir' => 'int',
		'member_id' => 'int',
		'status_id' => 'int'
	];

	public function member()
	{
		return $this->belongsTo(\App\Models\Member::class);
	}

	public function order_status()
	{
		return $this->belongsTo(\App\Models\OrderStatus::class, 'status_id');
	}

	public function order_details()
	{
		return $this->hasMany(\App\Models\OrderDetail::class);
	}
}
