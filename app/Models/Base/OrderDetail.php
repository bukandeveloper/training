<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:47:40 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OrderDetail
 * 
 * @property int $id
 * @property int $order_id
 * @property int $produk_id
 * @property int $jumlah
 * @property int $subtotal
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Order $order
 * @property \App\Models\Produk $produk
 *
 * @package App\Models\Base
 */
class OrderDetail extends Eloquent
{
	protected $casts = [
		'order_id' => 'int',
		'produk_id' => 'int',
		'jumlah' => 'int',
		'subtotal' => 'int'
	];

	public function order()
	{
		return $this->belongsTo(\App\Models\Order::class);
	}

	public function produk()
	{
		return $this->belongsTo(\App\Models\Produk::class);
	}
}
