<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:45:48 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OrderStatus
 * 
 * @property int $id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $orders
 *
 * @package App\Models\Base
 */
class OrderStatus extends Eloquent
{
	public function orders()
	{
		return $this->hasMany(\App\Models\Order::class, 'status_id');
	}
}
