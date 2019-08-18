<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:47:46 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Page
 * 
 * @property int $id
 * @property string $judul
 * @property string $konten
 * @property int $admin_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Admin $admin
 *
 * @package App\Models\Base
 */
class Page extends Eloquent
{
	protected $casts = [
		'admin_id' => 'int'
	];

	public function admin()
	{
		return $this->belongsTo(\App\Models\Admin::class);
	}
}
