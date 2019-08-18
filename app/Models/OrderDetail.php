<?php

namespace App\Models;

class OrderDetail extends \App\Models\Base\OrderDetail
{
	protected $fillable = [
		'order_id',
		'produk_id',
		'jumlah',
		'subtotal'
	];
}
