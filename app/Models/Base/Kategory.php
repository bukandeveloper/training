<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:46:02 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Kategory
 * 
 * @property int $id
 * @property string $nama
 * @property int $admin_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Admin $admin
 * @property \Illuminate\Database\Eloquent\Collection $produks
 *
 * @package App\Models\Base
 */
class Kategory extends Eloquent
{
	protected $casts = [
		'admin_id' => 'int'
	];

	public function admin()
	{
		return $this->belongsTo(\App\Models\Admin::class);
	}

	public function produks()
	{
		return $this->hasMany(\App\Models\Produk::class, 'kategori_id');
	}
}
