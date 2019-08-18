<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:47:12 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Produk
 * 
 * @property int $id
 * @property string $kode_produk
 * @property string $nama
 * @property int $berat
 * @property int $qty
 * @property string $deskripsi
 * @property int $kategori_id
 * @property int $admin_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Admin $admin
 * @property \App\Models\Kategory $kategory
 * @property \Illuminate\Database\Eloquent\Collection $order_details
 *
 * @package App\Models\Base
 */
class Produk extends Eloquent
{
	protected $casts = [
		'berat' => 'int',
		'qty' => 'int',
		'kategori_id' => 'int',
		'admin_id' => 'int'
	];

	public function admin()
	{
		return $this->belongsTo(\App\Models\Admin::class);
	}

	public function kategory()
	{
		return $this->belongsTo(\App\Models\Kategory::class, 'kategori_id');
	}

	public function order_details()
	{
		return $this->hasMany(\App\Models\OrderDetail::class);
	}
}
