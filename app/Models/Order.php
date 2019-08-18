<?php

namespace App\Models;

class Order extends \App\Models\Base\Order
{
	protected $fillable = [
		'total',
		'berat',
		'ongkir',
		'member_id',
		'status_id'
	];
}
